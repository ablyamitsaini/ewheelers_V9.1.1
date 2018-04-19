<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php 
	$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true; 
	$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';
?>
  <h3><?php echo Labels::getLabel('LBL_Login',$siteLangId);?></h3>
  <?php 
	//$frm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
	$loginFrm->setFormTagAttribute('class', 'form form--normal');
	$loginFrm->setValidatorJsObjectName('loginValObj');
	$loginFrm->setFormTagAttribute('action', CommonHelper::generateUrl('GuestUser', 'login')); 
	$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginValObj); return(false);');
	$loginFrm->developerTags['colClassPrefix'] = 'col-md-';
	$loginFrm->developerTags['fld_default_col'] = 12;
	
	
	$fldforgot = $loginFrm->getField('forgot');
	$fldforgot->value='<a href="'.CommonHelper::generateUrl('GuestUser', 'forgotPasswordForm').'" 
		class="link link--normal">'.Labels::getLabel('LBL_Forgot_Password',$siteLangId).'?</a>';
	// $fldforgot->addFieldTagAttribute('class' , 'link');
	$fldSubmit = $loginFrm->getField('btn_submit');
	$fldSubmit->attachField($fldforgot);
		

	echo $loginFrm->getFormHtml();
	$facebookLogin  = (FatApp::getConfig('CONF_ENABLE_FACEBOOK_LOGIN', FatUtility::VAR_INT , 0) && FatApp::getConfig('CONF_FACEBOOK_APP_ID', FatUtility::VAR_STRING , ''))?true:false ;
	$googleLogin  =(FatApp::getConfig('CONF_ENABLE_GOOGLE_LOGIN', FatUtility::VAR_INT , 0)&& FatApp::getConfig('CONF_GOOGLEPLUS_CLIENT_ID', FatUtility::VAR_STRING , ''))?true:false ;
	if ($facebookLogin || $googleLogin ){?>
	  <h3><?php echo Labels::getLabel('LBL_Or', $siteLangId); ?></h3>
	   <div class="group group--social group--social-onehalf ">
	  <?php if ($facebookLogin) { ?>
	  <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'socialMediaLogin',array('facebook')); ?>" class="btn  btn--social fb-color"><i class="fa fa-facebook"></i> <?php echo Labels::getLabel('LBL_Facebook',$siteLangId);?></a>
<?php } if ($googleLogin ) { ?>
	  <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'socialMediaLogin',array('googleplus')); ?>" class="btn btn--social gp-color"><i class="fa fa-google-plus"></i> <?php echo Labels::getLabel('LBL_Google_Plus',$siteLangId);?></a> 
<?php }?>
</div>
<?php

 } if( $showSignUpLink ){ ?>
		<p class="text--dark"><?php echo sprintf(Labels::getLabel('LBL_New_to',$siteLangId),FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId));?>? <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'registrationForm'); ?>" class="text text--uppercase"><?php echo Labels::getLabel('LBL_Sign_Up',$siteLangId);?></a></p>
	<?php } 
	
	
	?>
