<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
$frm->setFormTagAttribute('class','form');
/* $frm->setFormTagAttribute('onsubmit','setupContribution(this);return false;'); */
$frm->setFormTagAttribute('action',CommonHelper::generateUrl('Blog','setupContribution'));
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = '12';
$fileFld = $frm->getField('file');
$preferredDimensionsStr = '<small class="text--small">'.Labels::getLabel('MSG_Allowed_Extensions',$siteLangId).'</small>';
$fileFld->htmlAfterField = $preferredDimensionsStr;
if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){
	$captchaFld = $frm->getField('htmlNote');
	$captchaFld->htmlBeforeField = '<div class="field-set">
		   <div class="caption-wraper"><label class="field_label"></label></div>
		   <div class="field-wraper">
			   <div class="field_cover">';
	$captchaFld->htmlAfterField = '</div></div></div>';
}
$isUserLogged = UserAuthentication::isUserLogged();
if($isUserLogged){
	$nameFld = $frm->getField(BlogContribution::DB_TBL_PREFIX.'author_first_name');
	$nameFld->setFieldTagAttribute('readonly','readonly');
}
?>

<div id="body" class="body bg--grey">
  <div class="fixed-container">
    <div class="row">
      <div class="panel">
        <div class="container">
          <div class="box box--white box--space box--fixed ">
            <div class="box__head">
              <h4><?php echo Labels::getLabel('Lbl_Blog_Contribution',$siteLangId); ?></h4>
              <a href="<?php echo CommonHelper::generateUrl('Blog'); ?>" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('Lbl_Back',$siteLangId); ?></a> </div>
            <?php echo $frm->getFormHtml(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://www.google.com/recaptcha/api.js'></script> 
</div>
