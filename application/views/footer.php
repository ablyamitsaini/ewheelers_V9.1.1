<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php if(CommonHelper::demoUrl()){ ?>
<div class="no-print fixed-demo-btn" id="demo-btn"><a href="javascript:void(0);" class="request-demo" id="btn-demo">Request a Demo</a></div>
<div class="feedback-btn">
		<a href="https://www.yo-kart.com/yokart-marketing-website-feedback.html<?php /* echo CommonHelper::generateUrl('Custom','feedback'); */?>" class="crcle-btn">
			<svg xmlns="http://www.w3.org/2000/svg" width="80px" height="80px" viewBox="0 0 225.125 207">
    <path id="Forma_1_copy" data-name="Forma 1 copy" class="cls-1" d="M141.943,43.643a8.845,8.845,0,0,1-15.1-6.253A8.846,8.846,0,1,1,141.943,43.643ZM135.423,59.5c0.655-1.516,2.415-1.214,3.93-.558a2.992,2.992,0,0,1,1.559,3.931,24.676,24.676,0,0,1-22.851,14.579c-10.266,0-19.288-5.751-22.985-14.652a2.99,2.99,0,0,1,2.761-4.136c1.172,0,2.284-.307,2.761.843,2.768,6.663,9.622,10.966,17.463,10.966A18.7,18.7,0,0,0,135.423,59.5Zm-35.111-13.27a8.847,8.847,0,0,1-8.845-8.845,8.845,8.845,0,1,1,15.1,6.253A8.526,8.526,0,0,1,100.312,46.234Zm101.631,95.909a8.84,8.84,0,1,1,2.592-6.254A8.529,8.529,0,0,1,201.943,142.143ZM199.91,176.48a2.991,2.991,0,0,1-1.558,3.932c-1.516.658-3.276,0.958-3.932-.559a18.7,18.7,0,0,0-17.363-10.974c-7.842,0-14.7,4.305-17.465,10.968-0.478,1.15-1.591.844-2.762,0.844a2.993,2.993,0,0,1-2.761-4.138c3.7-8.9,12.722-14.655,22.988-14.655A24.682,24.682,0,0,1,199.91,176.48Zm-39.6-31.746a8.846,8.846,0,1,1,6.253-2.591A8.524,8.524,0,0,1,160.312,144.734ZM106,89m0,0,0,0,0,0-1.049,38.363a52.838,52.838,0,0,0-19.312-19.312A51.914,51.914,0,0,0,59,100.934a51.909,51.909,0,0,0-26.638,7.117,52.822,52.822,0,0,0-19.313,19.312,53.405,53.405,0,0,0,0,53.275A52.844,52.844,0,0,0,32.363,199.95,51.92,51.92,0,0,0,59,207.066a51.918,51.918,0,0,0,26.637-7.116,52.847,52.847,0,0,0,19.313-19.312A53.414,53.414,0,0,0,104.951,127.363ZM99.7,171.171A43.606,43.606,0,0,1,76.172,194.7a43.583,43.583,0,0,1-34.342,0A43.6,43.6,0,0,1,18.3,171.171a43.593,43.593,0,0,1,0-34.342A43.607,43.607,0,0,1,41.831,113.3a43.606,43.606,0,0,1,34.342,0A43.612,43.612,0,0,1,99.7,136.829,43.582,43.582,0,0,1,99.7,171.171ZM76.69,149.578a8.849,8.849,0,1,1,6.253-2.592A8.523,8.523,0,0,1,76.69,149.578Zm-35.378,0a8.845,8.845,0,1,1,6.253-15.1A8.845,8.845,0,0,1,41.312,149.578Zm-4.422,17.69H81.113a4.422,4.422,0,0,1,0,8.843H36.89A4.422,4.422,0,0,1,36.89,167.268Zm187.061-39.9a52.836,52.836,0,0,0-19.312-19.312,53.408,53.408,0,0,0-53.275,0,52.816,52.816,0,0,0-19.313,19.312,53.4,53.4,0,0,0,0,53.275,52.839,52.839,0,0,0,19.313,19.312,53.414,53.414,0,0,0,53.275,0,52.846,52.846,0,0,0,19.313-19.312A53.414,53.414,0,0,0,223.951,127.363ZM218.7,171.171A43.606,43.606,0,0,1,195.172,194.7a43.582,43.582,0,0,1-34.341,0A43.6,43.6,0,0,1,137.3,171.171a43.6,43.6,0,0,1,0-34.342A43.6,43.6,0,0,1,160.831,113.3a43.6,43.6,0,0,1,34.341,0A43.612,43.612,0,0,1,218.7,136.829,43.584,43.584,0,0,1,218.7,171.171ZM163.951,26.363A52.84,52.84,0,0,0,144.639,7.051a53.408,53.408,0,0,0-53.275,0A52.828,52.828,0,0,0,72.051,26.363,51.908,51.908,0,0,0,64.933,53,51.922,51.922,0,0,0,72.05,79.638,52.85,52.85,0,0,0,91.363,98.95a53.416,53.416,0,0,0,53.275,0,52.848,52.848,0,0,0,19.313-19.313A51.922,51.922,0,0,0,171.067,53,51.917,51.917,0,0,0,163.951,26.363ZM158.7,70.171A43.607,43.607,0,0,1,135.172,93.7a43.582,43.582,0,0,1-34.341,0A43.6,43.6,0,0,1,77.3,70.171a43.592,43.592,0,0,1,0-34.342A43.6,43.6,0,0,1,100.831,12.3a43.6,43.6,0,0,1,34.341,0A43.607,43.607,0,0,1,158.7,35.829,43.583,43.583,0,0,1,158.7,70.171Z" transform="translate(-5.938)"></path>
</svg>
	</a>
		<a class="cap" href="https://www.yo-kart.com/yokart-marketing-website-feedback.html<?php /* echo CommonHelper::generateUrl('Custom','feedback'); */?>">Give Feedback</a>
	</div>
<?php } ?>
<footer id="footer" class="footer no-print" role="site-footer">
    <section class="bg-light">
        <div class="back-to-top">
            <a href="#top">
							<svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#up-arrow"></use>
				</svg></a>
        </div>
    </section>
    <?php if( $controllerName == 'home' && $action == 'index' ) $this->includeTemplate( '_partial/footerTrustBanners.php'); ?>
    <div class="container">
        <div class="up-footer section">
            <div class="row">
                <?php $this->includeTemplate( '_partial/footerNavigation.php'); ?>
                <div class="col-lg-2 col-md-2 col-sm-12 column">
					<div class="">
						<div class="f-heading">
							<?php echo Labels::getLabel('LBL_Sell_With', $siteLangId)." ".FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId,FatUtility::VAR_STRING,''); ?>
						</div>
						<div class="store-button">
						<a href="<?php echo CommonHelper::generateUrl('supplier');?>" class="btn btn--primary ripplelink storeBtn-js"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/store-icn.png" alt=""></i>
							<?php echo Labels::getLabel('LBL_Open_a_store', $siteLangId); ?> </a>
						</div>
						<?php /* <div class="gap"></div>
						<div class="f-heading"><?php echo Labels::getLabel('LBL_DOWNLOAD_THE_APP',$siteLangId); ?> [Pending]</div>
						<div class="g-play"><a href="javascript:void(0)"><img src="<?php echo CONF_WEBROOT_URL; ?>images/g-play.png" alt="<?php echo Labels::getLabel('LBL_Download_APP', $siteLangId); ?>"></a></div> */ ?>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 column">
					<?php if( FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION',FatUtility::VAR_INT,0) ){ ?><div class="newsletter">
						<h4><?php echo Labels::getLabel('LBL_Sign_Up_To_Our_Newsletter', $siteLangId);?></h4>
						<p><?php echo Labels::getLabel('LBL_Be_the_first_to_here_about_the_latest_trends,_new_arrivals_&_exclusive_offers', $siteLangId);?></p>
					</div>
					<?php $this->includeTemplate( '_partial/footerNewsLetterForm.php'); } ?>
					<ul class="contact-info">
						<?php $site_conatct = FatApp::getConfig('CONF_SITE_PHONE',FatUtility::VAR_STRING,'');
						if( $site_conatct ){ ?>
							<li><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/icn-mobile.png"></i><?php echo $site_conatct;?></li>
						<?php } ?>
						<?php $email_id = FatApp::getConfig('CONF_CONTACT_EMAIL',FatUtility::VAR_STRING,'');
						if( $email_id ){ ?>
							<li><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/icn-email.png"></i> <a href="mailto:<?php echo $email_id; ?>"><?php echo $email_id;?></a> </li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="middle-footer">
			<div class="accordion-footer">
				<?php $this->includeTemplate( '_partial/footerTopBrands.php'); ?>
				<?php $this->includeTemplate( '_partial/footerTopCategories.php'); ?>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="row align-items-center">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<?php $this->includeTemplate( '_partial/footerSocialMedia.php'); ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="copyright">
						<?php echo sprintf(Labels::getLabel('LBL_copyright_text', $siteLangId),date("Y"))?>
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

<?php if(FatApp::getConfig('CONF_ENABLE_COOKIES', FatUtility::VAR_INT, 1) && !CommonHelper::getUserCookiesEnabled()){ ?>
<div class="cc-window cc-banner cc-type-info cc-theme-block cc-bottom cookie-alert no-print">
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
<div class="no-print" >
<?php if(CommonHelper::demoUrl()){ ?>
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

window.onbeforeprint = function () {
	Tawk_API.hideWidget();
};
window.onafterprint = function () {
	Tawk_API.showWidget();
};
</script>
<!--End of Tawk.to Script-->
<?php
$this->includeTemplate( 'restore-system/page-content.php');
}?>
</div>
</div>
</body>
</html>
<?php
//$content  = ob_get_clean();
//echo CommonHelper::minifyHtml($content);
?>
