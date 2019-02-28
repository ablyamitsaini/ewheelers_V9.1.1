<div class="wrapper">
<div id="loader-wrapper">
	<div class="pong-loader"></div>
	<div class="loader-section section-left"></div>
	<div class="loader-section section-right"></div>
</div>
<!--header start here-->
<header id="header" class="header no-print" role="site-header">
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-xs-6 d-none d-xl-block d-lg-block hide--mobile">
          <div class="slogan"><?php echo Labels::getLabel('L_Instant_Multi_Vendor_eCommerce_System_Builder',$siteLangId); ?></div>
        </div>
        <div class="col-lg-8 col-xs-12">
          <div class="short-links">
            <ul>
              <?php $this->includeTemplate('_partial/headerTopNavigation.php'); ?>
              <?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
			  <?php $this->includeTemplate('_partial/headerUserArea.php'); ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-bar">
    <div class="container">
	  <div class="logo-bar">
		<?php
		if( CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'] ) ){
			$logoUrl = CommonHelper::generateUrl('home','index');
		}else{
			$logoUrl = CommonHelper::generateUrl();
		}
		?>
		<div class="logo zoomIn">
			<a href="<?php echo $logoUrl; ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a>
		</div>
		<?php $this->includeTemplate('_partial/headerSearchFormArea.php'); ?>
		<div class="cart dropdown" id="cartSummary">
			<?php $this->includeTemplate('_partial/headerWishListAndCartSummary.php'); ?>
		</div>
	  </div>
    </div>
  </div>
  <?php $this->includeTemplate('_partial/headerNavigation.php'); ?>
</header>
<div class="after-header no-print"></div>
<div class="display-in-print">
	<img src="<?php echo CommonHelper::generateFullUrl('Image','invoiceLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>">
</div>
<!--header end here-->
<!--body start here-->
