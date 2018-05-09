<?php
class MyAppController extends FatController {

	public function __construct($action) {
		parent::__construct($action);
		$this->action = $action;

		if (FatApp::getConfig("CONF_MAINTENANCE",FatUtility::VAR_INT,0) && (get_class($this)!="MaintenanceController") && (get_class($this)!='Home' && $action!='setLanguage') ){
			FatApp::redirectUser(CommonHelper::generateUrl('maintenance'));
		}
		CommonHelper::initCommonVariables();
		$this->initCommonVariables();
		UserAuthentication::doCookieLogin();
	}

	public function initCommonVariables(){
		$this->siteLangId = CommonHelper::getLangId();
		$this->siteCurrencyId = CommonHelper::getCurrencyId();
		$this->set('siteLangId',$this->siteLangId);
		$this->set('siteCurrencyId',$this->siteCurrencyId);
		$loginData = array(
			'loginFrm' => $this->getLoginForm(),
			'siteLangId'	=> $this->siteLangId,
			'showSignUpLink' => true);
		$this->set('loginData',$loginData);

		$controllerName = get_class($this);
		$arr = explode('-', FatUtility::camel2dashed($controllerName));
		array_pop($arr);
		$urlController = implode('-', $arr);
		// $controllerName = ucwords(implode(' ', $arr));
		$controllerName = ucfirst(FatUtility::dashed2Camel($urlController));

		/* to keep track of temporary hold the product stock, update time in each row of tbl_product_stock_hold against current user[ */
		/* $cart_user_id = session_id();
		if ( UserAuthentication::isUserLogged() ){
			$cart_user_id = UserAuthentication::getLoggedUserId();
		}

		$db = FatApp::getDb();
		$intervalInMinutes = FatApp::getConfig( 'cart_stock_hold_minutes', FatUtility::VAR_INT, 15 ); */

		/* $deleteQuery = "DELETE FROM tbl_product_stock_hold WHERE pshold_added_on < DATE_SUB(NOW(), INTERVAL ".$intervalInMinutes." MINUTE)";
		//echo $deleteQuery;
		$db->query( $deleteQuery ); */
		/* $db->deleteRecords( 'tbl_product_stock_hold', array( 'smt' => 'pshold_added_on < ?', 'vals' => array('DATE_SUB(NOW(), INTERVAL '.$intervalInMinutes.' MINUTE)') ) ); */

		$cartObj = new Cart( 0, $this->siteLangId );
		$cartProducts = $cartObj->getProducts($this->siteLangId);
		if( $cartProducts ){
			foreach( $cartProducts as $product ){

				$cartObj->updateTempStockHold( $product['selprod_id'], $product['quantity'] );
			}
		}
		/* ] */

		$jsVariables = array(
			'confirmRemove' =>Labels::getLabel('LBL_Do_you_want_to_remove',$this->siteLangId),
			'confirmReset' =>Labels::getLabel('LBL_Do_you_want_to_reset_settings',$this->siteLangId),
			'confirmDelete' =>Labels::getLabel('LBL_Do_you_want_to_delete',$this->siteLangId),
			'confirmUpdateStatus' =>Labels::getLabel('LBL_Do_you_want_to_update_the_status',$this->siteLangId),
			'confirmDeleteOption' =>Labels::getLabel('LBL_Do_you_want_to_delete_this_option',$this->siteLangId),
			'confirmDefault' =>Labels::getLabel('LBL_Do_you_want_to_set_default',$this->siteLangId),
			'setMainProduct' => Labels::getLabel('LBL_Set_as_main_product', $this->siteLangId),
			'layoutDirection'=>CommonHelper::getLayoutDirection(),
			'selectPlan' =>Labels::getLabel('LBL_Please_Select_any_Plan_From_The_Above_Plans',$this->siteLangId),
			'alreadyHaveThisPlan' =>str_replace( "{clickhere}" ,'<a href="'.CommonHelper::generateUrl('seller','subscriptions').'">'.Labels::getLabel('LBL_Click_Here',$this->siteLangId).'</a>', Labels::getLabel('LBL_You_have_already_Bought_this_plan._Please_choose_some_other_Plan_or_renew_it_from_{clickhere}',$this->siteLangId)),
			'processing' =>Labels::getLabel('LBL_Processing...',$this->siteLangId),
			'requestProcessing' =>Labels::getLabel('LBL_Request_Processing...',$this->siteLangId),
			'selectLocation' =>Labels::getLabel('LBL_Select_Location_to_view_Wireframe',$this->siteLangId),
			'favoriteToShop' =>Labels::getLabel('LBL_Favorite_To_Shop',$this->siteLangId),
			'unfavoriteToShop' =>Labels::getLabel('LBL_Unfavorite_To_Shop',$this->siteLangId),
			'userNotLogged' =>Labels::getLabel('MSG_User_Not_Logged',$this->siteLangId),
			'selectFile' =>Labels::getLabel('MSG_File_not_uploaded',$this->siteLangId),
			'thanksForSharing' =>Labels::getLabel('MSG_Thanks_For_Sharing',$this->siteLangId),
			'isMandatory' =>Labels::getLabel('VLBL_is_mandatory',$this->siteLangId),
			'pleaseEnterValidEmailId' =>Labels::getLabel('VLBL_Please_enter_valid_email_ID_for',$this->siteLangId),
			'charactersSupportedFor' =>Labels::getLabel('VLBL_Only_characters_are_supported_for',$this->siteLangId),
			'pleaseEnterIntegerValue' =>Labels::getLabel('VLBL_Please_enter_integer_value_for',$this->siteLangId),
			'pleaseEnterNumericValue' =>Labels::getLabel('VLBL_Please_enter_numeric_value_for',$this->siteLangId),
			'startWithLetterOnlyAlphanumeric' =>Labels::getLabel('VLBL_must_start_with_a_letter_and_can_contain_only_alphanumeric_characters._Length_must_be_between_4_to_20_characters',$this->siteLangId),
			'mustBeBetweenCharacters' =>Labels::getLabel('VLBL_Length_Must_be_between_6_to_20_characters',$this->siteLangId),
			'invalidValues' =>Labels::getLabel('VLBL_Length_Invalid_value_for',$this->siteLangId),
			'shouldNotBeSameAs' =>Labels::getLabel('VLBL_should_not_be_same_as',$this->siteLangId),
			'mustBeSameAs' =>Labels::getLabel('VLBL_must_be_same_as',$this->siteLangId),
			'mustBeGreaterOrEqual' =>Labels::getLabel('VLBL_must_be_greater_than_or_equal_to',$this->siteLangId),
			'mustBeGreaterThan' =>Labels::getLabel('VLBL_must_be_greater_than',$this->siteLangId),
			'mustBeLessOrEqual' =>Labels::getLabel('VLBL_must_be_less_than_or_equal_to',$this->siteLangId),
			'mustBeLessThan' =>Labels::getLabel('VLBL_must_be_less_than',$this->siteLangId),
			'lengthOf' =>Labels::getLabel('VLBL_Length_of',$this->siteLangId),
			'valueOf' =>Labels::getLabel('VLBL_Value_of',$this->siteLangId),
			'mustBeBetween' =>Labels::getLabel('VLBL_must_be_between',$this->siteLangId),
			'mustBeBetween' =>Labels::getLabel('VLBL_must_be_between',$this->siteLangId),
			'and' =>Labels::getLabel('VLBL_and',$this->siteLangId),
			'pleaseSelect' =>Labels::getLabel('VLBL_Please_select',$this->siteLangId),
			'to' =>Labels::getLabel('VLBL_to',$this->siteLangId),
			'options' =>Labels::getLabel('VLBL_options',$this->siteLangId),
		);

		$languages = Language::getAllNames(false);
		foreach($languages as $val){
			$jsVariables['language'.$val['language_id']] = $val['language_layout_direction'];
		}
		
		if(CommonHelper::getLayoutDirection() == 'rtl'){
			$this->_template->addCss('css/style--arabic.css');
		}
		$themeId = FatApp::getConfig('CONF_FRONT_THEME',FatUtility::VAR_INT,1);
		if( CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'] ) ){
			$themeId = $_SESSION['preview_theme'];
		}
		
		$themeDetail = ThemeColor::getAttributesById($themeId);
		
		$this->set('themeDetail',$themeDetail);
		$this->set('jsVariables',$jsVariables);
		$this->set('controllerName', $controllerName );
		$this->set('isAppUser' , commonhelper::isAppUser());
		$this->set('action', $this->action );
	}

