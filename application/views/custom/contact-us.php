<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$contactFrm->setFormTagAttribute('class', 'form form--normal');
$contactFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Custom', 'contactSubmit'));
$contactFrm->developerTags['colClassPrefix'] = 'col-md-';
$contactFrm->developerTags['fld_default_col'] = 6;
$fld = $contactFrm->getField('phone');
$fld->developerTags['col'] = 12;
$fld = $contactFrm->getField('message');
$fld->developerTags['col'] = 12;
$fldSubmit = $contactFrm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn--block'); ?>
<div id="body" class="body" role="main">
    <section class="section bg-contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="section-head section--white--head">
                        <div class="section__heading">
                            <h2><?php echo Labels::getLabel('LBL_Get_in_Touch', $siteLangId);?></h2>
                            <p><?php echo Labels::getLabel('LBL_Get_in_Touch_Txt', $siteLangId);?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-8">
                            <?php echo $contactFrm->getFormHtml(); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-gray rounded p-4">
                                <h6><?php echo Labels::getLabel('LBL_General_Inquiry', $siteLangId);?></h6>
                                <p class="small"><?php echo FatApp::getConfig('CONF_SITE_PHONE', FatUtility::VAR_STRING, '');?> <br><?php echo Labels::getLabel('LBL_24_a_day_7_days_week', $siteLangId);?></p>
                                <div class="gap"></div>
                                <div class="divider"></div>
                                <div class="gap"></div>
                                <h6><?php echo Labels::getLabel('LBL_Fax', $siteLangId);?> </h6>
                                <p class="small"><?php echo FatApp::getConfig('CONF_SITE_FAX', FatUtility::VAR_STRING, '');?>
                                <br><?php echo Labels::getLabel('LBL_24_a_day_7_days_week', $siteLangId);?></p>
                                <div class="gap"></div>
                                <div class="divider"></div>
                                <div class="gap"></div>
                                <h6><?php echo Labels::getLabel('LBL_Address', $siteLangId);?></h6>
                                <p class="small"><?php echo nl2br(FatApp::getConfig('CONF_ADDRESS_'.$siteLangId, FatUtility::VAR_STRING, ''));?></p>
                                <div class="gap"></div>
                                <?php $this->includeTemplate( '_partial/footerSocialMedia.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="g-map">
        <?php if (FatApp::getConfig('CONF_MAP_IFRAME_CODE', FatUtility::VAR_STRING, '') != '') {
            echo FatApp::getConfig('CONF_MAP_IFRAME_CODE', FatUtility::VAR_STRING);
        } ?>
    </section>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
