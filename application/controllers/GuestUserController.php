<?php
class GuestUserController extends MyAppController {
	public function loginForm() {
		if(UserAuthentication::doCookieLogin()){
			FatApp::redirectUser(CommonHelper::generateUrl('account'));
		}
		if (UserAuthentication::isUserLogged()) {
			FatApp::redirectUser(CommonHelper::generateUrl('account'));
		}
		$frm = $this->getLoginForm();
		$data = array(
			'loginFrm' 			=> $frm,
			'siteLangId'	=> $this->siteLangId
		);
		$obj = new Extrapage();
		$pageData = $obj->getContentByPageType( Extrapage::LOGIN_PAGE_RIGHT_BLOCK, $this->siteLangId );
		$this->set('pageData' , $pageData);
		$this->set('data', $data);
		$this->_template->render();
	}
	
	public function login() {
		$authentication = new UserAuthentication();
		if (!$authentication->login(FatApp::getPostedData('username'), FatApp::getPostedData('password'), $_SERVER['REMOTE_ADDR'])) {
			Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));
			FatUtility::dieJsonError( FatUtility::decodeHtmlEntities(Message::getHtml()));
		}
		
		$rememberme = FatApp::getPostedData('remember_me', FatUtility::VAR_INT, 0);
		if ($rememberme == 1) {
            if(!$this->setUserLoginCookie()){
				Message::addErrorMessage(Labels::getLabel('MSG_COOKIES_NOT_ADDED'),$this->siteLangId);				
			}
        }
		
		$userId = UserAuthentication::getLoggedUserId();
		setcookie('uc_id', $userId, time()+3600*24*30,'/');	
		
		$data = User::getAttributesById($userId,array('user_preferred_dashboard'));	
		
		$preferredDashboard = 0;
		if($data != false){
			$preferredDashboard = $data['user_preferred_dashboard'];
		}
		
		$redirectUrl = '';
		
		if(isset($_SESSION['referer_page_url'])){
			$redirectUrl = $_SESSION['referer_page_url'];
			unset($_SESSION['referer_page_url']);
		}
		if($redirectUrl == ''){
			$redirectUrl = User::getPreferedDashbordRedirectUrl($preferredDashboard);
		}
		
		if($redirectUrl == ''){
			$redirectUrl = CommonHelper::generateUrl('Account');
		}
		$this->set('redirectUrl',$redirectUrl);
		$this->set('msg', Labels::getLabel("MSG_LOGIN_SUCCESSFULL",$this->siteLangId));
		$this->_template->render(false, false, 'json-success.php'); 
	}
	
	private function setUserLoginCookie(){
		$userId = UserAuthentication::getLoggedUserAttribute('user_id', true);
		
		if(null == $userId){
			return false;
		}
		
		$token = $this->generateLoginToken();
		$expiry = strtotime("+7 DAYS");
		
		$values = array(
			'uauth_user_id'=>$userId,
			'uauth_token'=>$token,
			'uauth_expiry'=>date('Y-m-d H:i:s', $expiry),
			'uauth_browser'=>CommonHelper::userAgent(),
			'uauth_last_access'=>date('Y-m-d H:i:s'), 
			'uauth_last_ip'=>CommonHelper::userIp(),
		);
		
		if( UserAuthentication::saveRememberLoginToken($values) ){
			$cookieName = UserAuthentication::YOKARTUSER_COOKIE_NAME;
			$cookres = setcookie($cookieName, $token, $expiry, '/');
			return true;
		}
		return false;
	}
	
	private function generateLoginToken(){
		return substr(md5(rand(1, 99999) . microtime()), 1, 25);
	}
	
	public function LogInFormPopUp(){
		$frm = $this->getLoginForm();
		$data = array(
			'loginFrm' 			=> $frm,
			'siteLangId'	=> $this->siteLangId
		);
		$this->set('data', $data);
		$this->_template->render( false, false ); 
	}
	
	public function checkAjaxUserLoggedIn(){
		$json = array();
		$json['isUserLogged'] = FatUtility::int( UserAuthentication::isUserLogged() );
		die(json_encode($json));
	}
	
	public function socialMediaLogin($oauthProvider){		
		if (isset($oauthProvider)){
			if ($oauthProvider == 'googleplus') {
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginGoogleplus'));
			}else if ($oauthProvider == 'facebook') { 
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginFacebook'));
			}else{
				Message::addErrorMessage(Labels::getLabel('MSG_ERROR_INVALID_REQUEST',$this->siteLangid));
			}
		}
		CommonHelper::redirectUserReferer();
	}
		
	public function loginFacebook(){
		require_once (CONF_INSTALLATION_PATH . 'library/facebook/facebook.php');			
		
		$facebook = new Facebook(array(
					'appId' => FatApp::getConfig("CONF_FACEBOOK_APP_ID",FatUtility::VAR_STRING,''),
					'secret' => FatApp::getConfig("CONF_FACEBOOK_APP_SECRET",FatUtility::VAR_STRING,''), 					
				));

		$user = $facebook->getUser();
		if (!$user) {
			
			$loginUrl = $facebook->getLoginUrl(array('scope' => 'email'),
			CommonHelper::generateFullUrl('GuestUser','loginFacebook',array(),'',false)); 
			
			FatApp::redirectUser($loginUrl);
		}
		
 		try {
			// Proceed knowing you have a logged in user who's authenticated.
			$userProfile = $facebook->api('/me?fields=id,name,email');
		} catch (FacebookApiException $e) {
			Message::addErrorMessage($e->getMessage());
			$user = null;
		}
		
		if (empty($userProfile )) { 
			Message::addErrorMessage(Labels::getLabel('MSG_ERROR_INVALID_REQUEST',$this->siteLangId));
			CommonHelper::redirectUserReferer();
		}
		
		# User info ok? Let's print it (Here we will be adding the login and registering routines)
		$facebookName = $userProfile['name'];
		$userFacebookId = $userProfile['id'];
		$facebookEmail = $userProfile['email'];
			
		$db = FatApp::getDb();
		$userObj = new User();
		$srch = $userObj->getUserSearchObj(array('user_id','user_facebook_id','credential_email','credential_active','user_deleted'),false,false);
		if(!empty($facebookEmail)){
			$srch->addCondition('credential_email','=',$facebookEmail);
		}else{
			Message::addErrorMessage(Labels::getLabel("MSG_THERE_WAS_SOME_PROBLEM_IN_AUTHENTICATING_YOUR_ACCOUNT_WITH_FACEBOOK,_PLEASE_TRY_WITH_DIFFERENT_LOGIN_OPTIONS",$this->siteLangId));
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_code']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_access_token']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_user_id']);
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
			//$srch->addCondition('user_facebook_id','=',$userFacebookId);
		}
		
		$rs = $srch->getResultSet();
		$row = $db->fetch($rs);
		/* echo $srch->getQuery();die; */
		if ($row) {
 			if ($row['credential_active'] != applicationConstants::ACTIVE ) { 
				Message::addErrorMessage(Labels::getLabel("ERR_YOUR_ACCOUNT_HAS_BEEN_DEACTIVATED",$this->siteLangId));
				CommonHelper::redirectUserReferer();
			}
			if($row['user_deleted'] == applicationConstants::YES ){
				Message::addErrorMessage(Labels::getLabel("ERR_USER_INACTIVE_OR_DELETED",$this->siteLangId));
				CommonHelper::redirectUserReferer();
			}	
			$userObj->setMainTableRecordId($row['user_id']);
			
			$arr = array('user_facebook_id' => $userFacebookId);
			
			if(!$userObj->setUserInfo($arr)){
				Message::addErrorMessage(Labels::getLabel($userObj->getError(),$this->siteLangId));
				CommonHelper::redirectUserReferer();	
			}
			
		}else{
			$user_is_supplier = (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION",FatUtility::VAR_INT,1) || FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1)) ?0:1;
			$user_is_advertiser = (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION",FatUtility::VAR_INT,1) || FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1))?0:1;
			
			$db->startTransaction();
			
			$userData = array(
				'user_name' => $facebookName,
				'user_is_buyer' => 1,
				'user_is_supplier' => $user_is_supplier,
				'user_is_advertiser' => $user_is_advertiser,
				'user_facebook_id' => $userFacebookId,				
				'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD,
			);
			$post['user_registered_initially_for'] = User::USER_TYPE_BUYER;
			$userObj->assignValues($userData);
			if (!$userObj->save()) {
				Message::addErrorMessage(Labels::getLabel("MSG_USER_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
				$db->rollbackTransaction();									
				CommonHelper::redirectUserReferer();
			}					
			
			$username = str_replace(" ","",$facebookName).$userFacebookId;
			
			if (!$userObj->setLoginCredentials($username,$facebookEmail, uniqid(), 1, 1)) { 
				Message::addErrorMessage(Labels::getLabel("MSG_LOGIN_CREDENTIALS_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
				$db->rollbackTransaction();		
				CommonHelper::redirectUserReferer();	
			}

			$userData['user_username'] = $username;
			$userData['user_email'] = $facebookEmail;
			if(FatApp::getConfig('CONF_NOTIFY_ADMIN_REGISTRATION',FatUtility::VAR_INT,1)){
				if(!$this->notifyAdminRegistration($userObj, $userData)){
					Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
					$db->rollbackTransaction();
					if ( FatUtility::isAjaxCall() ) {
						FatUtility::dieWithError( Message::getHtml());
					}
				}
			}
			
			if(FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION',FatUtility::VAR_INT,1) && $facebookEmail){
				$data['user_email'] = $facebookEmail;
				$data['user_name'] = $facebookName;
				
				//ToDO::Change login link to contact us link
				$data['link'] = CommonHelper::generateFullUrl('GuestUser', 'loginForm');
				$userId = $userObj->getMainTableRecordId();
				$userEmailObj = new User($userId);
				if(!$this->userWelcomeEmailRegistration($userEmailObj, $data)){
					Message::addErrorMessage(Labels::getLabel("MSG_WELCOME_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
					$db->rollbackTransaction();
					FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
				}
			}
			$db->commitTransaction();
			
			
			$userObj->setUpRewardEntry( $userObj->getMainTableRecordId(), $this->siteLangId );
			
		}
		
		$userInfo = $userObj->getUserInfo(array('user_facebook_id','user_preferred_dashboard','credential_username','credential_password'));
		
		if(!$userInfo || ($userInfo && $userInfo['user_facebook_id']!= $userFacebookId)){
			Message::addErrorMessage(Labels::getLabel("MSG_USER_COULD_NOT_BE_SET",$this->siteLangId));
			CommonHelper::redirectUserReferer();
		}
		
		$authentication = new UserAuthentication();
		if (!$authentication->login($userInfo['credential_username'], $userInfo['credential_password'], $_SERVER['REMOTE_ADDR'],false)) {
			Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));
			FatUtility::dieWithError( Message::getHtml());
		}
		
		unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_code']);
		unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_access_token']);
		unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_user_id']);
		
		$preferredDashboard = 0;
		if($userInfo != false){
			$preferredDashboard = $userInfo['user_preferred_dashboard'];
		}			
		FatApp::redirectUser(User::getPreferedDashbordRedirectUrl($preferredDashboard));
	}
	
	public function loginGoogleplus(){ 
		require_once CONF_INSTALLATION_PATH . 'library/googleplus/Google_Client.php'; // include the required calss files for google login
		require_once CONF_INSTALLATION_PATH . 'library/googleplus/contrib/Google_PlusService.php';
		require_once CONF_INSTALLATION_PATH . 'library/googleplus/contrib/Google_Oauth2Service.php';
		$client = new Google_Client();
		
		$client->setApplicationName(FatApp::getConfig('CONF_WEBSITE_NAME_'.$this->siteLangId)); // Set your applicatio name
		$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me')); // set scope during user login
		$client->setClientId(FatApp::getConfig("CONF_GOOGLEPLUS_CLIENT_ID")); // paste the client id which you get from google API Console
		$client->setClientSecret(FatApp::getConfig("CONF_GOOGLEPLUS_CLIENT_SECRET")); // set the client secret
		
		$currentPageUri = CommonHelper::generateFullUrl('GuestUser','loginGoogleplus',array(),'',false);
		$client->setRedirectUri($currentPageUri);
		$client->setDeveloperKey(FatApp::getConfig("CONF_GOOGLEPLUS_DEVELOPER_KEY")); // Developer key
		$plus       = new Google_PlusService($client);
		$oauth2     = new Google_Oauth2Service($client); // Call the OAuth2 class for get email address
		
		if(isset($_GET['code'])) { 
		    $client->authenticate(); // Authenticate
		    $_SESSION['access_token'] = $client->getAccessToken(); // get the access token here	
			FatApp::redirectUser($currentPageUri);
		}
		
		if(isset($_SESSION['access_token'])) {
		    $client->setAccessToken($_SESSION['access_token']);
		}
		
		if (!$client->getAccessToken()) {
			$authUrl = $client->createAuthUrl();
			FatApp::redirectUser($authUrl);
		}
		
		$user = $oauth2->userinfo->get();
		
		$_SESSION['access_token'] = $client->getAccessToken();
		
		$userGoogleplusEmail = filter_var($user['email'], FILTER_SANITIZE_EMAIL); 		
		$userGoogleplusId = $user['id'];
		$userGoogleplusName = $user['name'];
		
		
		if (isset($userGoogleplusEmail) && (!empty($userGoogleplusEmail))){
			$db = FatApp::getDb();
			$userObj = new User();
			$srch = $userObj->getUserSearchObj(array('user_id','credential_email','credential_active'));
			$srch->addCondition('credential_email','=',$userGoogleplusEmail);
			$rs = $srch->getResultSet();
			$row = $db->fetch($rs);
			
			if ($row) {
				if ($row['credential_active'] != applicationConstants::ACTIVE ) { 
					Message::addErrorMessage(Labels::getLabel("ERR_YOUR_ACCOUNT_HAS_BEEN_DEACTIVATED",$this->siteLangId));
					CommonHelper::redirectUserReferer();
				}
				$userObj->setMainTableRecordId($row['user_id']);
				
				$arr = array('user_googleplus_id' => $userGoogleplusId);
				
				if(!$userObj->setUserInfo($arr)){
					Message::addErrorMessage(Labels::getLabel($userObj->getError(),$this->siteLangId));
					CommonHelper::redirectUserReferer();	
				}
			}else{
				$user_is_supplier = (FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1)) ? 0: 1;
				$user_is_advertiser = (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION",FatUtility::VAR_INT,1) || FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1)) ? 0: 1;
				
				$db->startTransaction();
				
				$userData = array(
					'user_name' => $userGoogleplusName,
					'user_is_buyer' => 1,
					'user_is_supplier' => $user_is_supplier,
					'user_is_advertiser' => $user_is_advertiser,
					'user_googleplus_id' => $userGoogleplusId,
					'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD,
				);
				$post['user_registered_initially_for'] = User::USER_TYPE_BUYER;
				$userObj->assignValues($userData);
				if (!$userObj->save()) { 
					Message::addErrorMessage(Labels::getLabel("MSG_USER_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());$db->rollbackTransaction();								
					CommonHelper::redirectUserReferer();
				}					
				
				$username = str_replace(" ","",$userGoogleplusName).$userGoogleplusId;
				
				if (!$userObj->setLoginCredentials($username,$userGoogleplusEmail, uniqid(), 1, 1)) { 
					Message::addErrorMessage(Labels::getLabel("MSG_LOGIN_CREDENTIALS_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
					$db->rollbackTransaction();		
					CommonHelper::redirectUserReferer();	
				}
				
				$userData['user_username'] = $username;
				$userData['user_email'] = $userGoogleplusEmail;
				if(FatApp::getConfig('CONF_NOTIFY_ADMIN_REGISTRATION',FatUtility::VAR_INT,1)){
					if(!$this->notifyAdminRegistration($userObj, $userData)){
						Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
						$db->rollbackTransaction();
						if ( FatUtility::isAjaxCall() ) {
							FatUtility::dieWithError( Message::getHtml());
						}
					}
				}
				
				if(FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION',FatUtility::VAR_INT,1) && $userGoogleplusEmail){
					$data['user_email'] = $userGoogleplusEmail;
					$data['user_name'] = $userGoogleplusName;
					
					//ToDO::Change login link to contact us link
					$data['link'] = CommonHelper::generateFullUrl('GuestUser', 'loginForm');
					$userId = $userObj->getMainTableRecordId();
					$userEmailObj = new User($userId);
					if(!$this->userWelcomeEmailRegistration($userEmailObj, $data)){
						Message::addErrorMessage(Labels::getLabel("MSG_WELCOME_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
						$db->rollbackTransaction();
						CommonHelper::redirectUserReferer();
					}
				}
				
				$db->commitTransaction();
				$userObj->setUpRewardEntry( $userObj->getMainTableRecordId(), $this->siteLangId );
			}
			
			$userInfo = $userObj->getUserInfo(array('user_googleplus_id','user_preferred_dashboard','credential_username','credential_password'));
		
			if(!$userInfo || ($userInfo && $userInfo['user_googleplus_id']!= $userGoogleplusId)){
				Message::addErrorMessage(Labels::getLabel("MSG_USER_COULD_NOT_BE_SET",$this->siteLangId));
				CommonHelper::redirectUserReferer();
			}
			
			$authentication = new UserAuthentication();
			if (!$authentication->login($userInfo['credential_username'], $userInfo['credential_password'], $_SERVER['REMOTE_ADDR'],false)) {
				Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));
				CommonHelper::redirectUserReferer();
			}
			
			unset($_SESSION['access_token']);
			
			$preferredDashboard = 0;
			if($userInfo != false){
				$preferredDashboard = $userInfo['user_preferred_dashboard'];
			}			
			FatApp::redirectUser(User::getPreferedDashbordRedirectUrl($preferredDashboard));			
		}
		
		CommonHelper::redirectUserReferer();		
	}
	
	public function registrationForm() {
		if (UserAuthentication::isUserLogged()) {
			FatApp::redirectUser(CommonHelper::generateUrl('account'));
		}
		$frm = $this->getRegistrationForm();
		
		$cPageSrch = ContentPage::getSearchObject($this->siteLangId);
		$cPageSrch->addCondition('cpage_id','=',FatApp::getConfig('CONF_TERMS_AND_CONDITIONS_PAGE' , FatUtility::VAR_INT , 0));
		$cpage = FatApp::getDb()->fetch($cPageSrch->getResultSet());
		if(!empty($cpage) && is_array($cpage)){
			$termsAndConditionsLinkHref = CommonHelper::generateUrl('Cms','view',array($cpage['cpage_id']));
		} else {
			$termsAndConditionsLinkHref = 'javascript:void(0)';
		}
		$data = array(
			'frm'	=>	$frm,
			'termsAndConditionsLinkHref'	=>	$termsAndConditionsLinkHref,
			'siteLangId'	=>	$this->siteLangId
		);
		$obj = new Extrapage();
		$pageData = $obj->getContentByPageType( Extrapage::REGISTRATION_PAGE_RIGHT_BLOCK, $this->siteLangId );
		$this->set('pageData' , $pageData);
		$this->set('data', $data);
		$this->_template->render(true , true , 'guest-user/registration-form.php');
	}
	
	public function register() {
		$frm = $this->getRegistrationForm();
		$post = FatApp::getPostedData();
		
		$cartObj = new Cart();
		$isCheckOutPage = ( isset($post['isCheckOutPage']) && $cartObj->hasProducts() ) ? FatUtility::int($post['isCheckOutPage']) : 0;
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
		if ( $post == false ) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser','registrationForm'));
		}
		
		if( !CommonHelper::validateUsername($post['user_username']) ){
			Message::addErrorMessage(Labels::getLabel('MSG_USERNAME_MUST_BE_THREE_CHARACTERS_LONG_AND_ALPHANUMERIC',$this->siteLangId));
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			} else {
				$this->registrationForm();
				return;
			}
		}
		
		if( !CommonHelper::validatePassword($post['user_password']) ){
			Message::addErrorMessage(Labels::getLabel('MSG_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC',$this->siteLangId));
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			} else {
				$this->registrationForm();
				return;
			}
		}
		
		$userObj = new User();
		$db = FatApp::getDb();
		$db->startTransaction();
		
		$post['user_is_buyer'] = 1;
		$post['user_is_supplier'] = (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION",FatUtility::VAR_INT,1) || FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1))  ? 0 : 1;
		$post['user_is_advertiser'] = (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION",FatUtility::VAR_INT,1) || FatApp::getConfig("CONF_ACTIVATE_SEPARATE_SIGNUP_FORM",FatUtility::VAR_INT,1)) ? 0 : 1;
		//$post['user_is_supplier'] = 0;
		$post['user_preferred_dashboard'] = User::USER_BUYER_DASHBOARD;
		$post['user_registered_initially_for'] = User::USER_TYPE_BUYER;
		
		$userObj->assignValues($post);
		if ( !$userObj->save() ) {
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel("MSG_USER_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			$this->registrationForm();
			return;
		}
		
		$active = FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION',FatUtility::VAR_INT,1) ? 0: 1;
		$verify = FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION',FatUtility::VAR_INT,1) ? 0 : 1;
		
		/* from checkout, buyer will be bydeafult acitve and email will be verified[ */
		/* $active = ( $isCheckOutPage == 1 ) ? 1 : $active;
		$verify = ( $isCheckOutPage == 1 ) ? 1 : $verify; */
		/* ] */
		
		if ( !$userObj->setLoginCredentials($post['user_username'],$post['user_email'], $post['user_password'], $active, $verify) ) {
			Message::addErrorMessage(Labels::getLabel("MSG_LOGIN_CREDENTIALS_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
			$db->rollbackTransaction();
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			$this->registrationForm(); return ;
		}
		
		$userObj->setUpRewardEntry( $userObj->getMainTableRecordId(), $this->siteLangId );
		
		//$userObj->setUpAffiliateRewarding( $userObj->getMainTableRecordId() );
		
		if(FatApp::getPostedData('user_newsletter_signup')){
			require_once (CONF_INSTALLATION_PATH . 'library/Mailchimp.php');
			$api_key = FatApp::getConfig("CONF_MAILCHIMP_KEY");
			$list_id = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");
			if( $api_key == '' || $list_id == '' ){
				Message::addErrorMessage( Labels::getLabel("LBL_Newsletter_is_not_configured_yet,_Please_contact_admin", $this->siteLangId) );
				if ( FatUtility::isAjaxCall() ) {
					FatUtility::dieWithError( Message::getHtml());
				}
				$this->registrationForm(); return ;
			}
			
			$MailchimpObj = new Mailchimp( $api_key );
			$Mailchimp_ListsObj = new Mailchimp_Lists( $MailchimpObj );
			try {
				$subscriber = $Mailchimp_ListsObj->subscribe( $list_id, array( 'email' => htmlentities($post['user_email'])));
				/* if ( empty( $subscriber['leid'] ) ) {
					Message::addErrorMessage( Labels::getLabel('MSG_Newsletter_subscription_valid_email', $siteLangId) );
					FatUtility::dieWithError( Message::getHtml() );
				} */
			} catch(Mailchimp_Error $e) {
				/* Message::addErrorMessage( $e->getMessage() );
				FatUtility::dieWithError( Message::getHtml() ); */
			}
		
		}
		
		if(FatApp::getConfig('CONF_NOTIFY_ADMIN_REGISTRATION',FatUtility::VAR_INT,1)){
			if(!$this->notifyAdminRegistration($userObj, $post)){
				Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
				$db->rollbackTransaction();
				if ( FatUtility::isAjaxCall() ) {
					FatUtility::dieWithError( Message::getHtml());
				}
				$this->registrationForm(); 
				return;
			}
		}

		//Send notification to admin			
		$notificationData = array(
			'notification_record_type' => Notification::TYPE_USER,
			'notification_record_id' => $userObj->getMainTableRecordId(),
			'notification_user_id' => $userObj->getMainTableRecordId(),
			'notification_label_key' => Notification::NEW_USER_REGISTERATION_NOTIFICATION,
			'notification_added_on' => date('Y-m-d H:i:s'),
		);
		
		if(!Notification::saveNotifications($notificationData)){
			Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_COULD_NOT_BE_SENT",$this->siteLangId));	
			$db->rollbackTransaction();
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			$this->registrationForm();
			return;	
		}		
		
		if( FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION',FatUtility::VAR_INT,1) ){
			if(!$this->userEmailVerification($userObj, $post)){
				Message::addErrorMessage(Labels::getLabel("MSG_VERIFICATION_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
				$db->rollbackTransaction();
				if ( FatUtility::isAjaxCall() ) {
					FatUtility::dieWithError( Message::getHtml());
				}
				$this->registrationForm();
				return;
			}
		} else {
			if(FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION',FatUtility::VAR_INT,1)){
				if(!$this->userWelcomeEmailRegistration($userObj, $post)){				
				Message::addErrorMessage(Labels::getLabel("MSG_WELCOME_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
					$db->rollbackTransaction();
					if ( FatUtility::isAjaxCall() ) {
						FatUtility::dieWithError( Message::getHtml());
					}
					$this->registrationForm();
					return;
				}
			}
			
			$confAutoLoginRegisteration = FatApp::getConfig('CONF_AUTO_LOGIN_REGISTRATION',FatUtility::VAR_INT,1);
			$confAutoLoginRegisteration = ( $isCheckOutPage ) ? 1 : $confAutoLoginRegisteration;
			
			if( $confAutoLoginRegisteration && !(FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION',FatUtility::VAR_INT,1))){
				$db->commitTransaction();
				$authentication = new UserAuthentication();
				if ( !$authentication->login(FatApp::getPostedData('user_username'),FatApp::getPostedData('user_password'), $_SERVER['REMOTE_ADDR']) ) {
					Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));
					if ( FatUtility::isAjaxCall() ) {
						FatUtility::dieWithError( Message::getHtml());
					}
					
					FatApp::redirectUser(CommonHelper::generateUrl('GuestUser','loginForm'));
				}
				
				if($isCheckOutPage) {
					$this->set( 'needLogin', 1 );
					$redirectUrl = CommonHelper::generateUrl('Checkout');
				} else {
					$redirectUrl = CommonHelper::generateUrl('Account');
				}
				if ( FatUtility::isAjaxCall() ) {
					$this->set('msg', Labels::getLabel( 'LBL_Registeration_Successfull', $this->siteLangId ) );
					$this->set( 'redirectUrl', $redirectUrl );
					$this->_template->render(false, false, 'json-success.php');
					exit;
				}
				FatApp::redirectUser( $redirectUrl );
			}
		}
		
		$db->commitTransaction();
		$redirectUrl = CommonHelper::generateUrl('GuestUser', 'registrationSuccess');
		if ( FatUtility::isAjaxCall() ) {
			$this->set('msg', Labels::getLabel( 'LBL_Registeration_Successfull', $this->siteLangId ) );
			$this->set( 'redirectUrl', $redirectUrl );
			$this->_template->render(false, false, 'json-success.php');
			exit;
		}
		
		FatApp::redirectUser($redirectUrl);
	}
	
	private function userEmailVerification($userObj, $data){
		$verificationCode = $userObj->prepareUserVerificationCode();
		
		$link = CommonHelper::generateFullUrl('GuestUser', 'userCheckEmailVerification', array('verify'=>$verificationCode));
		$data = array(
            'user_name' => $data['user_name'],
            'link' => $link,
			'user_email' => $data['user_email'],
        );
		
		$email = new EmailHandler();
		
		if(!$email->sendSignupVerificationLink($this->siteLangId,$data)){
			Message::addMessage(Labels::getLabel("MSG_ERROR_IN_SENDING_VERFICATION_EMAIL",$this->siteLangId));
			return false;
		}
		
		return true;
	}
	
	private function notifyAdminRegistration($userObj, $data){	
		return $userObj->notifyAdminRegistration($data,$this->siteLangId);		
	}
	
	private function userWelcomeEmailRegistration($userObj, $data){
		
		$link = CommonHelper::generateFullUrl('GuestUser', 'loginForm');
		
		$data = array(
            'user_name' => $data['user_name'],                                   
			'user_email' => $data['user_email'],
			'link' => $link,
        );
		
		$email = new EmailHandler();
		
		if(!$email->sendWelcomeEmail($this->siteLangId,$data)){
			Message::addMessage(Labels::getLabel("MSG_ERROR_IN_SENDING_WELCOME_EMAIL",$this->siteLangId));
			return false;
		}
		
		return true;
	}	
	
	public function userCheckEmailVerification($code){
		$code = FatUtility::convertToType($code, FatUtility::VAR_STRING);
		if(strlen($code) < 1){
			Message::addMessage(Labels::getLabel("MSG_PLEASE_CHECK_YOUR_EMAIL_IN_ORDER_TO_VERIFY",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$arrCode = explode('_', $code, 2);		
		
		$userId = FatUtility::int($arrCode[0]);
		if ($userId < 1){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_CODE',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
        }
		
		$userObj = new User($userId);
		$userData = User::getAttributesById( $userId, array('user_id', 'user_is_affiliate') );
		if( !$userData ){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_CODE',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$db = FatApp::getDb();
		$db->startTransaction();
		
		/* if (!$userObj->verifyUserEmailVerificationCode($code)){
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel("ERR_MSG_INVALID_VERIFICATION_REQUEST",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		} */
		
		if( $userData['user_is_affiliate'] != applicationConstants::YES ){
			$srch = new SearchBase('tbl_user_credentials');
			$srch->addCondition('credential_user_id', '=', $userId);
			$rs = $srch->getResultSet();
			$checkActiveRow = $db->fetch($rs);
			if($checkActiveRow['credential_active'] != applicationConstants::ACTIVE)
			{
				$active = FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION',FatUtility::VAR_INT,1)?0:1;
				if( !$userObj->activateAccount($active) ){
					$db->rollbackTransaction();
					Message::addErrorMessage(Labels::getLabel('MSG_INVALID_CODE',$this->siteLangId));
					FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
				}
			}
		}
		
		if(!$userObj->verifyAccount()){
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_CODE',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$userdata = $userObj->getUserInfo( array('credential_email','credential_password', 'user_name','credential_active'),false);
		
		if(FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION',FatUtility::VAR_INT,1)){
			$data['user_email'] = $userdata['credential_email'];
			$data['user_name'] = $userdata['user_name'];
			
			//ToDO::Change login link to contact us link
			$data['link'] = CommonHelper::generateFullUrl('GuestUser', 'loginForm');
			
			if(!$this->userWelcomeEmailRegistration($userObj, $data)){
				Message::addErrorMessage(Labels::getLabel("MSG_WELCOME_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId));
				$db->rollbackTransaction();
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
			}
		}
		
		$db->commitTransaction();
		
		if(FatApp::getConfig('CONF_AUTO_LOGIN_REGISTRATION',FatUtility::VAR_INT,1)){
			$authentication = new UserAuthentication();
			
			if (!$authentication->login($userdata['credential_email'],$userdata['credential_password'], $_SERVER['REMOTE_ADDR'] ,false)) {
				Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));					
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
			}
			FatApp::redirectUser(CommonHelper::generateUrl('Account'));
		}
		
		Message::addMessage(Labels::getLabel("MSG_EMAIL_VERIFIED",$this->siteLangId));
		
		FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
	}
	
	public function changeEmailVerification($code){
		$code = FatUtility::convertToType($code, FatUtility::VAR_STRING);
		if(strlen($code) < 1){
			Message::addMessage(Labels::getLabel("MSG_PLEASE_CHECK_YOUR_EMAIL_IN_ORDER_TO_VERIFY",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$arrCode = explode('_', $code, 2);		
		
		$userId = FatUtility::int($arrCode[0]);
		if ($userId < 1){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_CODE',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
        }
		
		$userObj = new User($userId);
		
		$newUserEmail = $userObj->verifyUserEmailVerificationCode($code); 

		if (!$newUserEmail){
			Message::addErrorMessage(Labels::getLabel("ERR_MSG_INVALID_VERIFICATION_REQUEST",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$usr = new User();
		$srch = $usr->getUserSearchObj(array('uc.credential_email'));
		$srch->addCondition('uc.credential_email','=',$newUserEmail);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		
		$rs = $srch->getResultSet();
		$record = FatApp::getDb()->fetch($rs);
	
		if($record){
			Message::addErrorMessage(Labels::getLabel("ERR_DUPLICATE_EMAIL",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		
		$srchUser = $usr->getUserSearchObj(array('u.user_name','uc.credential_email'));
		$srchUser->addCondition('u.user_id','=',$userId);
		$srchUser->doNotCalculateRecords();
		$srchUser->doNotLimitRecords();
		$rs = $srchUser->getResultSet();
		$data = FatApp::getDb()->fetch($rs);		
	
		if (!$userObj->changeEmail($newUserEmail)) {
			Message::addErrorMessage(Labels::getLabel("MSG_UPDATED_EMAIL_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$email = new EmailHandler();
		$currentEmail = $data['credential_email'];
		if(!empty($currentEmail) && !$email->sendEmailChangedNotification($this->siteLangId , array('user_name' => $data['user_name'],'user_email' => $data['credential_email'],'user_new_email' => $newUserEmail))){
			Message::addErrorMessage(Labels::getLabel("MSG_UNABLE_TO_SEND_EMAIL_CHANGE_NOTIFICATION",$this->siteLangId) . $userObj->getError());
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		if(FatApp::getConfig('CONF_AUTO_LOGIN_REGISTRATION',FatUtility::VAR_INT,1) || UserAuthentication::isUserLogged()){
			$userdata = $userObj->getUserInfo( array('credential_username','credential_password'));
			$authentication = new UserAuthentication();
			if (!$authentication->login($userdata['credential_username'],$userdata['credential_password'], $_SERVER['REMOTE_ADDR'],false)) {
				Message::addErrorMessage(Labels::getLabel($authentication->getError(),$this->siteLangId));	 
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
			}
			FatApp::redirectUser(CommonHelper::generateUrl('Account'));
		}
		
		Message::addMessage(Labels::getLabel("MSG_EMAIL_VERIFIED",$this->siteLangId));		
		FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
	}
	
	public function registrationSuccess() {
		if( FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION',FatUtility::VAR_INT,1) ){
			$this->set('registrationMsg', Labels::getLabel("MSG_SUCCESS_USER_SIGNUP_EMAIL_VERIFICATION_PENDING",$this->siteLangId));
		}else{
			$this->set('registrationMsg', Labels::getLabel("MSG_SUCCESS_USER_SIGNUP_ADMIN_APPROVAL_PENDING",$this->siteLangId));
		}
		
		$this->_template->render();
	}
	
	public function forgotPasswordForm() {
		$frm = $this->getForgotForm();
		$obj = new Extrapage();
		$pageData = $obj->getContentByPageType( Extrapage::FORGOT_PAGE_RIGHT_BLOCK, $this->siteLangId );
		$this->set('pageData' , $pageData);
		$this->set('frm', $frm);
		$this->set('siteLangId', $this->siteLangId);
		$this->_template->render();
	}
	
	public function forgotPassword(){
		$frm = $this->getForgotForm();
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
				
		if (false === $post) {
			Message::addErrorMessage($frm->getValidationErrors());
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));
		}
		
		if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){
			if(!CommonHelper::verifyCaptcha()) {
				Message::addErrorMessage(Labels::getLabel('MSG_That_captcha_was_incorrect',$this->siteLangId));			
				FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));
			}
		}
		
		$user = $post['user_email_username'];
		
		$userAuthObj = new UserAuthentication();
		$row = $userAuthObj->getUserByEmailOrUserName($user,'',false);
	
		if(!$row || false === $row){
			Message::addErrorMessage(Labels::getLabel($userAuthObj->getError(),$this->siteLangId));	
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));		
		}
		
		if($userAuthObj->checkUserPwdResetRequest($row['user_id'])){
			Message::addErrorMessage(Labels::getLabel($userAuthObj->getError(),$this->siteLangId));	
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));
		}
		
		$token = UserAuthentication::encryptPassword(FatUtility::getRandomString(20));
		$row['token'] = $token;
		
		$userAuthObj->deleteOldPasswordResetRequest();
		
		$db = FatApp::getDb();
		$db->startTransaction();
		// commonHelper::printArray($row); die;
		if(!$userAuthObj->addPasswordResetRequest($row)){
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel($userAuthObj->getError(),$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));
		}
		
		$row['link'] = CommonHelper::generateFullUrl('GuestUser','resetPassword',array($row['user_id'], $token));
		
		$email = new EmailHandler();
		
		if(!$email->sendForgotPasswordLinkEmail($this->siteLangId,$row)){
			$db->rollbackTransaction();
			Message::addErrorMessage(Labels::getLabel("MSG_ERROR_IN_SENDING_PASSWORD_RESET_LINK_EMAIL",$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm'));
		}
		
		$db->commitTransaction();
		Message::addMessage(Labels::getLabel("MSG_YOUR_PASSWORD_RESET_INSTRUCTIONS_TO_YOUR_EMAIL",$this->siteLangId));
		FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));	
	}
	
	public function resendVerification($user=''){
		$frm = $this->getForgotForm();
			
		if (empty($user)) {
			FatUtility::dieJsonError( $frm->getValidationErrors() );
		}
		
		$userAuthObj = new UserAuthentication();
		
		if( !$row = $userAuthObj->getUserByEmailOrUserName($user,false,false) ){
			FatUtility::dieJsonError( Labels::getLabel($userAuthObj->getError(),$this->siteLangId) );
		}
		$row['user_email'] = $row['credential_email'];
		$db = FatApp::getDb();
		$srch = new SearchBase('tbl_user_credentials');
		$srch->addCondition('credential_email', '=', $row['user_email']);
		$rs = $srch->getResultSet();
		$checkVerificationRow = $db->fetch($rs);
		
		$userObj = new User($row['user_id']);
		if ($checkVerificationRow['credential_verified'] != 1) {
			if(!$this->userEmailVerification($userObj, $row, $this->siteLangId)){
				FatUtility::dieJsonError( Labels::getLabel("MSG_VERIFICATION_EMAIL_COULD_NOT_BE_SENT",$this->siteLangId) );
			}else{
				FatUtility::dieJsonSuccess( Labels::getLabel("MSG_VERIFICATION_EMAIL_HAS_BEEN_SENT_AGAIN",$this->siteLangId) );
			}
		}else{
			FatUtility::dieJsonError( Labels::getLabel("MSG_You_are_already_verified_please_login.",$this->siteLangId) );
		}
	}
	
	public function resetPassword($userId = 0, $token = ''){
		
		$userId = FatUtility::int($userId);
		
		if($userId < 1 || strlen(trim($token)) < 20){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_RESET_PASSWORD_REQUEST'),$this->siteLangId);
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$userAuthObj = new UserAuthentication();
		
		if(!$userAuthObj->checkResetLink($userId, trim($token), 'form')){
			Message::addErrorMessage($userAuthObj->getError());
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
		}
		
		$frm = $this->getResetPwdForm($userId, trim($token));
		$obj = new Extrapage();
		$pageData = $obj->getContentByPageType( Extrapage::RESET_PAGE_RIGHT_BLOCK, $this->siteLangId );
		$this->set('pageData' , $pageData);
		$this->set('frm', $frm);
		$this->_template->render();			
	}
	
	public function resetPasswordSetup(){
		$newPwd = FatApp::getPostedData('new_pwd');
		$confirmPwd = FatApp::getPostedData('confirm_pwd');
		$userId = FatApp::getPostedData('user_id', FatUtility::VAR_INT);
		$token = FatApp::getPostedData('token', FatUtility::VAR_STRING);
		
		if($userId < 1 && strlen(trim($token)) < 20)
		{
			Message::addErrorMessage(Labels::getLabel('MSG_REQUEST_IS_INVALID_OR_EXPIRED',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		$frm = $this->getResetPwdForm($userId,$token);
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
        if ($post == false){
            Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );	
        }
			
		if( ! CommonHelper::validatePassword($post['new_pwd'])){
			Message::addErrorMessage(Labels::getLabel('MSG_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		
		$userAuthObj = new UserAuthentication();
		
		if( ! $userAuthObj->checkResetLink($userId, trim($token), 'submit'))
		{
			Message::addErrorMessage($userAuthObj->getError());
			FatUtility::dieJsonError( Message::getHtml() );	
		}

		$pwd = UserAuthentication::encryptPassword($newPwd);
				
		if(!$userAuthObj->resetUserPassword($userId, $pwd)){
			Message::addErrorMessage($userAuthObj->getError());
			FatUtility::dieJsonError( Message::getHtml() );	
		}
	
		$email = new EmailHandler();
		
		$userObj=new User($userId);
		$row = $userObj->getUserInfo(array(User::tblFld('name'), User::DB_TBL_CRED_PREFIX.'email'), '', false);
		$row['link'] = CommonHelper::generateFullUrl('GuestUser', 'loginForm');
		$email->sendResetPasswordConfirmationEmail($this->siteLangId,$row);
		
		/* Message::addMessage(Labels::getLabel('MSG_PASSWORD_CHANGED_SUCCESSFULLY',$this->siteLangId));
		FatUtility::dieJsonError( Message::getHtml() ); */
		
		$this->set('msg', Labels::getLabel('MSG_PASSWORD_CHANGED_SUCCESSFULLY',$this->siteLangId));	
		$this->_template->render(false, false, 'json-success.php');	
	}
	
	public function configureEmail(){
		$this->_template->render();
	}
	
	public function changeEmailForm(){
		$frm = $this->getChangeEmailForm(false);

		$this->set('frm', $frm);
		$this->set('siteLangId',$this->siteLangId);
		$this->_template->render(false, false,'account/change-email-form.php');
	}
	
	public function updateEmail(){
		$emailFrm = $this->getChangeEmailForm(false);
		$post = $emailFrm->getFormDataFromArray(FatApp::getPostedData());
		
		if(!$emailFrm->validate($post)){
			Message::addErrorMessage($emailFrm->getValidationErrors());
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		
		if($post['new_email'] != $post['conf_new_email']){
			Message::addErrorMessage(Labels::getLabel('MSG_New_email_confirm_email_does_not_match',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		
		$userObj = new User(UserAuthentication::getLoggedUserId());
		$srch = $userObj->getUserSearchObj(array('user_id','credential_email','user_name'));
		$rs = $srch->getResultSet();
		
		if(!$rs){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		
		$data = FatApp::getDb()->fetch($rs,'user_id');
		
		if ($data === false) {
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		
		if($data['credential_email'] != ''){
			Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}
		
		/* if ($data['credential_password'] != UserAuthentication::encryptPassword($post['current_password'])) {
			Message::addErrorMessage(Labels::getLabel('MSG_YOUR_CURRENT_PASSWORD_MIS_MATCHED',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		} */
		
		$arr = array(
			'user_name' => $data['user_name'],
			'user_email' => $post['new_email']
		);
		
		if(!$this->userEmailVerifications($userObj, $arr,true)){	
			Message::addMessage(Labels::getLabel("MSG_ERROR_IN_SENDING_VERFICATION_EMAIL",$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$this->set('msg', Labels::getLabel('MSG_CHANGE_EMAIL_REQUEST_SENT_SUCCESSFULLY',$this->siteLangId));	
		$this->_template->render(false, false, 'json-success.php');	
	}
	
	public function logout(){
		// Delete googleplus session if exist
		if(isset($_SESSION['access_token'])){
			unset($_SESSION['access_token']);
		}
		
		//Delete facebook session if exist
		require_once (CONF_INSTALLATION_PATH . 'library/facebook/facebook.php');
		$facebook = new Facebook(array(
			'appId' => FatApp::getConfig("CONF_FACEBOOK_APP_ID"),
			'secret' => FatApp::getConfig("CONF_FACEBOOK_APP_SECRET"),
		));
		
		$user = $facebook->getUser();
		
		if ($user) {
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_code']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_access_token']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_user_id']);
		}
		
		unset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]);
		unset($_SESSION[UserAuthentication::AFFILIATE_SESSION_ELEMENT_NAME]);
		unset($_SESSION['activeTab']);
		unset($_SESSION['referer_page_url']);
		unset($_SESSION['registered_supplier']['id']);
		UserAuthentication::clearLoggedUserLoginCookie();
		
		FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'loginForm'));
	}
	
	private function getForgotForm(){
		$siteLangId = $this->siteLangId;
		$frm = new Form('frmPwdForgot');		
		$fld = $frm->addTextBox(Labels::getLabel('LBL_Username_or_email',$siteLangId), 'user_email_username')->requirements()->setRequired();
		if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){
			$frm->addHtml('', 'htmlNote','<div class="g-recaptcha" data-sitekey="'.FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'').'"></div>');
		}					
		$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT',$siteLangId));		
		return $frm;
	}
	
	private function getResetPwdForm($uId, $token){
		$siteLangId = $this->siteLangId;
		$frm = new Form('frmResetPwd');
		$fld_np = $frm->addPasswordField(Labels::getLabel('LBL_NEW_PASSWORD',$siteLangId),'new_pwd');
		$fld_np->htmlAfterField='<span class="text--small">'.sprintf(Labels::getLabel('LBL_Example_password',$siteLangId),'User@123').'</span>';
		$fld_np->requirements()->setRequired();
		$fld_np->requirements()->setRegularExpressionToValidate("^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%-_]{8,15}$");
		$fld_np->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_Valid_password', $siteLangId));
		$fld_cp = $frm->addPasswordField(Labels::getLabel('LBL_CONFIRM_NEW_PASSWORD',$siteLangId), 'confirm_pwd');
		$fld_cp->requirements()->setRequired();
		$fld_cp->requirements()->setCompareWith('new_pwd', 'eq','');
		
		$frm->addHiddenField('', 'user_id', $uId, array('id'=>'user_id'));
		$frm->addHiddenField('', 'token', $token, array('id'=>'token'));
		
		$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_RESET_PASSWORD',$siteLangId));		
		return $frm;
	}
	
}