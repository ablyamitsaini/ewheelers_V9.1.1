<?php
class FiltersController extends AdminBaseController
{
    private $canView;
    private $canEdit;    
    
    public function __construct($action)
    {
        $ajaxCallArray = array('deleteRecord','form','langForm','search','setup','langSetup');
        if(!FatUtility::isAjaxCall() && in_array($action, $ajaxCallArray)) {
            die($this->str_invalid_Action);
        } 
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewFilters($this->admin_id);
        $this->canEdit = $this->objPrivilege->canEditFilters($this->admin_id);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);         
    }

    public function index($filtergroup_id=0) 
    {
        
        $this->objPrivilege->canViewFilters();
        
        $filtergroup_id=FatUtility::int($filtergroup_id);
        if($filtergroup_id <= 0) {FatUtility::dieWithError($this->str_invalid_request_id); 
        }
        
        $filterGroupdata = FilterGroup::getAttributesById($filtergroup_id, array('filtergroup_id','filtergroup_identifier'));            
        if ($filterGroupdata === false) {
            FatUtility::dieWithError($this->str_invalid_request_id);
        }
        
        $search = $this->getSearchForm($filtergroup_id);                    
        $this->set("search", $search); 
        $this->set("filtergroup_id", $filtergroup_id); 
        $this->set("filterGroupdata", $filterGroupdata); 
        $this->_template->render();
    }
    
    private function getSearchForm($filtergroup_id=0)
    {
        $frm = new Form('frmSearch', array('id'=>'frmSearch'));        
        $frm->addHiddenField('', 'filtergroup_id', $filtergroup_id);
        $f1 = $frm->addTextBox(Labels::getLabel('LBL_Filter_Identifier', $this->adminLangId), 'filter_identifier', '', array('class'=>'search-input'));
        $fld_submit=$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick'=>'clearSearch();'));
        $fld_submit->attachField($fld_cancel);            
        return $frm;
    }
    
    public function search()
    {
        $this->objPrivilege->canViewFilters();
        
        $pagesize=FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);        
        $data = FatApp::getPostedData();
        $filtergroup_id=FatUtility::int($data['filtergroup_id']);
        if($filtergroup_id <= 0) {FatUtility::dieWithError($this->str_invalid_request_id); 
        }
        
        $searchForm = $this->getSearchForm($filtergroup_id);
        $page = (empty($data['page']) || $data['page'] <= 0)?1:$data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        
        $filterObj = new Filter();
        $srch = $filterObj->getSearchObject();
        $srch->addFld('f.*');
        
        $srch->addCondition('f.filter_filtergroup_id', '=', $filtergroup_id);
        if(!empty($post['filter_identifier'])) {
            $srch->addCondition('f.filter_identifier', 'like', '%'.$post['filter_identifier'].'%');
        }
        
        $page = (empty($page) || $page <= 0)?1:$page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        
        $srch->joinTable(
            Filter::DB_TBL . '_lang', 'LEFT OUTER JOIN',
            'filterlang_filter_id = f.filter_id AND filterlang_lang_id = ' . FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1), 'fl'
        );
        /* $srch->joinTable(FilterGroup::DB_TBL, 'INNER JOIN',
        'fg.filtergroup_id = f.filter_filtergroup_id','fg'); */
        $srch->addMultipleFields(array("fl.filter_name"));
        
        $rs = $srch->getResultSet();
        
        $pageCount = $srch->pages();
        $records =array();
        if($rs) {
            $records = FatApp::getDb()->fetchAll($rs);            
        }
        $this->set('recordCount', $srch->recordCount());
        $this->set("arr_listing", $records);
        $this->set('pageCount', $pageCount);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);                        
        $this->_template->render(false, false);    
    }
    
    public function setup()
    {
        $this->objPrivilege->canEditFilters();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());    
        }

        $filtergroup_id = FatUtility::int($post['filter_filtergroup_id']);
        $filter_id = FatUtility::int($post['filter_id']);
        unset($post['filter_id']);        
                
        if (0 < $filter_id ) {
            $filterObj= new Filter();
            $data = $filterObj->getAttributesByIdAndGroupId($filtergroup_id, $filter_id, array('filter_id'));    
            if ($data === false) {
                Message::addErrorMessage($this->str_invalid_request_id);
                FatUtility::dieJsonError(Message::getHtml());                
            }
        }
        
        $record = new Filter($filter_id);        
        $record->assignValues($post);
        
        if (!$record->save()) {             
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        
        $newTabLangId=0;    
        if($filter_id>0) {            
            $languages=Language::getAllNames();    
            foreach($languages as $langId =>$langName ){            
                if(!$row=Filter::getAttributesByLangId($langId, $filter_id)) {
                    $newTabLangId = $langId;
                    break;
                }            
            }    
        }else{
            $filter_id = $record->getMainTableRecordId();
            $newTabLangId=FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);    
        }    
        
        $this->set('msg', Labels::getLabel('MSG_Filter_Setup_Successful', $this->adminLangId));
        $this->set('filterId', $filter_id);
        $this->set('filterGroupId', $filtergroup_id);
        $this->set('langId', $newTabLangId); 
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function langSetup()
    {
        $this->objPrivilege->canEditFilters();
    
        $frm = $this->getLangForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        $filter_id = FatUtility::int($post['filter_id']);
        $lang_id = FatUtility::int($post['lang_id']);
        $filtergroup_id = FatUtility::int($post['filtergroup_id']);
        
        if($filter_id==0 || $lang_id==0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());    
        }
        
        $data=array(
        'filterlang_lang_id'=>$lang_id,
        'filterlang_filter_id'=>$filter_id,
        'filter_name'=>$post['filter_name'],
        );
        
        $filterObj=new Filter($filter_id);    
        if(!$filterObj->updateLangData($lang_id, $data)) {
            Message::addErrorMessage($filterObj->getError());
            FatUtility::dieWithError(Message::getHtml());            
        }

        $newTabLangId=0;    
        $languages=Language::getAllNames();    
        foreach($languages as $langId =>$langName ){            
            if(!$row=Filter::getAttributesByLangId($langId, $filter_id)) {
                $newTabLangId = $langId;
                break;
            }            
        }    
    
        $this->set('msg', Labels::getLabel('MSG_Filter_Setup_Successful', $this->adminLangId));
        $this->set('filterId', $filter_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function form($filtergroup_id,$filter_id=0)
    {
        $this->objPrivilege->canEditFilters();
        
        $filtergroup_id=FatUtility::int($filtergroup_id);
        if($filtergroup_id <= 0) {FatUtility::dieWithError($this->str_invalid_request_id); 
        }
        
        $filter_id=FatUtility::int($filter_id);
        $filterFrm = $this->getForm($filtergroup_id, $filter_id);

        if (0 < $filter_id ) {
            $filterObj= new Filter();
            $data = $filterObj->getAttributesByIdAndGroupId($filtergroup_id, $filter_id, array('filter_id','filter_filtergroup_id','filter_identifier'));            
            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $filterFrm->fill($data);
        }
    
        $this->set('languages', Language::getAllNames());
        $this->set('filter_id', $filter_id);
        $this->set('filtergroup_id', $filtergroup_id);
        $this->set('filterFrm', $filterFrm);
        $this->_template->render(false, false);
    }
    
    private function getForm($filtergroup_id=0,$filter_id=0)
    {
        $this->objPrivilege->canEditFilters();        
        $filtergroup_id=FatUtility::int($filtergroup_id);
        $filter_id=FatUtility::int($filter_id);
                    
        $frm = new Form('frmFilter', array('id'=>'frmFilter'));        
        $frm->addHiddenField('', 'filter_id', $filter_id);
        $frm->addHiddenField('', 'filter_filtergroup_id', $filtergroup_id);
        $frm->addRequiredField(Labels::getLabel('LBL_Filter_Identifier', $this->adminLangId), 'filter_identifier');        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));        
        return $frm;
    }
    
    public function langForm($filter_id=0,$lang_id=0)
    {        
        $this->objPrivilege->canEditFilters();
        
        $filter_id = FatUtility::int($filter_id);
        $lang_id = FatUtility::int($lang_id);
        
        if($filter_id==0 || $lang_id==0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }
        
        $data=Filter::getAttributesById($filter_id);
        if($data==false) {
            FatUtility::dieWithError($this->str_invalid_request_id);
        }
        $filtergroup_id=$data['filter_filtergroup_id'];
        
        $filterLangFrm = $this->getLangForm($filter_id, $lang_id);
        $langData = Filter::getAttributesByLangId($lang_id, $filter_id);        
        
        $langData['filtergroup_id']=$filtergroup_id;        
        if($langData) {
            $filterLangFrm->fill($langData);            
        }
        
        $this->set('languages', Language::getAllNames());
        $this->set('filter_id', $filter_id);
        $this->set('filtergroup_id', $filtergroup_id);
        $this->set('filter_lang_id', $lang_id);
        $this->set('filterLangFrm', $filterLangFrm);
        $this->_template->render(false, false);
    }
    
    private function getLangForm($filter_id=0,$lang_id=0)
    {            
        $frm = new Form('frmFilterLang', array('id'=>'frmFilterLang'));        
        $frm->addHiddenField('', 'filter_id', $filter_id);
        $frm->addHiddenField('', 'filtergroup_id', 0);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('LBL_Brand_Name', $this->adminLangId), 'filter_name');        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Update', $this->adminLangId));
        return $frm;
    }
    
    public function deleteRecord()
    {
        $this->objPrivilege->canEditFilters();
        
        $filter_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if($filter_id < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $filterObj = new Filter($filter_id);
        if(!$filterObj->canRecordMarkDelete($filter_id)) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());                
        }
        $filterObj->assignValues(array(Filter::tblFld('deleted') => 1));
        if(!$filterObj->save()) {
            Message::addErrorMessage($filterObj->getError());
            FatUtility::dieJsonError(Message::getHtml());                
        }
        FatUtility::dieJsonSuccess($this->str_delete_record);        
    }
    
    public function getBreadcrumbNodes($action) 
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch($action)
        {
        case 'index':                 
            $nodes[] = array('title'=>Labels::getLabel('LBL_Filter_Groups', $this->adminLangId), 'href'=>CommonHelper::generateUrl('FilterGroups'));            
            if (isset($parameters[0]) && $parameters[0] > 0) {
                $filterGroupId=FatUtility::int($parameters[0]);
                $filerData=FilterGroup::getAttributesById($filterGroupId);                    
            }
            $nodes[] = array('title'=>$filerData['filtergroup_identifier']);                
            break;
        }            
        return $nodes;                
    }
}
