<?php
trait SellerCollections{
	
	public function commonShopCollection(){
		
		$userId = UserAuthentication::getLoggedUserId();
		$shopDetails = Shop::getAttributesByUserId($userId , null , false);
		
		if(!false == $shopDetails && $shopDetails['shop_active'] != applicationConstants::ACTIVE){			
			Message::addErrorMessage(Labels::getLabel('MSG_Your_shop_deactivated_contact_admin',$this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		if( !false == $shopDetails ){
			$shop_id =  $shopDetails['shop_id'];
			$stateId = $shopDetails['shop_state_id'];
		}
		$this->set( 'shop_id', $shop_id );
		$this->set( 'siteLangId', $this->siteLangId );
		$this->set( 'language', Language::getAllNames() );
		return $shop_id;
	}
	
	public function shopCollection(){
		$userId = UserAuthentication::getLoggedUserId();
		if(!UserPrivilege::canEditSellerCollection($userId))
		{
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$this->commonShopCollection();
		
		$this->_template->render(false,false);
		
	}
	
	public function shopCollectionGeneralForm(){
		$post = FatApp::getPostedData();
		$userId = UserAuthentication::getLoggedUserId();
		$shop_id=$this->commonShopCollection();
		$colectionForm = $this->getCollectionGeneralForm('',$shop_id);
		$shopcolDetails = ShopCollection::getCollectionGeneralDetail($shop_id);
		$baseUrl = Shop::getShopUrl($shop_id,'urlrewrite_custom');
		if(!empty($shopcolDetails)){
		
			/* url data[ */
			$urlSrch = UrlRewrite::getSearchObject();
			$urlSrch->doNotCalculateRecords();
			$urlSrch->doNotLimitRecords();
			$urlSrch->addFld('urlrewrite_custom');
			
			
			$urlSrch->addCondition( 'urlrewrite_original', '=', 'shops/collection/'.$shop_id );
			$rs = $urlSrch->getResultSet();
			$urlRow = FatApp::getDb()->fetch($rs);
			if( $urlRow ){				
				$shopcolDetails['urlrewrite_custom'] = str_replace('-'.$baseUrl,'',$urlRow['urlrewrite_custom']);
			}
			/* ] */
		
			$colectionForm->fill($shopcolDetails);
			$this->set('scollection_id',$shopcolDetails['scollection_id']);
		}
	
		$this->set('baseUrl', $baseUrl);
		$this->set('shop_id', $shop_id);
		$this->set('colectionForm', $colectionForm);
		$this->_template->render( false, false );
	}
	
	private function getCollectionGeneralForm($scollection_id = 0 , $shop_id = 0)
	{
		$shop_id = FatUtility::int($shop_id);
		$frm = new Form('frmShopCollection');
		$frm->addHiddenField('', 'scollection_id',$scollection_id);
		$frm->addHiddenField('', 'scollection_shop_id',$shop_id);
		$frm->addRequiredField(Labels::getLabel('LBL_Identifier',$this->siteLangId), 'scollection_identifier');
		$fld = $frm->addTextBox( Labels::getLabel('LBL_SEO_Friendly_URL', $this->siteLangId), 'urlrewrite_custom' );
		$fld->requirements()->setRequired();
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Save_Changes',$this->siteLangId));
		return $frm;
	}
	
	public function setupShopCollection(){
		$post = FatApp::getPostedData();
		$shop_id = FatUtility::int($post['scollection_shop_id']);
		$scollection_id = FatUtility::int($post['scollection_id']);
		if(!UserPrivilege::canEditSellerCollection($shop_id))
		{
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		if (false === $post) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		$frm = $this->getCollectionGeneralForm($scollection_id);
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
	
		$record = new ShopCollection($scollection_id);
		
		$record->assignValues($post);
		if (!$collection_id=$record->save()) {
			Message::addErrorMessage(Labels::getLabel("MSG_This_identifier_is_not_available._Please_try_with_another_one.",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );			
		}
		/* url data[ */
		
		
		$shopOriginalUrl = Shop::SHOP_COLLECTION_ORGINAL_URL.$shop_id;
		if( $post['urlrewrite_custom'] == '' ){
			FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array( 'smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)));
		} else {
			$shop = new Shop($shop_id);
			$shop->setupCollectionUrl($post['urlrewrite_custom']);			
		}
		/* ] */
		$newTabLangId=0;
		if($collection_id>0){
			$languages = Language::getAllNames();
			foreach($languages as $langId =>$langName ){
				if(!$row = ShopCollection::getAttributesByLangId($langId,$shop_id)){
					$newTabLangId = $langId;
					break;
				}
			}
		}else{
			$collection_id = $record->getMainTableRecordId();
			$newTabLangId=FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
		}
		
		$this->set('msg', Labels::getLabel('LBL_Setup_Successful',$this->siteLangId ));
		$this->set('collection_id', $collection_id);
		$this->set('langId', $newTabLangId); 
		$this->_template->render(false, false, 'json-success.php');
	}
	

	public function shopCollectionLangForm($scollection_id,$langId){
	
		$scollection_id = Fatutility::int( $scollection_id );
		if (!$scollection_id) {
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );			
		}
		
		$shopColLangFrm = $this->getCollectionLangForm ($scollection_id ,$langId);
		if($row = ShopCollection::getAttributesByLangId($langId,$scollection_id)){
			$data['scollection_id']=$row['scollectionlang_scollection_id'];
			$data['lang_id']=$row['scollectionlang_lang_id'];
			$data['name']=$row['scollection_name'];
			$shopColLangFrm ->fill($data);
		}
		
		$this->set('languages',Language::getAllNames());
		$this->set('shopColLangFrm',$shopColLangFrm);
		$this->set('formLayout',Language::getLayoutDirection($langId));
		$this->set('userId', UserAuthentication::getLoggedUserId());
		$this->set('scollection_id', $scollection_id );
		$this->set('langId', $langId );
		$this->commonShopCollection();
		$this->_template->render( false, false );
	}
	
	private function getCollectionLangForm($scollection_id = 0,$lang_id = 0){
		
		$frm = new Form('frmMetaTagLang');		
		$frm->addHiddenField('', 'scollection_id',$scollection_id);
		$frm->addHiddenField('', 'lang_id',$lang_id);
		$frm->addRequiredField(Labels::getLabel('LBL_Collection_Name',$this->siteLangId), 'name');
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Save_Changes',$this->siteLangId));
		return $frm;
	}
	
	public function setupShopCollectionLang(){
		$post = FatApp::getPostedData();
		$scollection_id = FatUtility::int($post['scollection_id']);
		if(!UserPrivilege::canEditSellerCollection($scollection_id))
		{
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		if (false === $post) {			
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		$frm = $this->getCollectionLangForm($scollection_id);
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
				
		$record = new ShopCollection($scollection_id);
		
		if (!$record->addUpdateShopCollectionLang($post)) {
			Message::addErrorMessage($record->getError());
			FatUtility::dieJsonError( Message::getHtml() );			
		}
	//	$this->commonShopCollection();
		$newTabLangId=0;	
		if($scollection_id>0){
			$languages = Language::getAllNames();
			foreach($languages as $langId =>$langName ){
		//	print_r(ShopCollection::getAttributesByLangId($langId,$scollection_id));
				if(!$row = ShopCollection::getAttributesByLangId($langId,$scollection_id)){
					$newTabLangId = $langId;
					break;
				}
			}
		}else{
			$collection_id = $record->getMainTableRecordId();
			$newTabLangId=FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);	
		}
		
		if( $newTabLangId == 0 && !$this->isCollectionLinkFormFilled($scollection_id))
		{
			$this->set('openCollectionLinkForm', true);
		}
		
		$this->set('msg', Labels::getLabel('LBL_Setup_Successful',$this->siteLangId ));
		$this->set('scollection_id', $scollection_id);
		$this->set('langId', $newTabLangId); 
		$this->_template->render(false, false, 'json-success.php');
	}
	
	private function isCollectionLinkFormFilled($scollection_id){
		$sCollectionobj = new ShopCollection();
		if($row = $sCollectionobj->getShopCollectionProducts($scollection_id,$this->siteLangId))
		{
			return true;
		}
		return false;
	}
	
	
	/*  - --- Seller Product Links  ----- [*/
	
	public function sellerCollectionProductLinkFrm($scollection_id){
		$post = FatApp::getPostedData();
		$scollection_id = FatUtility::int( $scollection_id );
		$shop_id=$this->commonShopCollection();
		if(!UserPrivilege::canEditSellerCollection($scollection_id))
		{
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		$sellProdObj  = new ShopCollection();
//		$sellerProductRow = SellerProduct::getAttributesById( $selprod_id );
		$products = $sellProdObj->getShopCollectionProducts($scollection_id,$this->siteLangId);
	
		$sellerCollectionproductLinkFrm =  $this->getCollectionLinksFrm();
 		$data['scp_scollection_id'] = $scollection_id;
		$sellerCollectionproductLinkFrm->fill($data); 
		$this->set('sellerCollectionproductLinkFrm',$sellerCollectionproductLinkFrm);
		$this->set('scollection_id',$scollection_id);
		$this->set('products',$products);

	

		$this->set('activeTab','LINKS');
		$this->_template->render(false,false);

	}
		
	private function getCollectionLinksFrm(){
		$frm = new Form('frmLinks1', array('id'=>'frmLinks1'));
		
		$frm->addTextBox(Labels::getLabel('LBL_COLLECTION',$this->siteLangId),'scp_selprod_id','',array('id'=>'scp_selprod_id'));
		
		$frm->addHtml('','buy_together','<div id="selprod-products"><ul class="list--vertical" ></ul></div><div class="gap"></div>');
		$frm->addHiddenField('','scp_scollection_id');
		$frm->addSubmitButton('','btn_submit',Labels::getLabel('LBL_Save_Changes',$this->siteLangId));
		return $frm;
		
	}
	
	function setupSellerCollectionProductLinks(){
		
		
		
		$post = FatApp::getPostedData();
		//print_r($post); die();
		$scollection_id = FatUtility::int( $post['scp_scollection_id'] );
		if(!UserPrivilege::canEditSellerCollection($scollection_id))
		{
			Message::addErrorMessage(Labels::getLabel("MSG_INVALID_ACCESS",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		$product_ids = (isset($post['product_ids']))?$post['product_ids']:array();
	
		unset($post['scp_selprod_id']);
		
		if( $scollection_id <= 0 ){
			Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request',$this->siteLangId));
			FatUtility::dieWithError(Message::getHtml());
		}

		$shopColObj  = new ShopCollection();
		/* saving of product Upsell Product[ */
		if( !$shopColObj->addUpdateSellerCollectionProducts($scollection_id, $product_ids ) ){
			Message::addErrorMessage( $shopColObj->getError() );
			FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('msg',Labels::getLabel('LBL_Record_Updated_Successfully',$this->siteLangId ));
		$this->_template->render(false, false, 'json-success.php');
	}
	

	
}