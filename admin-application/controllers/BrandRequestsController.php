<?php
class BrandRequestsController extends AdminBaseController {
	private $canView;
	private $canEdit;	
	
	public function __construct($action){
		$ajaxCallArray = array('deleteRecord','form','langForm','search','setup','langSetup');
		if(!FatUtility::isAjaxCall() && in_array($action,$ajaxCallArray)){
			die($this->str_invalid_Action);
		} 
		parent::__construct($action);
		$this->admin_id = AdminAuthentication::getLoggedAdminId();
		$this->canView = $this->objPrivilege->canViewBrandRequests($this->admin_id,true);
		$this->canEdit = $this->objPrivilege->canEditBrandRequests($this->admin_id,true);
		$this->set("canView",$this->canView);
		$this->set("canEdit",$this->canEdit);		
	}
	
	public function index(){
		$this->objPrivilege->canViewBrandRequests();
		$frmSearch = $this->getSearchForm();					
		$this->set("frmSearch",$frmSearch);	
		$this->_template->render();
	}
	
	private function getSearchForm(){
		$frm = new Form('frmBrandReqSearch',array('id'=>'frmBrandReqSearch'));		
		$f1 = $frm->addTextBox(Labels::getLabel('LBL_Keyword',$this->adminLangId), 'keyword','',array('class'=>'search-input'));
		$fld_submit=$frm->addSubmitButton('','btn_submit',Labels::getLabel('LBL_Search',$this->adminLangId));
		$fld_cancel = $frm->addButton("","btn_clear",Labels::getLabel('LBL_Clear_Search',$this->adminLangId),array('onclick'=>'clearBrandRequestSearch();'));
		$fld_submit->attachField($fld_cancel);		
		return $frm;
	}
	
	public function search(){
		$this->objPrivilege->canViewBrandRequests();
		
		$pagesize=FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);				
		$searchForm = $this->getSearchForm();
		$data = FatApp::getPostedData();
		$page = (empty($data['page']) || $data['page'] <= 0)?1:$data['page'];
		$post = $searchForm->getFormDataFromArray($data);
		
		/* $brandReqObj = new BrandRequest(); */
		$srch = BrandRequest::getSearchObject($this->adminLangId);
		$srch->addFld('br.*');
		
		if(!empty($post['keyword'])){
			$srch->addCondition('br.sbrandreq_identifier','like','%'.$post['keyword'].'%');
		}
		
		$page = (empty($page) || $page <= 0)?1:$page;
		$page = FatUtility::int($page);
		$srch->setPageNumber($page);
		$srch->setPageSize($pagesize);
		
		$srch->addMultipleFields(array("br_l.sbrandreq_name"));
		
		$rs = $srch->getResultSet();
		$records =array();
		if($rs){
			$records = FatApp::getDb()->fetchAll($rs);			
		}
		
