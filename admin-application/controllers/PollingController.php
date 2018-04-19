<?php
class PollingController extends AdminBaseController {
	private $canView;
	private $canEdit;
	
	public function __construct($action){
		parent::__construct($action);
		$this->admin_id = AdminAuthentication::getLoggedAdminId();
		$this->canView = $this->objPrivilege->canViewPolling($this->admin_id,true);
		$this->canEdit = $this->objPrivilege->canEditPolling($this->admin_id,true);
		$this->set( "canView", $this->canView );
		$this->set( "canEdit", $this->canEdit );		
	}
	
	public function index() {
		$this->objPrivilege->canViewPolling();	
		$frmSearch = $this->getSearchForm();
		$this->set('frmSearch',$frmSearch);	
		$this->_template->render();
	}
	
	public function search(){
		$this->objPrivilege->canViewPolling();
		$pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);	
		
		$searchForm = $this->getSearchForm();
		$data = FatApp::getPostedData();
		$page = (empty($data['page']) || $data['page'] <= 0)?1:$data['page'];
		$post = $searchForm->getFormDataFromArray($data);
		
		$srch = Polling::getSearchObject( $this->adminLangId ,false , true);
		$srch->addMultipleFields( array('polling_id', 'IFNULL( polling_question, polling_identifier ) as polling_question', 'polling_active', 'polling_type', 'polling_start_date', 'polling_end_date','pollfeedback_polling_id','count_yes','count_no','count_maybe' ) );
		$srch->addOrder( 'polling_active', 'DESC');
		$srch->addOrder('polling_question','ASC');
		$page = (empty($page) || $page <= 0)?1:$page;
		$page = FatUtility::int($page);
		$srch->setPageNumber($page);
		$srch->setPageSize($pagesize);
		
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAll( $rs );
		
