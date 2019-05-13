<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="wrapper">
	<header id="header-checkout" class="header-checkout" role="header-checkout">
	<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-xs-6 d-none d-xl-block d-lg-block hide--mobile">
					<div class="slogan">Instant Multi Vendor Ecommerce System Builder</div>
				</div>
				<div class="col-lg-8 col-xs-12">
				</div>
			</div>
		</div>
	</div>
		<div class="container">
			<div class="header-checkout-inner">
				<div class="logo"><a href="<?php echo CommonHelper::generateUrl(); ?>" class=""><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
				
				<div class="checkout-flow">
				<ul>
					<li class="completed" data-count="1"><i class="count">1</i><span>Billing</span></li>
					<li class="inprogress" data-count="2"><i class="count">2</i><span>Shiping</span></li>
					<li class="pending" data-count="3"><i class="count">3</i><span>Payment</span></li>
					<li class="pending" data-count="4"><i class="count">4</i><span>Order completed</span></li>
				</ul>
			</div>
			
				<?php if($controllerName == 'Checkout' || $controllerName == 'subscriptioncheckout' ) { ?>
                <div class="nav-checkout">
					<ul>
                        <?php if($controllerName == 'Checkout') { ?>
						<li><a href="#login-register"><?php echo Labels::getLabel('LBL_Login', $siteLangId); ?></a></li>
						<li><a href="#address"><?php echo Labels::getLabel('LBL_Billing/Shipping_Address', $siteLangId); ?></a></li>
						<li><a href="#shipping-summary"><?php echo Labels::getLabel('LBL_Shipping_Summary', $siteLangId); ?></a></li>
                        <?php } ?>
						<li><a href="#cart-review"><?php echo Labels::getLabel('LBL_Review_Order', $siteLangId); ?></a></li>
						<li><a href="#payment"><?php echo Labels::getLabel('LBL_Make_Payment', $siteLangId); ?></a></li>
					</ul>
				</div>
                <?php } ?>
				<a href="<?php echo CommonHelper::generateUrl('Home'); ?>" class="btn btn--primary-border btn--sm back-store"><?php echo Labels::getLabel('LBL_Back_To_The_Store', $siteLangId); ?></a>
			</div>
		</div>
	</header>
	<div class="after-checkout-header"></div>


        <?php /* echo FatUtility::decodeHtmlEntities( $headerData['epage_content'] ); */ ?>
      