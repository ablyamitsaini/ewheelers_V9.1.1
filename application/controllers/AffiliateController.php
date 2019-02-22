<?php 
class AffiliateController extends LoggedUserController{
	public function __construct($action){
		parent::__construct($action);
		if( !User::isAffiliate() ){
			if( FatUtility::isAjaxCall() ){
				Message::addErrorMessage( Labels::getLabel("LBL_Unauthorised_access",$this->siteLangId ) );
				FatUtility::dieWithError( Message::getHtml() );
			}
			FatApp::redirectUser(CommonHelper::generateUrl('account'));
		}
		$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
		$this->set('bodyClass','is--dashboard');
	}
	
	public function index(){
		//$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$this->set('userBalance', User::getUserBalance( $loggedUserId ));
		$this->set( 'userRevenue', User::getAffiliateUserRevenue( $loggedUserId ) );
		$this->_template->render(true,false);
	}
	
	public function paymentInfoForm(){
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$frm = $this->getPaymentInfoForm( $this->siteLangId );
		/* $userExtraData = User::getUserExtraData( $loggedUserId, array(
			'uextra_tax_id', 
			'uextra_payment_method', 
			'uextra_cheque_payee_name',
			'uextra_bank_name',
			'uextra_bank_branch_number',
			'uextra_bank_swift_code',
			'uextra_bank_account_name',
			'uextra_bank_account_number',
			'uextra_paypal_email_id') ); */
		$userExtraData = User::getUserExtraData( $loggedUserId, array(
			'uextra_tax_id', 
			'uextra_payment_method', 
			'uextra_cheque_payee_name',
			'uextra_paypal_email_id') 
		);
		
		$userObj = new User($loggedUserId);
		$userBankInfo = $userObj->getUserBankInfo();
		$frmData = $userExtraData;
		if( is_array($userBankInfo) && !empty($userBankInfo) ){
			$frmData = array_merge( $frmData, $userBankInfo );
		}
		$frm->fill( $frmData );
		$this->set( 'userExtraData', $frmData );
		$this->set( 'frm', $frm );
		$this->_template->render( false, false );
	}
	
	public function setUpPaymentInfo(){
		$frm = $this->getPaymentInfoForm( $this->siteLangId );
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		if ( $post == false ) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			FatApp::redirectUser(CommonHelper::generateUrl('Affiliate'));
		}
		
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$userObj = new User( $loggedUserId );
		
		/* saving user extras[ */
		$dataToSave = array(
			'uextra_user_id'	=>	$loggedUserId,
			'uextra_tax_id'		=>	$post['uextra_tax_id'],
			'uextra_payment_method'	=>	$post['uextra_payment_method'],
			'uextra_cheque_payee_name'=>$post['uextra_cheque_payee_name'],
			'uextra_paypal_email_id'=>	$post['uextra_paypal_email_id'],
		);
		$dataToUpdateOnDuplicate = $dataToSave;
		unset($dataToUpdateOnDuplicate['uextra_user_id']);
		if( !FatApp::getDb()->insertFromArray( User::DB_TBL_USR_EXTRAS, $dataToSave, false, array(), $dataToUpdateOnDuplicate ) ){
			Message::addErrorMessage( Labels::getLabel("LBL_Details_could_not_be_saved!", $this->siteLangId) );
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			FatApp::redirectUser( CommonHelper::generateUrl('Account', 'ProfileInfo') );
		}
		/* ] */
		
		/* saving user bank details[ */
		$bankInfoData = array(
			'ub_bank_name'		=>	$post['ub_bank_name'],
			'ub_account_holder_name'	=>	$post['ub_account_holder_name'],
			'ub_account_number'=>	$post['ub_account_number'],
			'ub_ifsc_swift_code'	=> $post['ub_ifsc_swift_code'],
			'ub_bank_address'		=> $post['ub_bank_address'],
		);
		if( !$userObj->updateBankInfo( $bankInfoData ) ){
			Message::addErrorMessage( $userObj->getError() );
			if ( FatUtility::isAjaxCall() ) {
				FatUtility::dieWithError( Message::getHtml());
			}
			FatApp::redirectUser( CommonHelper::generateUrl('Account', 'ProfileInfo') );
		}
		/* ] */
		