		$this->set("arr_listing",$records);
		$this->set('pageCount',$srch->pages());
		$this->set('recordCount',$srch->recordCount());
		$this->set('page', $page);
		$this->set('pageSize', $pagesize);
		$this->set('postedData', $post);						
		$this->_template->render(false, false);	
	}
	
	public function setup(){
		$this->objPrivilege->canEditBrandRequests();

		$frm = $this->getForm();
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
		if (false === $post) {			
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
		}

		$brandReqId = $post['sbrandreq_id'];
		unset( $post['sbrandreq_id'] );
		
		$record = new BrandRequest($brandReqId);		
		$record->assignValues($post);
		
		if (!$record->save()) {
			Message::addErrorMessage(Labels::getLabel('MSG_This_identifier_is_not_available._Please_try_with_another_one.',$this->adminLangId));
			FatUtility::dieJsonError( Message::getHtml() );			
		}
		
		$newTabLangId = 0;	
		if( $brandReqId > 0 ){
			$languages = Language::getAllNames();	
			foreach($languages as $langId =>$langName ){			
				if( !$row = BrandRequest::getAttributesByLangId( $langId, $brandReqId ) ){
					$newTabLangId = $langId;
					break;
				}
			}
		} else {
			$brandReqId = $record->getMainTableRecordId();
			$newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);	
		}
		
		
		$this->set('msg', Labels::getLabel('LBL_Brand_Request_Setup_Successful',$this->adminLangId));
		$this->set('brandReqId', $brandReqId);
		$this->set('langId', $newTabLangId); 
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function langSetup(){
		$this->objPrivilege->canEditBrandRequests();
		$post=FatApp::getPostedData();
		
		$brandReqId = $post['sbrandreq_id'];
		$lang_id = $post['lang_id'];
		
		if($brandReqId == 0 || $lang_id == 0){
			Message::addErrorMessage($this->str_invalid_request_id);
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$frm = $this->getLangForm($brandReqId,$lang_id);
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		unset($post['brandReqId']);
		unset($post['lang_id']);
		$data = array(
			'sbrandreqlang_lang_id'=>$lang_id,
			'sbrandreqlang_sbrandreq_id'=>$brandReqId,
			'sbrandreq_name'=>$post['sbrandreq_name'],
		);
		$brandReqObj=new BrandRequest($brandReqId);	
		if(!$brandReqObj->updateLangData($lang_id,$data)){
			Message::addErrorMessage($brandReqObj->getError());
			FatUtility::dieJsonError( Message::getHtml() );					
		}

		$newTabLangId=0;	
		$languages=Language::getAllNames();	
		foreach($languages as $langId =>$langName ){			
			if(!$row=BrandRequest::getAttributesByLangId($langId,$brandReqId)){
				$newTabLangId = $langId;
				break;
			}			
		}
		
		
		$this->set('msg', Labels::getLabel('LBL_Brand_Request_Setup_Successful',$this->adminLangId));
		$this->set('brandReqId', $brandReqId);
		$this->set('langId', $newTabLangId);
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function form($brandReqId=0){
		$this->objPrivilege->canEditBrandRequests();
	
		$brandReqId=FatUtility::int($brandReqId);
		$frm = $this->getForm($brandReqId);

		if ( 0 < $brandReqId ) {
			$data = BrandRequest::getAttributesById($brandReqId,array('sbrandreq_id','sbrandreq_identifier','sbrandreq_seller_id'));			
			if ($data === false) {
				FatUtility::dieWithError($this->str_invalid_request);
			}
			$frm->fill($data);
		}
	
		$this->set('languages', Language::getAllNames());
		$this->set('brandReqId', $brandReqId);
		$this->set('frmBrandReq', $frm);
		$this->_template->render(false, false);
	}	

	private function getForm($brandReqId=0){
		$this->objPrivilege->canEditBrandRequests();		
		$brandReqId=FatUtility::int($brandReqId);
		
		$frm = new Form('frmBrandReq',array('id'=>'frmBrandReq'));		
		$frm->addHiddenField('', 'sbrandreq_id',$brandReqId);
		$frm->addHiddenField('', 'sbrandreq_seller_id',$brandReqId);
		$frm->addRequiredField(Labels::getLabel('LBL_Brand_Request_Identifier',$this->adminLangId), 'sbrandreq_identifier');										
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Save_Changes',$this->adminLangId));		
		return $frm;		
	}	
	
	public function langForm($brandReqId=0,$lang_id=0){		
		$this->objPrivilege->canEditBrandRequests();
		
		$brandReqId = FatUtility::int($brandReqId);
		$lang_id = FatUtility::int($lang_id);
		
		if($brandReqId==0 || $lang_id==0){
			FatUtility::dieWithError($this->str_invalid_request);
		}
		
		$brandReqLangFrm = $this->getLangForm($brandReqId,$lang_id);
			
		$langData = BrandRequest::getAttributesByLangId( $lang_id, $brandReqId );		
		
		if($langData){
			$brandReqLangFrm->fill($langData);			
		}
		
		$this->set('languages', Language::getAllNames());
		$this->set('brandReqId', $brandReqId);
		$this->set('sbrandreq_lang_id', $lang_id);
		$this->set('brandReqLangFrm', $brandReqLangFrm);
		$this->set('formLayout',Language::getLayoutDirection($lang_id));
		$this->_template->render(false, false);	
	}
	public function langRequestForm($brandReqId=0,$lang_id=0){		
		$this->objPrivilege->canEditBrandRequests();
		
		$brandReqId = FatUtility::int($brandReqId);
		$lang_id = FatUtility::int($lang_id);
		
		if($brandReqId==0 || $lang_id==0){
			FatUtility::dieWithError($this->str_invalid_request);
		}
		
		$brandReqLangFrm = $this->getLangForm($brandReqId,$lang_id);
			
		$langData = BrandRequest::getAttributesByLangId( $lang_id, $brandReqId );		
		
		if($langData){
			$brandReqLangFrm->fill($langData);			
		}
		
		$this->set('languages', Language::getAllNames());
		$this->set('brandReqId', $brandReqId);
		$this->set('sbrandreq_lang_id', $lang_id);
		$this->set('brandReqLangFrm', $brandReqLangFrm);
		$this->set('formLayout',Language::getLayoutDirection($lang_id));
		$this->_template->render(false, false);	
	}
	
	private function getLangForm($brandReqId=0,$lang_id=0){			
		$frm = new Form('frmBrandReqLang',array('id'=>'frmBrandReqLang'));		
		$frm->addHiddenField('', 'sbrandreq_id',$brandReqId);
		$frm->addHiddenField('', 'lang_id',$lang_id);
		$frm->addRequiredField(Labels::getLabel('LBL_Brand_Request_Name',$this->adminLangId), 'sbrandreq_name');		
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Update',$this->adminLangId));
		return $frm;
	}
	
	public function deleteRecord(){
		$this->objPrivilege->canEditBrandRequests();
		
		$brandReqId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
		if( $brandReqId < 1 ){
			Message::addErrorMessage($this->str_invalid_request_id);
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$brandReqObj = new BrandRequest($brandReqId);
		if( !$brandReqObj->canRecordDelete($brandReqId) ){
			Message::addErrorMessage($this->str_invalid_request_id);
			FatUtility::dieJsonError( Message::getHtml() );
		}
		
		
		if( !$brandReqObj->deleteRecord( true ) ){
			Message::addErrorMessage($brandReqObj->getError());
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		//FatUtility::dieJsonSuccess($this->str_delete_record);	
		$this->set('msg',$this->str_delete_record);
		$this->_template->render(false,false,'json-success.php');
	}
	
	function autoComplete(){
		$pagesize = 10;
		$post = FatApp::getPostedData();
		$this->objPrivilege->canViewBrandRequests();
		
		$srch = BrandRequests::getSearchObject();
		$srch->addOrder('brandReqIdentifier');
		$srch->joinTable(BrandRequests::DB_TBL . '_lang', 'LEFT OUTER JOIN',
		'sbrandreqlang_brandReqId = brandReqId AND sbrandreqlang_lang_id = ' . $this->adminLangId);
		$srch->addMultipleFields(array('brandReqId, sbrandreq_name, brandReqIdentifier'));		
		
		if ( !empty($post['keyword']) ) {
			$cnd = $srch->addCondition('sbrandreq_name', 'LIKE', '%' . $post['keyword'] . '%');
			$cnd->attachCondition('brandReqIdentifier', 'LIKE', '%'. $post['keyword'] . '%', 'OR');
		}
		
		$srch->setPageSize($pagesize);
		$rs = $srch->getResultSet();
		$db = FatApp::getDb();
		$options = array();
		if($rs){
			$options = $db->fetchAll($rs,'brandReqId');
		}
		$json = array();
		foreach( $options as $key => $option ){
			$json[] = array(
				'id' => $key,
				'name'      => strip_tags(html_entity_decode($option['sbrandreq_name'], ENT_QUOTES, 'UTF-8')),
				'brandReqIdentifier'    => strip_tags(html_entity_decode($option['brandReqIdentifier'], ENT_QUOTES, 'UTF-8'))
			);
		}
		die(json_encode($json));
	}
	
	public function updateBrandRequestForm($requestId){
		$this->objPrivilege->canEditBrandRequests();
		$requestId = FatUtility::int($requestId);
		
		if(1 > $requestId){
			Message::addErrorMessage($this->str_invalid_request_id);
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$data=array('requestId'=>$requestId);
		$frm = $this->brandRequestForm();
		$frm->fill($data);
		$this->set('frm',$frm);		
		$this->_template->render(false,false);
	}
	
	private function brandRequestForm(){
		
		$frm = new Form('brandRequestForm');
		
		$statusArr = BrandRequest::getBrandReqStatusArr($this->adminLangId);
		unset($statusArr[BrandRequest::BRAND_REQUEST_PENDING]);
		$frm->addSelectBox(Labels::getLabel('LBL_Status',$this->adminLangId), 'status',$statusArr,'')->requirements()->setRequired();
		$frm->addHiddenField('','requestId',0);
		$frm->addTextArea('', 'comments', '');		
		$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Update',$this->adminLangId));
		return $frm;
	}
	
	public function updateBrandRequest(){
		$this->objPrivilege->canEditBrandRequests();

		$frm = $this->brandRequestForm();
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
		if (false === $post) {			
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
		}

		$srequest_id = $post['requestId'];
		unset($post['requestId']);
		
		$breqObj = new BrandRequest();
		$srch = $breqObj->getAttributesById($srequest_id);
		$srch->doNotCalculateRecords();
		$srch->setPageSize(1);
		
		$rs = $srch->getResultSet();
		if(!$rs){
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieJsonError( Message::getHtml() );	
		}	
			
		$sBrandRequest = FatApp::getDb()->fetch($rs);	
		
		if($sBrandRequest==false) {
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$statusArr = array(BrandRequest::BRAND_REQUEST_APPROVED,BrandRequest::BRAND_REQUEST_CANCELLED); 
		
		if(!in_array($post['status'],$statusArr)){ 
			Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Status_Request',$this->adminLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if(in_array($post['status'],$statusArr)&& in_array($sBrandRequest['sbrandreq_status'],$statusArr)){
			Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Status_Request',$this->adminLangId));
			FatUtility::dieWithError( Message::getHtml() );	
		}
		
		$db = FatApp::getDb();
		$db->startTransaction();
		
		if (!in_array($supplierRequest['sbrandreq_status'],$statusArr) && in_array($post['status'],$statusArr)) {
			$post['request_id'] = $supplierRequest['sbrandreq_id'] ;
			if(!$breqObj->updateBrandRequest($post)){
				$db->rollbackTransaction();
				Message::addErrorMessage($userObj->getError());
				FatUtility::dieWithError( Message::getHtml() );
			}
		}
		
		if($post['status'] == BrandRequest::BRAND_REQUEST_APPROVED && $sBrandRequest['sbrandreq_status'] != BrandRequest::BRAND_REQUEST_APPROVED){
			
			if(!$breqObj->addBrand($supplierRequest['sbrandreq_id'])){
				$db->rollbackTransaction();
				Message::addErrorMessage($userObj->getError());
				FatUtility::dieWithError( Message::getHtml() );
			}			
		}
		
		$email = new EmailHandler();		
		$sBrandRequest['sbrandreq_status'] = $post['status'];	
		$sBrandRequest['sbrandreq_comments'] = $post['comments'];	
		
		if(!$email->SendSellerRequestStatusChangeNotification($this->adminLangId,$sBrandRequest)){
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel('LBL_Email_Could_Not_Be_Sent',$this->adminLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$db->commitTransaction();
		$this->set('msg', Labels::getLabel('LBL_Status_Updated_Successfully',$this->adminLangId));
		$this->_template->render(false, false, 'json-success.php');
	}
}