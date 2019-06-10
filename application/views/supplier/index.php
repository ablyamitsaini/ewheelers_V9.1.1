<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="after-header"></div>
<div id="body" class="body">
    <?php $haveBgImage =AttachedFile::getAttachment(AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId);
    $bgImageUrl = ($haveBgImage) ? "background-image:url(" . CommonHelper::generateUrl('Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, 'DEFAULT', AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE)) . ")" : "background-image:url(".CONF_WEBROOT_URL."images/seller-bg.jpg);"; ?>
    <div class="banner" style="<?php echo $bgImageUrl; ?>">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                    <div class="seller-slogan">
                        <div class="seller-slogan-txt"> <?php echo FatUtility::decodeHtmlEntities(nl2br($slogan['epage_content']));?> </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="seller-register-form">
                        <div class="heading3"><?php echo Labels::getLabel('L_Register_Today', $siteLangId); ?></div>
                        <div class="gap"></div>
                        <?php $sellerFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                            $sellerFrm->developerTags['fld_default_col'] = 12;
                            echo $sellerFrm->getFormHtml(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="padding20"><?php echo FatUtility::decodeHtmlEntities($formText['epage_content']);?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($block1)) { ?>
        <div class="features">
            <div class="container"><?php echo FatUtility::decodeHtmlEntities($block1['epage_content']); ?></div>
        </div>
    <?php }
    if (!empty($block2)) { ?>
        <div class="simple-step">
        <div class="container"> <?php echo FatUtility::decodeHtmlEntities($block2['epage_content']); ?> </div>
        </div>
    <?php }
    if (!empty($block3)) { ?>
        <div class="simple-price">
            <div class="container"> <?php echo FatUtility::decodeHtmlEntities($block3['epage_content']); ?> </div>
        </div>
    <?php }
    if ($faqCount > 0) { ?>
        <div class="questions-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div id="listing"></div>
                        <div class="gap"> </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="heading3"><?php echo Labels::getLabel('LBL_Browse_By_Category', $siteLangId)?></div>
                        <div class="row">
                            <div id="categoryPanel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
    <?php } ?>
    <div class="gap"></div>
    <div class="container">
        <div class="align--center">
            <div class="heading3"><?php echo Labels::getLabel('LBL_Still_need_help', $siteLangId)?> ?</div>
            <a href="<?php echo CommonHelper::generateUrl('custom', 'contact-us'); ?>" class="btn btn--secondary btn--lg ripplelink"><?php echo Labels::getLabel('LBL_Contact_Customer_Care', $siteLangId)?> </a>
        </div>
        <div class="gap"></div>
    </div>
    <div class="gap"></div>
</div>
<!-- End Document
================================================== -->