	public function getStates($countryId , $stateId = 0){
		$countryId = FatUtility::int($countryId);
		$stateId = FatUtility::int($stateId);

		$stateObj = new States();
		$statesArr = $stateObj->getStatesByCountryId($countryId,$this->siteLangId);

		$this->set('statesArr',$statesArr);
		$this->set('stateId',$stateId);
		$this->_template->render(false, false, '_partial/states-list.php');
	}

	public function getBreadcrumbNodes($action) {
		$nodes = array();
		$className = get_class($this);
		$arr = explode('-', FatUtility::camel2dashed($className));
		array_pop($arr);
		$urlController = implode('-', $arr);
		$className = ucwords(implode(' ', $arr));

		if ($action == 'index') {
			$nodes[] = array('title'=>Labels::getLabel('LBL_'.ucwords($className),$this->siteLangId));
		}
		else {
			$nodes[] = array('title'=>ucwords($className), 'href'=>CommonHelper::generateUrl($urlController));
			$nodes[] = array('title'=>Labels::getLabel('LBL_'.ucwords($action),$this->siteLangId));
		}
		return $nodes;
	}

	public function checkIsShippingMode(){
		$json = array();
		$post = FatApp::getPostedData();
		if(isset($post["val"])){
			if ($post["val"] == FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS")){
				$json["shipping"] = 1;
			}
		}
		echo json_encode($json);
	}

