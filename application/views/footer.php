<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
</div>
<?php /* if(CommonHelper::demoUrl()){ */ ?>
<div class="no-print fixed-demo-btn" id="demo-btn"><a href="javascript:void(0);" class="request-demo" id="btn-demo">Request
            a Demo</a></div>
<?php /* } */ ?>
<footer id="footer" class="no-print clearfix">
    <section class="bg-light">

        <div class="back-to-top">
            <a href="#top">
                <?php echo Labels::getLabel('LBL_Back_To_Top',$siteLangId);?> </a>
        </div>
    </section>
    <?php if( $controllerName == 'home' && $action == 'index' ) $this->includeTemplate( '_partial/footerTrustBanners.php'); ?>
    <div class="fixed-container">
        <div class="up-footer padd40">
            <div class="row">
                <?php $this->includeTemplate( '_partial/footerNavigation.php'); ?>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="">
                        <?php $this->includeTemplate( '_partial/footerSocialMedia.php'); ?>
                        <?php $site_conatct = FatApp::getConfig('CONF_SITE_PHONE',FatUtility::VAR_STRING,''); 
			if( $site_conatct ){ ?>
                        <div class="f-heading">
                            <?php echo Labels::getLabel('LBL_Call_Us',$siteLangId); ?> <span><?php echo $site_conatct;?></span></div>
                        <?php } ?>
                        <div class="gap"></div>
                        <?php $email_id = FatApp::getConfig('CONF_CONTACT_EMAIL',FatUtility::VAR_STRING,''); 
			if( $email_id ){ ?>
                        <div class="f-heading">
                            <?php echo Labels::getLabel('LBL_Email_Us',$siteLangId); ?><span><a href="mailto:<?php echo $email_id; ?>"><?php echo $email_id;?></a></span></div>
                        <?php } ?>
                        <div class="gap"></div>
                        <div class="f-heading">
                            <?php echo Labels::getLabel('LBL_Sell_With', $siteLangId)." ".FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId,FatUtility::VAR_STRING,''); ?></div>
                        <div>
                            <a href="<?php echo CommonHelper::generateUrl('supplier');?>" class="btn btn--secondary  btn--sm  ripplelink">
                                <?php echo Labels::getLabel('LBL_Open_a_store', $siteLangId); ?> </a>
                        </div>
                        <?php /* <div class="gap"></div>
            <div class="f-heading"><?php echo Labels::getLabel('LBL_DOWNLOAD_THE_APP',$siteLangId); ?> [Pending]</div>
                    <div class="g-play"><a href="javascript:void(0)"><img src="<?php echo CONF_WEBROOT_URL; ?>images/g-play.png" alt="<?php echo Labels::getLabel('LBL_Download_APP', $siteLangId); ?>"></a></div> */ ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="bg-light">
                    <div class="subscription">
						<?php if( FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION',FatUtility::VAR_INT,0) ){?>
                        <div class="f-heading">
                            <?php echo Labels::getLabel('LBL_GET_MORE_FROM_Yo-Kart', $siteLangId);?>
                        </div>						
                        <?php } $this->includeTemplate( '_partial/footerNewsLetterForm.php'); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="f-heading">
                                    <?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId);?>
                                </div>
                                <div class="payment"><img src="<?php echo CONF_WEBROOT_URL; ?>images/payment.jpg" alt="<?php echo Labels::getLabel('LBL_PAYMENT_OPTIONS', $siteLangId); ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="fixed-container">
            <div class="accordion-footer">
                <?php $this->includeTemplate( '_partial/footerTopBrands.php'); ?>
                <?php $this->includeTemplate( '_partial/footerTopCategories.php'); ?>
            </div>
        </div>
    </div>
    <div class="copyright">
        <?php echo sprintf(Labels::getLabel('LBL_copyright_text', $siteLangId),date("Y"))?>
    </div>
    </div>
    <div class="common_overlay"></div>
</footer>
<?php if(FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) && !CommonHelper::getUserCookiesEnabled()){ ?>
<div class="cc-window cc-banner cc-type-info cc-theme-block cc-bottom cookie-alert">
    <?php if(FatApp::getConfig('CONF_COOKIES_TEXT_'.$siteLangId, FatUtility::VAR_STRING, '')) { ?>
	<div class="box-cookies">
		<span id="cookieconsent:desc" class="cc-message">
		<?php echo FatUtility::decodeHtmlEntities( FatApp::getConfig('CONF_COOKIES_TEXT_'.$siteLangId, FatUtility::VAR_STRING, '') );?>
		<a href="<?php echo CommonHelper::generateUrl('cms','view',array(FatApp::getConfig('CONF_COOKIES_BUTTON_LINK', FatUtility::VAR_INT)));?>"><?php echo Labels::getLabel('LBL_Read_More', $siteLangId);?></a></span>
		<span class="cc-close cc-cookie-accept-js"><?php echo Labels::getLabel('LBL_Accept_Cookies', $siteLangId);?></span>
	</div>
	<?php } ?>
</div>
<?php }?>
<svg style="display: none;">
<symbol id="heart-fav">
  <path d="M7.998,13.711c0.143,0,0.285-0.054,0.393-0.16l5.562-5.356c0.08-0.08,2.044-1.874,2.044-4.017
	C15.996,1.563,14.398,0,11.729,0c-1.563,0-3.026,1.232-3.731,1.928C7.293,1.232,5.829,0,4.267,0C1.598,0,0,1.563,0,4.178
	C0,6.32,1.964,8.114,2.035,8.176l5.57,5.375C7.713,13.657,7.855,13.711,7.998,13.711z"></path>
