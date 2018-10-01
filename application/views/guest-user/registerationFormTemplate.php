<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$showLogInLink = isset($showLogInLink) ? $showLogInLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : false;

$frm->setFormTagAttribute('action', CommonHelper::generateUrl('GuestUser', 'register'));

if( $onSubmitFunctionName ){
	$frm->setValidatorJsObjectName('SignUpValObj');
	$frm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, SignUpValObj); return(false);');
}
?>
<h3><?php echo Labels::getLabel('LBL_Register',$siteLangId);?></h3>
<?php
$frm->setFormTagAttribute('class', 'form form--normal');
$fld = $frm->getField('btn_submit');

$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;

// $frm->getField('user_password')->addFieldTagAttribute('title' , Labels::getLabel('LBL_checkout_Sign_Up_Help_Points', $siteLangId));

echo $frm->getFormTag();  ?>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"><?php echo Labels::getLabel('LBL_NAME',$siteLangId); ?><span class="mandatory">*</span></label></div>
		   <div class="field-wraper">
			   <div class="field_cover"><?php echo $frm->getFieldHtml('user_name'); ?></div>
		   </div>
	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"><?php echo Labels::getLabel('LBL_USERNAME',$siteLangId); ?><span class="mandatory">*</span></label></div>
		   <div class="field-wraper">
			   <div class="field_cover"><?php echo $frm->getFieldHtml('user_username'); ?></div>
		   </div>
	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"><?php echo Labels::getLabel('LBL_EMAIL',$siteLangId); ?><span class="mandatory">*</span></label></div>
		   <div class="field-wraper">
			   <div class="field_cover"><?php echo $frm->getFieldHtml('user_email'); ?></div>
		   </div>
	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"><?php echo Labels::getLabel('LBL_PASSWORD',$siteLangId); ?><span class="mandatory">*</span></label></div>
		   <div class="field-wraper">
			   <div class="field_cover"><?php echo $frm->getFieldHtml('user_password'); ?></div>
			  <span class="text--small"><?php echo sprintf(Labels::getLabel('LBL_Example_password',$siteLangId),
'User@123') ?></span>
		   </div>

	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"><?php echo Labels::getLabel('LBL_CONFIRM_PASSWORD',$siteLangId); ?><span class="mandatory">*</span></label></div>
		   <div class="field-wraper">
			   <div class="field_cover"><?php echo $frm->getFieldHtml('password1'); ?></div>
		   </div>
	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <label class="checkbox">
		   <?php
				$fld = $frm->getFieldHTML('agree');
				$fld = str_replace("<label >","",$fld);
				$fld = str_replace("</label>","",$fld);
				echo $fld;
			?>
			<i class="input-helper"></i>
		   <?php echo sprintf(Labels::getLabel('LBL_I_agree_to_the_terms_conditions',$siteLangId),
"<a target='_blank' href='$termsAndConditionsLinkHref'>".Labels::getLabel('LBL_Terms_Conditions',$siteLangId).'</a>') ?>
		   </label>
		   <?php if($frm->getField('user_newsletter_signup')) { ?>
		   <span class="gap"></span>
		   <label class="checkbox">
		   <?php
				$fld = $frm->getFieldHTML('user_newsletter_signup');
				$fld = str_replace("<label >","",$fld);
				$fld = str_replace("</label>","",$fld);
				echo $fld;
			?>
			<i class="input-helper"></i>
		   </label>
		   <?php }
			if($frm->getField('isCheckOutPage')) {
				echo $frm->getFieldHTML('isCheckOutPage');
			} ?>
	   </div>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
	   <div class="field-set">
		   <div class="caption-wraper"><label class="field_label"></label></div>
		   <div class="field-wraper">
			   <div class="field_cover">
			   <?php echo $frm->getFieldHTML('user_id') , $frm->getFieldHTML('btn_submit'); ?>
			   </div>
		   </div>
	   </div>
   </div>
</div>
</form>
<?php echo $frm->getExternalJs(); ?>
<?php if( $showLogInLink ){ ?>
<p class="text--dark"><?php echo sprintf(Labels::getLabel( 'LBL_Already_to', $siteLangId ), FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId));?>
<a href="<?php echo CommonHelper::generateUrl('GuestUser', 'loginForm'); ?>" class="text text--uppercase"><?php echo Labels::getLabel('LBL_Sign_in',$siteLangId); ?></a></p>
<?php } ?>
