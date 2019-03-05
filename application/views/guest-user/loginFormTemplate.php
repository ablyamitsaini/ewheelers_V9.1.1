<?php
	$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
	$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';
?>
<div id="sign-in" >
	<div class="login-wrapper">
	  <div class="form-side">
		<div class="heading"><?php echo Labels::getLabel('LBL_Login',$siteLangId);?></div>
		<?php
		//$frm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
		$loginFrm->setFormTagAttribute('class', 'form');
		$loginFrm->setFormTagAttribute('name', 'formLoginPage');
		$loginFrm->setFormTagAttribute('id', 'formLoginPage');
		$loginFrm->setValidatorJsObjectName('loginFormObj');

		$loginFrm->setFormTagAttribute('onsubmit','return '. $onSubmitFunctionName . '(this, loginFormObj);');
		$loginFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-12 col-xs-';
		$loginFrm->developerTags['fld_default_col'] = 12;
		$remembermeField = $loginFrm->getField('remember_me');
		$remembermeField->setWrapperAttribute("class", "rememberme-text");
		/* $loginFrm->removeField($loginFrm->getField('remember_me')); */
		$fldforgot = $loginFrm->getField('forgot');
		$fldforgot->value='<a href="'.CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm').'"
		class="forgot">'.Labels::getLabel('LBL_Forgot_Password?',$siteLangId).'</a>';
		$fldSubmit = $loginFrm->getField('btn_submit');

		echo $loginFrm->getFormHtml();?>

		<?php if( $showSignUpLink ){ ?>
		<div class="row">
			<div class="col-md-12 col-xs-12"> <a class="last-button" href="<?php echo CommonHelper::generateUrl('GuestUser', 'loginForm', array(applicationConstants::YES)); ?>"><?php echo sprintf(Labels::getLabel('LBL_Not_Register_Yet?',$siteLangId),FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId));?></a> </div>
		</div>
		<?php } ?>

	  </div>
		<?php
			$facebookLogin  = (FatApp::getConfig('CONF_ENABLE_FACEBOOK_LOGIN', FatUtility::VAR_INT , 0) && FatApp::getConfig('CONF_FACEBOOK_APP_ID', FatUtility::VAR_STRING , ''))?true:false ;
			$googleLogin  =(FatApp::getConfig('CONF_ENABLE_GOOGLE_LOGIN', FatUtility::VAR_INT , 0)&& FatApp::getConfig('CONF_GOOGLEPLUS_CLIENT_ID', FatUtility::VAR_STRING , ''))?true:false ; if ($facebookLogin || $googleLogin ){?>
	  <div class="add-side">
		<div class="heading"><?php echo Labels::getLabel('LBL_Or_Login_With', $siteLangId); ?></div>
		<div class="connect">
		<?php if ($facebookLogin) { ?>
		<a href="javascript:void(0)" onclick="dofacebookInLoginForBuyerpopup()" class="link  fb"><i class="svg"><svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	width="13.5px" height="26px" viewBox="0 0 13.5 26" enable-background="new 0 0 13.5 26" xml:space="preserve">
		  <path  d="M13.5,0.188C13.078,0.125,11.625,0,9.938,0C6.406,0,3.984,2.156,3.984,6.109v3.406H0v4.625h3.984V26h4.781
	V14.141h3.969l0.609-4.625H8.766V6.563c0-1.328,0.359-2.25,2.281-2.25H13.5V0.188z"/>
		  </svg> </i> <?php echo Labels::getLabel('LBL_Login_With_Facebook',$siteLangId);?></a>
		<?php } if ($googleLogin ) { ?>
		  <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'socialMediaLogin',array('googleplus')); ?>" class="link gp"> <i class="svg"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	width="36px" height="22.906px" viewBox="0 0 36 22.906" enable-background="new 0 0 36 22.906" xml:space="preserve">
		  <path   d="M22.453,11.719c0-0.75-0.078-1.328-0.188-1.906H11.453l0,0v3.938h6.5c-0.266,1.672-1.969,4.938-6.5,4.938
	c-3.906,0-7.094-3.234-7.094-7.234s3.188-7.234,7.094-7.234c2.234,0,3.719,0.953,4.563,1.766L19.125,3c-2-1.875-4.578-3-7.672-3
	C5.125,0,0,5.125,0,11.453s5.125,11.453,11.453,11.453C18.063,22.906,22.453,18.266,22.453,11.719z M36,9.813h-3.266V6.547h-3.281
	v3.266h-3.266v3.281h3.266v3.266h3.281v-3.266H36V9.813z"/>
		  </svg> </i> <?php echo Labels::getLabel('LBL_Login_With_Google',$siteLangId);?></a>
		<?php } ?> </div>
	  </div>
	  <?php } ?>
	</div>
</div>
<script>
/*Facebook Login API JS SDK*/

	function dofacebookInLoginForBuyerpopup()
	{
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				//user is authorized
				getUserData();
			} else {
				//user is not authorized
			}
		});

		FB.login(function(response) {
			if (response.authResponse) {
				//user just authorized your app
					getUserData();
			}
		}, {scope: 'email,public_profile', return_scopes: true});
	}

	function getUserData()
	{
		FB.api('/me?fields=id,name,email, first_name, last_name', function(response) {
			response['type'] = <?php echo User::USER_TYPE_BUYER; ?>;
			fcom.updateWithAjax(fcom.makeUrl('GuestUser', 'loginFacebook'), response, function(t) {
				location.href = t.url;
			});
		}, {scope: 'public_profile,email'});
	}

	window.fbAsyncInit = function() {
		//SDK loaded, initialize it
		FB.init({
			appId      : '<?php echo FatApp::getConfig('CONF_FACEBOOK_APP_ID',FatUtility::VAR_STRING,'') ?>',
			xfbml      : true,
			version    : 'v2.2'
		});
	};

	//load the JavaScript SDK
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	/*Facebook Login API JS SDK*/
</script>
