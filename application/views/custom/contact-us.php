<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
	$contactFrm->setFormTagAttribute('class', 'form form--normal');
	$captchaFld = $contactFrm->getField('htmlNote');
	$captchaFld->htmlBeforeField = '<div class="field-set">
		   <div class="caption-wraper"><label class="field_label"></label></div>
		   <div class="field-wraper">
			   <div class="field_cover">';
	$captchaFld->htmlAfterField = '</div></div></div>';
	
	$contactFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Custom', 'contactSubmit')); 
	$contactFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
	$contactFrm->developerTags['fld_default_col'] = 12;
?>

<div id="body" class="body  bg--gray">
  <section class="section section--gray">
    <div class="container">
      <div class="breadcrumb">
        <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="heading3"><?php echo Labels::getLabel('LBL_Contact_Us',$siteLangId);?></div>
        </div>
      </div>
      <div class="row layout--grids">
        <div class="col-md-8">
          <div class="box box--white box--space"> <?php echo $contactFrm->getFormHtml(); ?> </div>
        </div>
        <div class="col-md-4">
          <div class="boxcontainer">
            <div class="box--gray"> <i class="fa fa-phone"></i>
              <h3><?php echo FatApp::getConfig('CONF_SITE_PHONE',FatUtility::VAR_STRING,'');?></h3>
              <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?></p>
            </div>
			<?php if(FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'') != '') {?>
			<div class="box--gray"> <i class="fa fa-fax"></i>
              <h3><?php echo FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'');?></h3>
              <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?></p>
            </div>
			<?php }?>
            <div class="box--gray"> <i class="fa fa-briefcase"></i>
              <h3><?php echo Labels::getLabel('LBL_Office',$siteLangId);?></h3>
              <?php echo nl2br(FatApp::getConfig('CONF_ADDRESS_'.$siteLangId,FatUtility::VAR_STRING,''));?> </div>
          </div>
          <?php echo FatUtility::decodeHtmlEntities( nl2br($pageData['epage_content']) );?> </div>
      </div>
    </div>
  </section>
  <div class="gap"></div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>