		$this->set( 'msg', Labels::getLabel('MSG_Payment_details_saved_successfully!', $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function getFbToken(){
		$userId = UserAuthentication::getLoggedUserId();
		if(isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['redirect_user'])){
			$redirectUrl = $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['redirect_user'];
			unset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['redirect_user']);
		}else{
			$redirectUrl = CommonHelper::generateUrl('Affiliate','Sharing');
		}
		
		require_once(CONF_INSTALLATION_PATH.'library/Fbapi.php');
		
		$config = array(
			'app_id' => FatApp::getConfig('CONF_FACEBOOK_APP_ID',FatUtility::VAR_STRING,''),
			'app_secret' => FatApp::getConfig('CONF_FACEBOOK_APP_SECRET',FatUtility::VAR_STRING,''),
		);
		$fb = new Fbapi($config);
		$fbObj = $fb->getInstance();
		
		$helper = $fb->getRedirectLoginHelper();
		
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			Message::addErrorMessage($e->getMessage());
			FatApp::redirectUser($redirectUrl);			 
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			Message::addErrorMessage($e->getMessage());
			FatApp::redirectUser($redirectUrl);	
		}
		
		if (! isset($accessToken)) {
			if ($helper->getError()) {
				Message::addErrorMessage($helper->getErrorDescription());
				//Message::addErrorMessage($helper->getErrorReason());							
			} else {					
				Message::addErrorMessage(Labels::getLabel('Msg_Bad_Request',$this->siteLangId));				
			}			
		}else{
			// The OAuth 2.0 client handler helps us manage access tokens
			$oAuth2Client = $fbObj->getOAuth2Client();
			
			if (! $accessToken->isLongLived()) {
				try {
					$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
				} catch (Facebook\Exceptions\FacebookSDKException $e) {
					Message::addErrorMessage($helper->getMessage());
					FatApp::redirectUser($redirectUrl);	
				}
			}
				
			$fbAccessToken = $accessToken->getValue();	
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_code']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_access_token']);
			unset($_SESSION['fb_'.FatApp::getConfig("CONF_FACEBOOK_APP_ID").'_user_id']);
			
			$userObj = new User($userId);
			$userData = array('user_fb_access_token'=>$fbAccessToken);
			$userObj->assignValues($userData);
			if (!$userObj->save()) { 
				Message::addErrorMessage(Labels::getLabel("MSG_Token_COULD_NOT_BE_SET",$this->siteLangId) . $userObj->getError());												
			}
		}		
		FatApp::redirectUser($redirectUrl);	
	}
	
	public function twitterCallback(){
		require_once (CONF_INSTALLATION_PATH . 'library/APIs/twitter/twitteroauth.php');
		$get = FatApp::getQueryStringData();
		
		if (!empty($get['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
			// We've got everything we need
			$twitteroauth = new TwitterOAuth(FatApp::getConfig("CONF_TWITTER_API_KEY",FatUtility::VAR_STRING,''), FatApp::getConfig("CONF_TWITTER_API_SECRET",FatUtility::VAR_STRING,''), $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			// Let's request the access token
			$access_token = $twitteroauth->getAccessToken($get['oauth_verifier']);
			// Save it in a session var
			$_SESSION['access_token'] = $access_token;
			// Let's get the user's info
			$twitter_info = $twitteroauth->get('account/verify_credentials');
			//$twitter_info->id
			$anchor_tag=CommonHelper::affiliateReferralTrackingUrl(UserAuthentication::getLoggedUserAttribute('user_referral_code'));
			$urlapi = "http://tinyurl.com/api-create.php?url=".$anchor_tag;
			/*** activate cURL for URL shortening ***/
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $urlapi);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$shorturl = curl_exec($ch);
			curl_close($ch);
			$anchor_length=strlen($shorturl);
			//$message = substr($shorturl." Twitter Message will go here ",0,(140-$anchor_length-6));
			$message = substr($shorturl." ".sprintf(FatApp::getConfig("CONF_SOCIAL_FEED_TWITTER_POST_TITLE".$this->siteLangId,FatUtility::VAR_STRING,''),FatApp::getConfig("CONF_WEBSITE_NAME_".$this->siteLangId)),0,134-$anchor_length);
			$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SOCIAL_FEED_IMAGE, 0, 0, $this->siteLangId );
			if(!empty($file_row))
			{
				$image_path = isset( $file_row['afile_physical_path'] ) ?  $file_row['afile_physical_path'] : '';
				$image_path = CONF_UPLOADS_PATH.$image_path;
				$handle = fopen($image_path,'rb');
				$image = fread($handle,filesize($image_path));
				fclose($handle);
				$parameters = array('media[]' => "{$image};type=image/jpeg;filename={$image_path}",'status' => $message);
				$post = $twitteroauth->post('statuses/update_with_media', $parameters, true);
			}
			else
			{
				$parameters = array('Name' => FatApp::getConfig("CONF_WEBSITE_NAME_".$this->siteLangId),'status' => $message);
				$post = $twitteroauth->post('statuses/update', $parameters, true);
			}
			
			$this->set('errors', isset($post->errors) ? $post->errors : false );
			$this->_template->render(false,false,'buyer/twitter-response.php');
		}
	}
	
	public function sharing(){
		require_once(CONF_INSTALLATION_PATH.'library/Fbapi.php');
		require_once (CONF_INSTALLATION_PATH . 'library/APIs/twitter/twitteroauth.php');
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$userInfo = User::getAttributesById( $loggedUserId, array('user_fb_access_token', 'user_referral_code'));
		$config = array(
			'app_id' => FatApp::getConfig('CONF_FACEBOOK_APP_ID',FatUtility::VAR_STRING,''),
			'app_secret' => FatApp::getConfig('CONF_FACEBOOK_APP_SECRET',FatUtility::VAR_STRING,''),
		);
		$fb = new Fbapi($config);
		
		$fbAccessToken = '';
		$fbLoginUrl = '';
		
		$redirectUrl = CommonHelper::generateFullUrl('Affiliate','getFbToken',array(),'',false);			
		$fbLoginUrl = $fb->getLoginUrl($redirectUrl);
		if($userInfo['user_fb_access_token']!=''){
			$fbAccessToken = $userInfo['user_fb_access_token'];
		}
		
		$sharingFrm = $this->getSharingForm( $this->siteLangId );
		$affiliateTrackingUrl = CommonHelper::affiliateReferralTrackingUrl( $userInfo['user_referral_code'] );
		$this->set( 'affiliateTrackingUrl', $affiliateTrackingUrl );
		$this->set( 'sharingFrm', $sharingFrm );
		$this->set('fbLoginUrl',$fbLoginUrl);
		$this->set('fbAccessToken',$fbAccessToken);
		$this->_template->render(true,false);
	}
	
	public function setUpMailAffiliateSharing(){
		$sharingFrm = $this->getSharingForm( $this->siteLangId );
		$post = $sharingFrm->getFormDataFromArray( FatApp::getPostedData() );
		
		if ( $post == false ) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieWithError( Message::getHtml());
		}
		
		$error = '';
		FatUtility::validateMultipleEmails( $post["email"], $error );
		if( $error != '' ){
			Message::addErrorMessage( $error );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$emailsArr = CommonHelper::multipleExplode(array(",",";","\t","\n"),trim($post["email"],","));
		$emailsArr = array_unique($emailsArr);
		if ( count($emailsArr) && !empty($emailsArr) ){
			$personalMessage = empty($post['message'])?"":"<b>".Labels::getLabel('Lbl_Personal_Message_From_Affiliate',$this->siteLangId).":</b> ".nl2br($post['message']);
			$emailNotificationObj = new EmailHandler();
			foreach( $emailsArr as $email_id ) {
				$email_id = trim($email_id);
				if( !CommonHelper::isValidEmail($email_id) ) continue;
				
				/* email notification handling[ */
				$emailNotificationObj = new EmailHandler();
				if ( !$emailNotificationObj->sendAffiliateMailShare( UserAuthentication::getLoggedUserId(),$email_id ,$personalMessage, $this->siteLangId ) ){
					Message::addErrorMessage( Labels::getLabel($emailNotificationObj->getError(),$this->siteLangId) );
					CommonHelper::redirectUserReferer();
				}
				/* ] */
			}
		}
		
		$this->set( 'msg', Labels::getLabel('MSG_invitation_emails_sent_successfully', $this->siteLangId) );
		$this->_template->render( false, false, 'json-success.php' );
	}
	
	public function addressInfo(){
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$siteLangId = $this->siteLangId;
		$userExtraData = User::getUserExtraData( $loggedUserId, array('uextra_company_name', 'uextra_website') );
		$srch = User::getSearchObject();
		$srch->joinTable( Countries::DB_TBL, 'LEFT OUTER JOIN', 'u.user_country_id = c.country_id', 'c' );
		$srch->joinTable( Countries::DB_TBL_LANG, 'LEFT OUTER JOIN', 'c.country_id = c_l.countrylang_country_id AND countrylang_lang_id = '.$siteLangId, 'c_l' );
		$srch->joinTable( States::DB_TBL, 'LEFT OUTER JOIN', 'u.user_state_id = s.state_id', 's' );
		$srch->joinTable( States::DB_TBL_LANG, 'LEFT OUTER JOIN', 's.state_id = s_l.statelang_state_id AND statelang_lang_id = '.$siteLangId, 's_l' );
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields( array('user_address1', 'user_address2', 'user_zip', 'user_city', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name') );
		$srch->addCondition( 'user_id', '=', $loggedUserId );
		$rs = $srch->getResultSet();
		$userData = FatApp::getDb()->fetch( $rs );
		
		$userExtraData = ( !empty($userExtraData) ) ? $userExtraData : array('uextra_company_name' => '', 'uextra_website' => '');
		$userData = array_merge( $userData, $userExtraData );
		
		$this->set( 'userData', $userData );
		$this->_template->render(false, false);
	}
	
	private function getPaymentInfoForm( $siteLangId ){
		$siteLangId = FatUtility::int( $siteLangId );
		$frm = new Form('frmPaymentInfoForm');
		$frm->addTextBox( Labels::getLabel('LBL_Tax_Id', $siteLangId), 'uextra_tax_id' );
				
		$frm->addRadioButtons( Labels::getLabel('LBL_Payment_Method', $siteLangId), 'uextra_payment_method', User::getAffiliatePaymentMethodArr( $siteLangId ), User::AFFILIATE_PAYMENT_METHOD_CHEQUE, array('class' => 'links--inline') );
		
		$frm->addTextBox( Labels::getLabel('LBL_Cheque_Payee_Name', $siteLangId), 'uextra_cheque_payee_name' );
		
		$frm->addTextBox( Labels::getLabel('LBL_Bank_Name', $siteLangId ), 'ub_bank_name' );
		$frm->addTextBox( Labels::getLabel('LBL_Account_Holder_Name', $siteLangId ), 'ub_account_holder_name' );
		$frm->addTextBox( Labels::getLabel('LBL_Bank_Account_Number', $siteLangId ), 'ub_account_number' );
		$frm->addTextBox( Labels::getLabel('LBL_Swift_Code', $siteLangId ), 'ub_ifsc_swift_code' );
		$frm->addTextArea( Labels::getLabel('LBL_Bank_Address', $siteLangId), 'ub_bank_address' );
		
		$fld = $frm->addTextBox( Labels::getLabel('LBL_PayPal_Email_Account', $siteLangId ), 'uextra_paypal_email_id' );
		$fld->requirements()->setEmail();
		
		$frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Register',$siteLangId));
		$frm->setFormTagAttribute('onsubmit', 'setupAffiliateRegister(this); return(false);');
		return $frm;
	}
	
	private function getSharingForm( $siteLangId ){
		$siteLangId = FatUtility::int( $siteLangId );
		$frm = new Form('frmAffiliateSharingForm');
		$fld = $frm->addTextArea( Labels::getLabel('LBL_Friends_Email',$siteLangId), 'email' );
		$str = Labels::getLabel('LBL_Use_commas_separate_emails',$siteLangId);
		$str .= ", ".Labels::getLabel("LBL_Do_not_use_space_and_comma_at_end_of_string", $siteLangId);
		$fld->htmlAfterField =' <small>(' . $str . ')</small>';
		$fld->requirements()->setRequired();
		$frm->addTextArea(Labels::getLabel('L_Personal_Message',$siteLangId), 'message');
		$frm->addSubmitButton('','btn_submit',Labels::getLabel('L_Invite_Your_Friends',$siteLangId));
		return $frm;
	}
}
?>