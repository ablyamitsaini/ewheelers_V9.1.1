<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!$isUserDashboard) { ?>
<footer id="footer" class="footer no-print" role="site-footer">
    <section class="bg-light">
        <div class="back-to-top">
            <a href="#top">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow"></use>
                </svg></a>
        </div>
    </section>
    <?php if ($controllerName == 'home' && $action == 'index') {
        $this->includeTemplate('_partial/footerTrustBanners.php');
    } ?>
    <div class="container">
        <div class="up-footer section">
            <div class="row">
                <?php $this->includeTemplate('_partial/footerNavigation.php'); ?>
                <div class="col-lg-2 col-md-4 col-sm-12 column">
                    <div class="toggle-group">
                        <h5 class="toggle__trigger toggle__trigger-js"><?php echo Labels::getLabel('LBL_Sell_With', $siteLangId)." ".FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId, FatUtility::VAR_STRING, ''); ?></h5>
                        <div class="toggle__target toggle__target-js">
                            <div class="store-button">
                                <a href="<?php echo CommonHelper::generateUrl('supplier');?>" class="btn btn--primary ripplelink storeBtn-js"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/store-icn.png" alt=""></i>
                                    <?php echo Labels::getLabel('LBL_Open_a_store', $siteLangId); ?> </a>
                            </div>
                            <?php /* <div class="gap"></div>
                            <div class="f-heading"><?php echo Labels::getLabel('LBL_DOWNLOAD_THE_APP',$siteLangId); ?> [Pending]
                        </div>
                        <div class="g-play"><a href="javascript:void(0)"><img src="<?php echo CONF_WEBROOT_URL; ?>images/g-play.png" alt="<?php echo Labels::getLabel('LBL_Download_APP', $siteLangId); ?>"></a></div> */ ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-12 col-xs-12 column">
                <?php if (FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION', FatUtility::VAR_INT, 0)) { ?>
                <div class="toggle-group">
                    <h5 class="toggle__trigger toggle__trigger-js"><?php echo Labels::getLabel('LBL_Sign_Up_To_Our_Newsletter', $siteLangId);?></h5>
                    <div class="toggle__target toggle__target-js">
                        <p><?php echo Labels::getLabel('LBL_Be_the_first_to_here_about_the_latest_trends,_new_arrivals_&_exclusive_offers', $siteLangId);?></p>
                        <?php $this->includeTemplate('_partial/footerNewsLetterForm.php'); } ?>
                        <ul class="contact-info">
                            <?php $site_conatct = FatApp::getConfig('CONF_SITE_PHONE', FatUtility::VAR_STRING, '');
                                if ($site_conatct) { ?>
                            <li><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/icn-mobile.png"></i><?php echo $site_conatct;?></li>
                            <?php } ?>
                            <?php $email_id = FatApp::getConfig('CONF_CONTACT_EMAIL', FatUtility::VAR_STRING, '');
                                if ($email_id) { ?>
                            <li><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/icn-email.png"></i> <a href="mailto:<?php echo $email_id; ?>"><?php echo $email_id;?></a> </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php /*<div class="middle-footer">
        <div class="accordion-footer">
            <?php $this->includeTemplate('_partial/footerTopBrands.php'); ?>
            <?php $this->includeTemplate('_partial/footerTopCategories.php'); ?>
        </div>
    </div>*/ ?>
    <div class="bottom-footer">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php $this->includeTemplate('_partial/footerSocialMedia.php'); ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="copyright">
                    <?php 
                    $replacements = array(
                        '{YEAR}'=> '&copy; '.date("Y"),
                        '{PRODUCT}'=>'<a target="_blank" href="https://yo-rent.com">Yo!Rent</a>',
                        '{OWNER}'=> '<a target="_blank" href="https://www.fatbit.com">FATbit Technologies</a>',
                    );
                    echo CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $siteLangId), $replacements);   
                ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="payment">
                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/payment.png" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>">
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>
<?php } ?>
<?php if (FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) && !CommonHelper::getUserCookiesEnabled()) { ?>
<div class="cc-window cc-banner cc-type-info cc-theme-block cc-bottom cookie-alert no-print">
    <?php if (FatApp::getConfig('CONF_COOKIES_TEXT_'.$siteLangId, FatUtility::VAR_STRING, '')) { ?>
    <div class="box-cookies">
        <span id="cookieconsent:desc" class="cc-message">
            <?php echo FatUtility::decodeHtmlEntities(mb_substr(FatApp::getConfig('CONF_COOKIES_TEXT_'.$siteLangId, FatUtility::VAR_STRING, ''), 0, 500));?>
            <a href="<?php echo CommonHelper::generateUrl('cms', 'view', array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT)));?>"><?php echo Labels::getLabel('LBL_Read_More', $siteLangId);?></a></span>
        <span class="cc-close cc-cookie-accept-js"><?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId);?></span>
    </div>
    <?php } ?>
</div>
<?php } ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '');?>"></script>
<script>
    enterLocation();
</script>
<?php 
    if (empty(SessionHelper::getUserLocation()) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '' && 0) { ?>
<script>
    window.onload = function() {
        var startPos;
        var geoOptions = {
            enableHighAccuracy: true,
        };

        var geoSuccess = function(position) {
            startPos = position;
            codeLatLng(startPos.coords.latitude, startPos.coords.longitude);
        };

        var geoError = function(error) {
            /* if (error.code == 1) {
                alert("Allow google To Access Your Current Location");
            } */
            console.log('Error occurred. Error code: ' + error.code);
        };
        
        navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
    }
</script>
<?php } 

if (FatApp::getConfig('CONF_ENABLE_LIVECHAT', FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig('CONF_LIVE_CHAT_CODE', FatUtility::VAR_STRING, '');
}
if (FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '');
}

?>
</div>
</div>
</body>
</html>