</symbol>
<symbol id="collection-list">
  <g>
    <path d="m15.068,10.225h45.851c1.128,0 2.041-0.913 2.041-2.041 0-1.126-0.913-2.04-2.041-2.04h-45.851c-1.128,0-2.04,0.914-2.04,2.04 1.77636e-15,1.128 0.912,2.041 2.04,2.041z"></path>
    <path d="m60.919,30.03h-45.851c-1.128,0-2.04,0.914-2.04,2.04s0.912,2.041 2.04,2.041h45.851c1.128,0 2.041-0.915 2.041-2.041s-0.913-2.04-2.041-2.04z"></path>
    <path d="m60.919,53.965h-45.851c-1.128,0-2.04,0.912-2.04,2.04 0,1.126 0.912,2.041 2.04,2.041h45.851c1.128,0 2.041-0.915 2.041-2.041 7.10543e-15-1.128-0.913-2.04-2.041-2.04z"></path>
    <path d="m4.577,12.468c2.413,0 4.366-1.956 4.366-4.369 0-2.414-1.953-4.366-4.366-4.366-2.415,0-4.368,1.952-4.368,4.366 3.60822e-16,2.413 1.953,4.369 4.368,4.369z"></path>
    <path d="m4.577,36.329c2.413,0 4.366-1.955 4.366-4.368s-1.953-4.368-4.366-4.368c-2.415,0-4.368,1.955-4.368,4.368s1.953,4.368 4.368,4.368z"></path>
    <path d="m4.577,51.633c-2.417,0-4.37,1.957-4.37,4.37 0,2.416 1.953,4.37 4.37,4.37 2.413,0 4.368-1.954 4.368-4.37 0-2.413-1.955-4.37-4.368-4.37z"></path>
  </g>
</symbol>
<symbol id="collection-share">
  <g>
    <path d="M12 10c-0.8 0-1.4 0.3-2 0.8l-3.2-1.8c0.1-0.3 0.2-0.7 0.2-1s-0.1-0.7-0.2-1l3.2-1.8c0.6 0.5 1.2 0.8 2 0.8 1.7 0 3-1.3 3-3s-1.3-3-3-3-3 1.3-3 3c0 0.2 0 0.3 0 0.5l-3.5 1.9c-0.4-0.2-0.9-0.4-1.5-0.4-1.6 0-3 1.3-3 3v0c0 1.6 1.4 3 3 3 0.6 0 1.1-0.2 1.5-0.4l3.5 1.9c0 0.2 0 0.3 0 0.5 0 1.7 1.3 3 3 3s3-1.3 3-3-1.3-3-3-3z"></path>
  </g>
</symbol>
<symbol id="quick-view">
   <g>
    <path fill="#ffffff" d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9   C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z"/>
  </g>
</symbol>
</svg>
<?php if(!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY',FatUtility::VAR_STRING,'') != ''){ ?>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY',FatUtility::VAR_STRING,'');?>&libraries=places'></script>
<script>
    window.onload = function() {
        var startPos;
        var geoOptions = {
            enableHighAccuracy: true,
        };

        /* initialize(); */

        var geocoder;
        var geoSuccess = function(position) {

            startPos = position;
            codeLatLng(startPos.coords.latitude, startPos.coords.longitude);
        };

        var geoError = function(error) {
            if (error.code == 1) {
                alert("Allow google To Access Your Current Location");
            }
            console.log('Error occurred. Error code: ' + error.code);

        };

        /* navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions); */
    }
</script>
<?php } ?>
<?php if(FatApp::getConfig('CONF_ENABLE_LIVECHAT',FatUtility::VAR_STRING,'')){ echo FatApp::getConfig('CONF_LIVE_CHAT_CODE',FatUtility::VAR_STRING,''); }?>
<?php if(FatApp::getConfig('CONF_SITE_TRACKER_CODE',FatUtility::VAR_STRING,'')){ echo FatApp::getConfig('CONF_SITE_TRACKER_CODE',FatUtility::VAR_STRING,''); }?>

<script type="text/javascript" src="<?php
$fl = 'js/variables.js';
echo FatUtility::generateUrl ( 'JsCss', 'js', array (), '', false ). '&f=' . rawurlencode ( $fl );
?>"></script>

<?php if(CommonHelper::demoUrl()){?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5898f87bf1b57c0a05d78696/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php }?>
</body>
</html>
<?php 
//$content  = ob_get_clean();
//echo CommonHelper::minify_html($content); 
?>