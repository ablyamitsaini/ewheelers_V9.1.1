<?php
class CitiesController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewCities($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditStates($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewCities();
        $search = $this->getSearchForm();
        $this->set("search", $search);
        $this->_template->addJs('js/import-export.js');
        $this->_template->render();
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesArr($this->adminLangId, true);

        $countryFld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->adminLangId), 'country', $countriesArr, '', array("id"=>"country"));
        $countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,0,\'#state\')');

        $frm->addSelectBox(Labels::getLabel('LBL_State', $this->adminLangId), 'state', array(), '', array("id"=>"state"));

        $fld_submit=$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function search()
    {
        $this->objPrivilege->canViewCities();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];

        $post = FatApp::getPostedData();

        $stateId = 0;
        $countryId = 0;
		
		if (isset($post['state'])) {
            $stateId = FatUtility::int($post['state'], 0);
        }
        if (isset($post['country'])) {
            $countryId = FatUtility::int($post['country'], 0);
        }

        $srch = City::getSearchObject(true, $this->adminLangId);
        $stateSrchObj = States::getSearchObject(true, $this->adminLangId);
        $stateSrchObj->doNotCalculateRecords();
        $stateSrchObj->doNotLimitRecords();
        $stateSrchQuery = $stateSrchObj->getQuery();
        $srch->joinTable("($stateSrchQuery)", 'INNER JOIN', 'ct.'.City::DB_TBL_PREFIX.'state_id = st.'.States::tblFld('id'), 'st');

        $countrySearchObj = Countries::getSearchObject(true, $this->adminLangId);
        $countrySearchObj->doNotCalculateRecords();
        $countrySearchObj->doNotLimitRecords();
        $countriesDbView = $countrySearchObj->getQuery();

        $srch->joinTable("($countriesDbView)", 'INNER JOIN', 'ct.'.City::DB_TBL_PREFIX.'country_id = c.'.Countries::tblFld('id'), 'c');

		if (!empty($post['keyword'])) {
            $condition=$srch->addCondition('ct.city_identifier', 'like', '%'.$post['keyword'].'%');
            $condition->attachCondition('ct_l.city_name', 'like', '%'.$post['keyword'].'%', 'OR');
        }
		
        if ($stateId > 0) {
            $srch->addCondition("ct.city_state_id", "=", $stateId);
        }
        if ($countryId > 0) {
            $srch->addCondition("ct.city_country_id", "=", $countryId);
        }

        $page = (empty($page) || $page <= 0)?1:$page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addOrder("city_name", 'ASC');

        $rs = $srch->getResultSet();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }


    public function form($cityId)
    {
        $this->objPrivilege->canEditCities();

        $cityId =  FatUtility::int($cityId);
        $cityCountryId =0;
        $cityStateId = 0;

        $frm = $this->getForm($cityId);

        if ($cityId > 0) {
            $data = City::getAttributesById($cityId, array('city_id','city_country_id','city_state_id','city_identifier','city_active'));
            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $frm->fill($data);
            $cityCountryId = $data['city_country_id'];
            $cityStateId = $data['city_state_id'];
        }

        $this->set("city_country_id", $cityCountryId);
        $this->set("city_state_id", $cityStateId);
        $this->set('languages', Language::getAllNames());
        $this->set('city_id', $cityId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditCities();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $cityId = $post['city_id'];
        unset($post['city_id']);

        $post['city_state_id'] = $_POST['city_state_id'];
        $record = new City($cityId);
        $record->assignValues($post);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $newTabLangId = 0;
        if ($cityId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = City::getAttributesByLangId($langId, $cityId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $cityId = $record->getMainTableRecordId();
            $newTabLangId=FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('cityId', $cityId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($cityId, $lang_id)
    {
        $this->objPrivilege->canViewCities();
        $cityId = FatUtility::int($cityId);
        $lang_id = FatUtility::int($lang_id);

        if ($cityId == 0 || $lang_id == 0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $langFrm = $this->getLangForm($cityId, $lang_id);
        $langData = City::getAttributesByLangId($lang_id, $cityId);

        if (!empty($langData)) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('cityId', $cityId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditCities();
        $post = FatApp::getPostedData();

        $cityId = $post['city_id'];
        $lang_id = $post['lang_id'];

        if ($cityId == 0 || $lang_id == 0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getLangForm($cityId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['city_id']);
        unset($post['lang_id']);

        $data = array(
            'citylang_lang_id'=>$lang_id,
            'citylang_city_id'=>$cityId,
            'city_name'=>$post['city_name']
        );

        $cityObj = new City($cityId);

        if (!$cityObj->updateLangData($lang_id, $data)) {
            Message::addErrorMessage($stateObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = City::getAttributesByLangId($langId, $cityId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('cityId', $cityId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($cityId = 0)
    {
        $this->objPrivilege->canViewCities();
        $cityId =  FatUtility::int($cityId);

        $frm = new Form('frmCity');
        $frm->addHiddenField('', 'city_id', $cityId);
        $frm->addRequiredField(Labels::getLabel('LBL_City_Identifier', $this->adminLangId), 'city_identifier');

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesArr($this->adminLangId, true);

        $countryFld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->adminLangId), 'city_country_id', $countriesArr, '', array(), '');
        $countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,0,\'#city_state_id\')');
        $countryFld->requirements()->setRequired(true);

        $stateFld = $frm->addSelectBox(Labels::getLabel('LBL_State', $this->adminLangId), 'city_state_id', array(), '', array("id"=>"city_state_id"));
        $stateFld->requirements()->setRequired(true);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->adminLangId), 'city_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getLangForm($cityId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewCities();
        $frm = new Form('frmStateLang');
        $frm->addHiddenField('', 'city_id', $cityId);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('LBL_City_Name', $this->adminLangId), 'city_name');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    public function changeStatus()
    {
        $this->objPrivilege->canEditCities();
        $cityId = FatApp::getPostedData('cityId', FatUtility::VAR_INT, 0);
        if (0 >= $cityId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = City::getAttributesById($cityId, array('city_id','city_active'));

        if ($data == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $status = ( $data['city_active'] == applicationConstants::ACTIVE ) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $cityObj = new City($cityId);
        if (!$cityObj->changeStatus($status)) {
            Message::addErrorMessage($cityObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        FatUtility::dieJsonSuccess($this->str_update_record);
    }
}