	public function setUpNewsLetter(){
		require_once (CONF_INSTALLATION_PATH . 'library/Mailchimp.php');
		$siteLangId = CommonHelper::getLangId();
		$post = FatApp::getPostedData();
		$frm = Common::getNewsLetterForm( CommonHelper::getLangId() );
		$post = $frm->getFormDataFromArray( $post );

		$api_key = FatApp::getConfig("CONF_MAILCHIMP_KEY");
		$list_id = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");
		if( $api_key == '' || $list_id == '' ){
			Message::addErrorMessage( Labels::getLabel("LBL_Newsletter_is_not_configured_yet,_Please_contact_admin", $siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}

		$MailchimpObj = new Mailchimp( $api_key );
		$Mailchimp_ListsObj = new Mailchimp_Lists( $MailchimpObj );

		try {
			$subscriber = $Mailchimp_ListsObj->subscribe( $list_id, array( 'email' => htmlentities($post['email'])));

			if ( empty( $subscriber['leid'] ) ) {
				Message::addErrorMessage( Labels::getLabel('MSG_Newsletter_subscription_valid_email', $siteLangId) );
				FatUtility::dieWithError( Message::getHtml() );
			}
		} catch(Mailchimp_Error $e) {
			Message::addErrorMessage( $e->getMessage() );
			// Message::addErrorMessage( Labels::getLabel('MSG_Error_while_subscribing_to_newsletter', $siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}

		$this->set( 'msg', Labels::getLabel('MSG_Successfully_subscribed', $siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}

	protected function getLoginForm() {
		$siteLangId = CommonHelper::getLangId();
		$frm = new Form('frmLogin');
		$fld = $frm->addRequiredField(Labels::getLabel('LBL_Username_Or_Email',$siteLangId), 'username', '', array('placeholder'=>Labels::getLabel('LBL_EMAIL_ADDRESS',$siteLangId)));
		$pwd = $frm->addPasswordField(Labels::getLabel('LBL_Password',$siteLangId), 'password', '', array('placeholder'=>Labels::getLabel('LBL_PASSWORD',$siteLangId)));
		$pwd->requirements()->setRequired();
		$frm->addCheckbox(Labels::getLabel('LBL_Remember_Me',$siteLangId),'remember_me',1,array(),'',0);
		$frm->addHtml('','forgot','');
		$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_LOGIN',$siteLangId));
		return $frm;
	}

	protected function getRegistrationForm( $showNewsLetterCheckBox = true ) {
		$siteLangId = $this->siteLangId;

		$frm = new Form('frmRegister');

		$frm->addHiddenField('', 'user_id', 0, array('id'=>'user_id'));

		$frm->addRequiredField(Labels::getLabel('LBL_NAME',$siteLangId), 'user_name');

		$fld = $frm->addTextBox(Labels::getLabel('LBL_USERNAME',$siteLangId), 'user_username');
		$fld->setUnique('tbl_user_credentials', 'credential_username', 'credential_user_id', 'user_id', 'user_id');
		$fld->requirements()->setRequired(true);
		$fld->requirements()->setLength(3,30);
		
		$fld = $frm->addEmailField(Labels::getLabel('LBL_EMAIL',$siteLangId), 'user_email');
		$fld->setUnique('tbl_user_credentials', 'credential_email', 'credential_user_id', 'user_id', 'user_id');

		$fld = $frm->addPasswordField(Labels::getLabel('LBL_PASSWORD',$siteLangId), 'user_password');
		$fld->requirements()->setRequired();
		$fld->requirements()->setRegularExpressionToValidate("^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%-_]{8,15}$");
		$fld->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_Valid_password', $siteLangId));

		$fld1 = $frm->addPasswordField(Labels::getLabel('LBL_CONFIRM_PASSWORD',$siteLangId), 'password1');
		$fld1->requirements()->setRequired();
		$fld1->requirements()->setCompareWith('user_password', 'eq',Labels::getLabel('LBL_PASSWORD',$siteLangId));

		$fld = $frm->addCheckBox('','agree',1);
		$fld->requirements()->setRequired();
		$fld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Terms_Condition_is_mandatory.', $siteLangId));

		if( $showNewsLetterCheckBox && FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION') ){
			$api_key = FatApp::getConfig("CONF_MAILCHIMP_KEY");
			$list_id = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");
			if( $api_key != '' || $list_id != '' ){
				$frm->addCheckBox(Labels::getLabel('LBL_Newsletter_Signup',$siteLangId),'user_newsletter_signup',1);
			}
		}
		
		$isCheckOutPage = false;
		if(isset($_SESSION['referer_page_url']))
		{
			$checkoutPage = basename(parse_url($_SESSION['referer_page_url'], PHP_URL_PATH));
			if($checkoutPage == 'checkout') {
				$isCheckOutPage=true;
			}
		}
		if( $isCheckOutPage ){
			$frm->addHiddenField( '', 'isCheckOutPage', 1 );
		}

		//$frm->addDateField(Labels::getLabel('LBL_DOB',CommonHelper::getLangId()), 'user_dob', '',array('readonly'=>'readonly'));
		//$frm->addTextBox(Labels::getLabel('LBL_PHONE',CommonHelper::getLangId()), 'user_phone');
		$frm->addSubmitButton(Labels::getLabel('LBL_Register',$siteLangId), 'btn_submit', Labels::getLabel('LBL_Register',$siteLangId));

		return $frm;
	}

	protected function getUserAddressForm($siteLangId){
		$siteLangId = FatUtility::int($siteLangId);
		$frm = new Form('frmAddress');
		$fld = $frm->addTextBox( Labels::getLabel('LBL_Address_Label', $siteLangId), 'ua_identifier' );
		$fld->setFieldTagAttribute( 'placeholder', Labels::getLabel('LBL_E.g:_My_Office_Address', $siteLangId) );
		$frm->addRequiredField( Labels::getLabel('LBL_Name', $siteLangId), 'ua_name' );
		$frm->addRequiredField( Labels::getLabel('LBL_Address_Line1', $siteLangId), 'ua_address1' );
		$frm->addTextBox( Labels::getLabel('LBL_Address_Line2', $siteLangId), 'ua_address2' );


		$countryObj = new Countries();
		$countriesArr = $countryObj->getCountriesArr($siteLangId);
		$fld = $frm->addSelectBox( Labels::getLabel('LBL_Country',$siteLangId),'ua_country_id',$countriesArr, FatApp::getConfig('CONF_COUNTRY'),array(),Labels::getLabel('LBL_Select',$siteLangId));
		$fld->requirement->setRequired(true);

		$frm->addSelectBox(Labels::getLabel('LBL_State',$siteLangId),'ua_state_id',array(),'',array(),Labels::getLabel('LBL_Select',$siteLangId))->requirement->setRequired(true);
		$frm->addRequiredField( Labels::getLabel('LBL_City', $siteLangId), 'ua_city' );
		$frm->addRequiredField(Labels::getLabel('LBL_Postalcode',$this->siteLangId), 'ua_zip');
		$frm->addRequiredField( Labels::getLabel('LBL_Phone',$siteLangId), 'ua_phone' );
		$frm->addHiddenField( '', 'ua_id' );
		$fldSubmit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE_CHANGES',$siteLangId));
		$fldCancel = $frm->addButton('', 'btn_cancel', Labels::getLabel('LBL_Cancel',$siteLangId));
		$fldSubmit->attachField($fldCancel);
		return $frm;
	}

	protected function getProductSearchForm(){
		$sortByArr = array( 'price_asc' => Labels::getLabel('LBL_Price_(Low_to_High)', $this->siteLangId), 'price_desc' => Labels::getLabel('LBL_Price_(High_to_Low)', $this->siteLangId), 'popularity_desc' => Labels::getLabel('LBL_Sort_by_Popularity', $this->siteLangId), 'rating_desc' => Labels::getLabel('LBL_Sort_by_Rating', $this->siteLangId) );

		$pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
		//$pageSize = 10;
		$itemsTxt = Labels::getLabel('LBL_Items', $this->siteLangId);

		//$pageSizeArr[$pageSize] = $pageSize.' '.$itemsTxt;
		$pageSizeArr[$pageSize] = Labels::getLabel('LBL_Default', $this->siteLangId);
		$pageSizeArr[10] = 10 . ' '.$itemsTxt;
		$pageSizeArr[25] = 25 . ' '.$itemsTxt;
		$pageSizeArr[50] = 50 . ' '.$itemsTxt;
		$frm = new Form('frmProductSearch');
		$frm->addTextBox('','keyword');
		$frm->addSelectBox( '', 'sortBy', $sortByArr, 'price_asc', array(), '');
		$frm->addSelectBox( '', 'pageSize', $pageSizeArr, $pageSize, array(), '' );
		$frm->addHiddenField('', 'page', 1);
		$frm->addHiddenField('', 'sortOrder', 'asc');
		$frm->addHiddenField('', 'category',0);
		$frm->addHiddenField('', 'shop_id',0);
		$frm->addHiddenField('', 'collection_id',0);
		$frm->addHiddenField('', 'join_price',0);
		$frm->addHiddenField('', 'featured',0);
		$frm->addHiddenField( '', 'currency_id', $this->siteCurrencyId );
		$frm->addSubmitButton('','btnProductSrchSubmit','');
		return $frm;
	}

	function fatActionCatchAll($action){
		$this->_template->render(false, false, 'error-pages/404.php');
		//CommonHelper::error404();
	}

	/* public function pollResult($pollId){
		$siteLangId = CommonHelper::getLangId();
		$pollId = FatUtility::int($pollId);
	} */

	public function setupPoll(){
		$siteLangId = CommonHelper::getLangId();
		$pollId = FatApp::getPostedData('pollfeedback_polling_id',FatUtility::VAR_INT , 0);
		if($pollId <= 0){
			Message::addErrorMessage(Labels::getLabel('Msg_Invalid_Request',$siteLangId));
			FatUtility::dieWithError(Message::getHtml());
		}
		$frm = Common::getPollForm( $pollId ,$siteLangId );
		if(!$post = $frm->getFormDataFromArray( FatApp::getPostedData() )){
			Message::addErrorMessage($frm->getValidationErrors());
			FatUtility::dieWithError(Message::getHtml());
		}
		$pollFeedback = new PollFeedback();
		if($pollFeedback->isPollAnsweredFromIP($pollId ,$_SERVER['REMOTE_ADDR'])){
			Message::addErrorMessage(Labels::getLabel('Msg_Poll_already_posted_from_this_IP',$this->siteLangId));
			FatUtility::dieWithError(Message::getHtml());
		}
		$post['pollfeedback_response_ip'] = $_SERVER['REMOTE_ADDR'];
		$post['pollfeedback_added_on'] = date('Y-m-d H:i:s');

		$pollFeedback->assignValues($post);
		if(!$pollFeedback->save()){
			Message::addErrorMessage($pollFeedback->getError());
			FatUtility::dieWithError(Message::getHtml());
		}
		FatUtility::dieJsonSuccess(Labels::getLabel('Msg_Poll_Feedback_Sent_Successfully',$siteLangId));
	}

	protected function getChangeEmailForm($passwordField = true){
		$frm = new Form('changeEmailFrm');
		$newEmail = $frm->addEmailField(
							Labels::getLabel('LBL_NEW_EMAIL',$this->siteLangId),
							'new_email'
						);
		$newEmail->requirements()->setRequired();

		$conNewEmail = $frm->addEmailField(
							Labels::getLabel('LBL_CONFIRM_NEW_EMAIL',$this->siteLangId),
							'conf_new_email'
						);
		$conNewEmailReq = $conNewEmail->requirements();
		$conNewEmailReq->setRequired();
		$conNewEmailReq->setCompareWith('new_email','eq');
		// $conNewEmailReq->setCustomErrorMessage(Labels::getLabel('LBL_CONFIRM_EMAIL_NOT_MATCHED',$this->siteLangId));

		if($passwordField){
			$curPwd = $frm->addPasswordField(
					Labels::getLabel('LBL_CURRENT_PASSWORD',$this->siteLangId),'current_password'
				);
			$curPwd->requirements()->setRequired();
		}

		$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE_CHANGES',$this->siteLangId));
		return $frm;
	}

	protected function userEmailVerifications($userObj, $data, $configureEmail = false){

		if(!$configureEmail){			
			$verificationCode = $userObj->prepareUserVerificationCode($data['user_new_email']);
		}else{
			$verificationCode = $userObj->prepareUserVerificationCode($data['user_email']);
		}

		$link = CommonHelper::generateFullUrl('GuestUser', 'changeEmailVerification', array('verify'=>$verificationCode));



		$email = new EmailHandler();				
		$dataArr = array(
			'user_name' => $data['user_name'],
			'link' => $link,			
			'user_new_email' => $data['user_email'],				
		);
		
		if(!$configureEmail){
			$dataArr = array(
				'user_name' => $data['user_name'],
				'link' => $link,			
				'user_new_email' => $data['user_new_email'],			
				'user_email' => $data['user_email'],
				);
			if(!$email->sendChangeEmailRequestNotification($this->siteLangId , array('user_name' => $dataArr['user_name'],'user_email' => $dataArr['user_email'],'user_new_email' => $dataArr['user_new_email']))){
				return false;
			}
		}
		
		if(!$email->sendEmailVerificationLink($this->siteLangId , $dataArr)){
			return false;
		}

		return true;
	}

	public function includeDateTimeFiles(){
		$this->_template->addCss(array('css/jquery-ui-timepicker-addon.css'), false);
		$this->_template->addJs(array('js/jquery-ui-timepicker-addon.js'), false);
	}

	public function includeProductPageJsCss(){
		$this->_template->addJs('js/enscroll-0.6.2.min.js');
		$this->_template->addJs('js/masonry.pkgd.js');
		$this->_template->addJs('js/product-search.js');
		$this->_template->addJs('js/ion.rangeSlider.js');
		$this->_template->addJs('js/listing-functions.js');
		$this->_template->addCss('css/ion.rangeSlider.css');
		$this->_template->addCss('css/ion.rangeSlider.skinHTML5.css');

	}
}
