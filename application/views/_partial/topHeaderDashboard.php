<div class="wrapper">
	<header id="header-dashboard" class="header-dashboard" role="header-dashboard">
		<div class="header-icons-group">
			<div class="c-header-icon messages">
				<a href="#">
					<i class="icn"><svg class="svg">
							<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message"></use>
						</svg>
					</i>
					<span class="h-badge"><span class="heartbit"></span>5</span></a>
			</div>
			<div class="my-account dropdown">
				<a href="#" class="dropdown__trigger dropdown__trigger-js">
					<img class="my-account__avatar" src="images/avater.jpg" alt="">
				</a>
				<div class="dropdown__target dropdown__target__right dropdown__target-js">
					<div class="dropdown__target-space">
						<ul class="list-vertical list-vertical--tick">
							<li><a href="#">Dashboard</a></li>
							<li><a href="/#">My Orders</a></li>
							<li><a href="#">My Account</a></li>
							<li><a href="#">My Messages</a></li>
							<li><a href="#">My Credits</a></li>
							<li class="seprator"><a href="#">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>








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
