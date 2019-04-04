<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$contactFrm->setFormTagAttribute('class', 'form form--contact ml-2 mr-2');
	$contactFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Custom', 'contactSubmit'));
	$contactFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
	$contactFrm->developerTags['fld_default_col'] = 12;
    $fldSubmit = $contactFrm->getField('btn_submit');
	$fldSubmit->addFieldTagAttribute('class','btn--block');
?>

<div id="body" class="body" role="main">
    <section class="bg-contact" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/startup-photos.jpg);"></section>
    <section class="contact-wrapper">
        <div class="container">
            <div class="section-head section--white--head section--head--center">
                <div class="section__heading">
                    <h2><?php echo Labels::getLabel('LBL_Get_in_Touch',$siteLangId);?></h2>
                </div>
            </div>
            <div class="contact-box">
                <div class="row">
                    <div class="col-md-4 order-3 order-md-1">
                        <div class="info-cell contact-pic"> <img src="<?php echo CONF_WEBROOT_URL; ?>images/pexels-photo.jpeg" alt=""></div>
                        <div class="contact-address info-cell">
                            <div class="info-cell-inner"><i class="icn">
                                    <svg class="svg draw">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#address" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#address"></use>
                                    </svg>
                                </i>
                                <h3><?php echo Labels::getLabel('LBL_Address',$siteLangId);?></h3>
                                <?php echo nl2br(FatApp::getConfig('CONF_ADDRESS_'.$siteLangId,FatUtility::VAR_STRING,''));?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 order-1 order-md-2">
                        <div class="section-head section--head--center mt-4 mb-4">
                            <div class="section__heading text-center">
                                <h3><?php echo Labels::getLabel('LBL_Contact_Us',$siteLangId);?></h3>
                                <p><?php echo Labels::getLabel('LBL_Feel_free_to_contact_us_with_your_questions',$siteLangId);?></p>
                            </div>
                        </div>
                        <?php echo $contactFrm->getFormTag();	?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="field-wraper">
                                            <div class="field_cover"><?php echo $contactFrm->getFieldHtml('name'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="field-wraper">
                                            <div class="field_cover"><?php echo $contactFrm->getFieldHtml('email'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="field-wraper">
                                            <div class="field_cover"><?php echo $contactFrm->getFieldHtml('phone'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="field-wraper">
                                            <div class="field_cover"><?php echo $contactFrm->getFieldHtml('message'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){ ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="caption-wraper"><label class="field_label"></label></div>
                                        <div class="field-wraper">
                                            <div class="field_cover">
                                                <?php echo $contactFrm->getFieldHtml('htmlNote'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="field-set">
                                        <div class="caption-wraper"><label class="field_label"></label></div>
                                        <div class="field-wraper">
                                            <div class="field_cover"><?php echo $contactFrm->getFieldHtml('btn_submit'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo $contactFrm->getExternalJS();?>
                        </form>
                    </div>
                    <div class="col-md-4 order-2 order-md-3">
                        <div class="contact-phones info-cell">
                            <div class="info-cell-inner">
                                <i class="icn">
                                    <svg class="svg draw">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#phones" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#phones"></use>
                                    </svg>
                                </i>
                                <h3><?php echo Labels::getLabel('LBL_Contact_Number',$siteLangId);?></h3>
                                <p><?php echo FatApp::getConfig('CONF_SITE_PHONE',FatUtility::VAR_STRING,'');?></p>
                                <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?>
                            </div>
                        </div>
                        <div class="contact-email info-cell">
                            <div class="info-cell-inner">
                                <i class="icn">
                                    <svg class="svg draw">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#email" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#email"></use>
                                    </svg>
                                </i>
                                <?php if(FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'') != '') { ?>
                                  <h3><?php echo Labels::getLabel('LBL_Fax',$siteLangId);?> </h3>
                                  <p><?php echo FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'');?> </p>
                                  <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?></p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="g-map">
    <?php if(FatApp::getConfig('CONF_MAP_IFRAME_CODE',FatUtility::VAR_STRING,'') != '') { ?>
        <?php echo FatApp::getConfig('CONF_MAP_IFRAME_CODE',FatUtility::VAR_STRING);?>
    <?php }?>
    </section>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