		$this->set("arr_listing",$records);
		$this->set('pageCount',$srch->pages());
		$this->set('recordCount',$srch->recordCount());
		$this->set('page', $page);
		$this->set('pageSize', $pagesize);
		$this->set('postedData', $post);									
		$this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr( $this->adminLangId ));						
		$this->_template->render(false, false);	
	}
	
	public function form( $polling_id = 0 ){
		$this->objPrivilege->canEditPolling();
		
		$polling_id=FatUtility::int($polling_id);
		$pollingFrm = $this->getForm( );

		if ( 0 < $polling_id ) {
			$data = Polling::getAttributesById( $polling_id,array( 'polling_id', 'polling_identifier', 'polling_active',
			'polling_start_date', 'polling_end_date', 'polling_type') );			
			if ( $data === false ) {
				FatUtility::dieWithError($this->str_invalid_request);
			}
			$pollingFrm->fill( $data );
			$this->set('polling_type', $data['polling_type']);
		}
	
		$this->set('languages', Language::getAllNames());
		$this->set('polling_id', $polling_id);
		$this->set('pollingFrm', $pollingFrm);
		$this->_template->render( false, false );
	}
	
	public function setup(){
		$this->objPrivilege->canEditPolling();
		$frm = $this->getForm();
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
		if ( false === $post ) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
		}

		$polling_id = $post['polling_id'];
		unset($post['polling_id']);
		
		$record = new Polling($polling_id);
		$record->assignValues($post);
		
		if (!$record->save()) {
			Message::addErrorMessage($record->getError());
			FatUtility::dieJsonError( Message::getHtml() );
		}
		
		$newTabLangId = 0;	
		if( $polling_id > 0 ){
			$pollingId = $polling_id;
			$languages=Language::getAllNames();	
			foreach( $languages as $langId =>$langName ){
				if( !$row = Polling::getAttributesByLangId($langId,$polling_id)){
					$newTabLangId = $langId;
					break;
				}			
			}	
		} else {
			$pollingId = $record->getMainTableRecordId();
			$newTabLangId=FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);	
		}	
		
		$this->set('msg', Labels::getLabel('LBL_Polling_Setup_Successful',$this->adminLangId));
		$this->set('pollingId', $pollingId);
		$this->set('langId', $newTabLangId); 
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function langForm( $polling_id = 0, $lang_id = 0 ){
		$this->objPrivilege->canEditPolling();
		
		$polling_id = FatUtility::int($polling_id);
		$lang_id = FatUtility::int($lang_id);
		
		if( $polling_id == 0 || $lang_id == 0 ){
			FatUtility::dieWithError($this->str_invalid_request);
		}
		
		$pollingLangFrm = $this->getLangForm( $polling_id, $lang_id );
		$langData = Polling::getAttributesByLangId($lang_id,$polling_id);		
		
		if( $langData ){
			$pollingLangFrm->fill($langData);			
		}
		
		$data = Polling::getAttributesById( $polling_id,array( 'polling_id', 'polling_identifier', 'polling_active',
		'polling_start_date', 'polling_end_date', 'polling_type') );
		
		$this->set('polling_type', $data['polling_type']);
		$this->set('languages', Language::getAllNames());
		$this->set('polling_id', $polling_id);
		$this->set('polling_lang_id', $lang_id);
		$this->set('pollingLangFrm', $pollingLangFrm);
		$this->set('formLayout',Language::getLayoutDirection($lang_id));
		$this->_template->render(false, false);
	}
	
	public function langSetup(){
		$this->objPrivilege->canEditPolling();
		$post = FatApp::getPostedData();
		
		$polling_id = FatApp::getPostedData('polling_id', FatUtility::VAR_INT, 0 ); 
		$lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0 );
		
		if( $polling_id == 0 || $lang_id == 0 ){
			Message::addErrorMessage( $this->str_invalid_request_id );
			FatUtility::dieWithError( Message::getHtml() );	
		}
		
		$frm = $this->getLangForm( $polling_id, $lang_id );
		$post = $frm->getFormDataFromArray( FatApp::getPostedData() );
		unset( $post['polling_id'] );
		unset( $post['lang_id'] );
		$data = array(
			'pollinglang_lang_id'=>$lang_id,
			'pollinglang_polling_id'=>$polling_id,
			'polling_question'=>$post['polling_question'],
		);
		
		$pollingObj = new Polling( $polling_id );	
		if( !$pollingObj->updateLangData( $lang_id, $data ) ){
			Message::addErrorMessage( $pollingObj->getError() );
			FatUtility::dieWithError( Message::getHtml() );				
		}

		$newTabLangId = 0;	
		$languages = Language::getAllNames();	
		foreach( $languages as $langId =>$langName ){			
			if( !$row = Polling::getAttributesByLangId( $langId, $polling_id )){
				$newTabLangId = $langId;
				break;
			}			
		}
		$pollingData = Polling::getAttributesById( $polling_id,array('polling_type') );
		
		$this->set('msg', Labels::getLabel('LBL_Polling_Setup_Successful',$this->adminLangId));
		$this->set('openLinksForm', ($pollingData['polling_type'] != Polling::POLLING_TYPE_GENERIC));
		$this->set('pollingId', $polling_id);
		$this->set('langId', $newTabLangId);
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function linksForm( $polling_id ){
		$this->objPrivilege->canEditPolling();
		
		$polling_id=FatUtility::int($polling_id);
		if ( 0 >= $polling_id ) {
			FatUtility::dieJsonError($this->str_invalid_request_id);
		}
		$data = Polling::getAttributesById( $polling_id,array( 'polling_id', 'polling_identifier', 'polling_active',
		'polling_start_date', 'polling_end_date', 'polling_type') );
		if ( $data === false ) {
			FatUtility::dieWithError($this->str_invalid_request);
		}
		$linksFrm = $this->getLinkForm($polling_id);
		
		$this->set('languages', Language::getAllNames());
		$this->set('polling_id', $polling_id);
		$this->set('polling_type', $data['polling_type']);
		$this->set('linksFrm', $linksFrm);
		$this->_template->render( false, false );
	}
	
	function linkedCategories( $polling_id ){
		$this->objPrivilege->canViewPolling();
		$polling_id = FatUtility::int($polling_id);
		if( $polling_id == 0){
			FatUtility::dieWithError($this->str_invalid_request);
		}
		$linkedCategories = Polling::getLinkedCategories( $polling_id, $this->adminLangId , false );
		$this->set('linkedCategories',$linkedCategories);
		$this->set('polling_id',$polling_id);
		$this->_template->render(false, false);
	}
	
	function updateLinkedCategories(){
		$this->objPrivilege->canEditPolling();
		$post = FatApp::getPostedData();
		if ( false === $post ) {
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$polling_id = FatUtility::int($post['polling_id']);
		$prodcat_id = FatUtility::int($post['prodcat_id']);
		if( !$polling_id || !$prodcat_id ){
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$pollObj = new Polling();
		if( !$pollObj->addUpdatePollingCategory($polling_id, $prodcat_id ) ){
			Message::addErrorMessage( Labels::getLabel($pollObj->getError(),$this->adminLangId) );
			FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('msg',Labels::getLabel('LBL_Record_Updated_Successfully',$this->adminLangId));
		$this->_template->render(false, false, 'json-success.php');
	}
	
	function removeLinkedCategory(){
		$this->objPrivilege->canEditPolling();
		$post = FatApp::getPostedData();
		if ( false === $post ) {
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$polling_id = FatUtility::int($post['polling_id']);
		$prodcat_id = FatUtility::int($post['prodcat_id']);
		if( !$polling_id || !$prodcat_id ){
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$pollObj = new Polling();
		if( !$pollObj->removePollingCategory($polling_id, $prodcat_id ) ){
			Message::addErrorMessage( Labels::getLabel($pollObj->getError(),$this->adminLangId) );
			FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('msg', Labels::getLabel('LBL_Category_Removed_Successfully',$this->adminLangId));
		$this->_template->render(false, false, 'json-success.php');
	}
	
	function linkedProducts( $polling_id ){
		$this->objPrivilege->canViewPolling();
		$polling_id = FatUtility::int($polling_id);
		if( $polling_id == 0){
			FatUtility::dieWithError($this->str_invalid_request);
		}
		$linkedProducts = Polling::getLinkedProducts( $polling_id, $this->adminLangId ,false );
		$this->set('linkedProducts',$linkedProducts);
		$this->set('polling_id',$polling_id);
		$this->_template->render(false, false);
	}
	
	function updateLinkedProducts(){
		$this->objPrivilege->canEditPolling();
		$post = FatApp::getPostedData();
		if ( false === $post ) {
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$polling_id = FatUtility::int($post['polling_id']);
		$product_id = FatUtility::int($post['product_id']);
		if( !$polling_id || !$product_id ){
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$pollObj = new Polling();
		if( !$pollObj->addUpdatePollingProduct($polling_id, $product_id ) ){
			Message::addErrorMessage( Labels::getLabel($pollObj->getError(),$this->adminLangId) );
			FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('msg',Labels::getLabel('LBL_Record_Updated_Successfully',$this->adminLangId));
		$this->_template->render(false, false, 'json-success.php');
	}
	
	function removeLinkedProduct(){
		$this->objPrivilege->canEditPolling();
		$post = FatApp::getPostedData();
		if ( false === $post ) {
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$polling_id = FatUtility::int($post['polling_id']);
		$product_id = FatUtility::int($post['product_id']);
		if( !$polling_id || !$product_id ){
			Message::addErrorMessage($this->str_invalid_request);
			FatUtility::dieWithError(Message::getHtml());
		}
		$pollObj = new Polling();
		if( !$pollObj->removePollingProduct($polling_id, $product_id ) ){
			Message::addErrorMessage( Labels::getLabel($pollObj->getError(),$this->adminLangId) );
			FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('msg',Labels::getLabel('LBL_Product_Removed_Successfully',$this->adminLangId));
		$this->_template->render(false, false, 'json-success.php');
	}
	
	private function getForm(){
		$frm = new Form('frmPolling',array('id'=>'frmPolling'));		
		$frm->addHiddenField('', 'polling_id');
		$frm->addRequiredField(Labels::getLabel('LBL_Polling_Identifier',$this->adminLangId), 'polling_identifier');
		$frm->addSelectBox( Labels::getLabel('LBL_Polling_Type',$this->adminLangId), 'polling_type', Polling::getPollingTypeArr($this->adminLangId) )->requirements()->setRequired();
		$frm->addDateField( Labels::getLabel('LBL_Start_Date',$this->adminLangId), 'polling_start_date' )->requirements()->setRequired();
		$frm->addDateField( Labels::getLabel('LBL_End_Date',$this->adminLangId), 'polling_end_date' )->requirements()->setRequired();
		$activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);
		$frm->addSelectBox(Labels::getLabel('LBL_Polling_Status',$this->adminLangId), 'polling_active', $activeInactiveArr, '',array('class'=>'small'),'');
		$frm->addSubmitButton('', 'btn_submit');		
		return $frm;
	}
	
	private function getLangForm( $polling_id, $lang_id ){
		$frm = new Form( 'frmPollingLang', array('id'=>'frmPollingLang') );		
		$frm->addHiddenField( '', 'polling_id', $polling_id );
		$frm->addHiddenField( '', 'lang_id', $lang_id);
		$frm->addRequiredField( Labels::getLabel('LBL_Polling_Question',$this->adminLangId), 'polling_question' );
		$frm->addSubmitButton( '', 'btn_submit',Labels::getLabel('LBL_Update',$this->adminLangId));
		return $frm;
	}
	
	private function getLinkForm( $polling_id ){
		$data = Polling::getAttributesById( $polling_id,array( 'polling_id', 'polling_identifier', 'polling_active',
		'polling_start_date', 'polling_end_date', 'polling_type') );
		if ( $data === false ) {
			return false;
		}
		
		$frm = new Form('frmPolling',array('id'=>'frmPolling'));
		$frm->addHiddenField('', 'polling_id');
		if($data['polling_type'] == Polling::POLLING_TYPE_CATEGORY){
			$frm->addRequiredField('Category', 'category');
		} else if($data['polling_type'] == Polling::POLLING_TYPE_PRODUCTS){
			$frm->addRequiredField('Product', 'product');
		}
		$frm->addHiddenField('', 'polling_type', $data['polling_type'] )->requirements()->setRequired();
		return $frm;
	}
	
	private function getSearchForm(){
		$this->objPrivilege->canViewPolling();
		$frm = new Form('frmPollingSearch');
		return $frm;
	}
}	