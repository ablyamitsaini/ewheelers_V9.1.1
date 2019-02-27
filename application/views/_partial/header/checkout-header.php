<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="wrapper">
	<header id="header-checkout" class="header-checkout" role="header-checkout">
		<div class="container container-fluid">
			<div class="header-checkout-inner">
				<div class="logo-checkout"><a href="<?php echo CommonHelper::generateUrl(); ?>" class=""><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
				<div class="nav-checkout">
					<ul>
						<li><a href="#login-register"><?php echo Labels::getLabel('LBL_Login', $siteLangId); ?></a></li>
						<li><a href="#address"><?php echo Labels::getLabel('LBL_Billing/Shipping_Address', $siteLangId); ?></a></li>
						<li><a href="#shipping-summary"><?php echo Labels::getLabel('LBL_Shipping_Summary', $siteLangId); ?></a></li>
						<li><a href="#cart-review"><?php echo Labels::getLabel('LBL_Review_Order', $siteLangId); ?></a></li>
						<li><a href="#payment"><?php echo Labels::getLabel('LBL_Make_Payment', $siteLangId); ?></a></li>
					</ul>
				</div>
				<a href="<?php echo CommonHelper::generateUrl('Home'); ?>" class="btn btn--primary-border btn--sm back-store"><?php echo Labels::getLabel('LBL_Back_To_The_Store', $siteLangId); ?></a>
			</div>
		</div>
	</header>
	<div class="after-checkout-header"></div>


        <?php /* echo FatUtility::decodeHtmlEntities( $headerData['epage_content'] ); */ ?>
      