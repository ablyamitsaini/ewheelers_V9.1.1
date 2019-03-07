<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body body--checkout" role="main">
<section class="">
	<div class="container">
		<div class="row ">
			<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 checkout--steps">
				<div class="checkout--steps__inner">
					<?php if (!UserAuthentication::isUserLogged() && !UserAuthentication::isGuestUserLogged()) { ?>
					<div id="login-register" class="step is-current">
						<div class="check-login-wrapper step__body" style="display:none;"></div>
					</div>
					<?php }else {?>
						<section class="section-checkout is-completed" id="login-register">
							<div class="selected-panel">
								<div class="selected-panel-type"><?php echo Labels::getLabel('LBL_Login', $siteLangId); ?></div>
								<div class="selected-panel-data"><?php echo UserAuthentication::getLoggedUserAttribute('user_email'); ?></div>
								<div class="selected-panel-action">
								<a href="<?php echo CommonHelper::generateUrl('GuestUser', 'logout');?>" class="btn btn--primary btn--sm ripplelink"><?php echo Labels::getLabel('LBL_Change_User', $siteLangId); ?></a></a></div>
							</div>
						</section>
					<?php }?>
				<section class="section-checkout" id="address">
				  <h2><?php echo Labels::getLabel('LBL_Billing/Shipping_Address',$siteLangId); ?></h2>
				</section>
				<section class="section-checkout" id="shipping-summary" <?php if( !$cartHasPhysicalProduct ){ ?>style="display:none" <?php }?>>
				  <h2><?php echo Labels::getLabel('LBL_Shipping_Summary',$siteLangId); ?></h2>
				</section>
				<section class="section-checkout" id="cart-review">
				  <h2><?php echo Labels::getLabel('LBL_Review_Order',$siteLangId); ?></h2>
				</section>
				<section class="section-checkout" id="payment" >
				  <h2><?php echo Labels::getLabel('LBL_Make_Payment', $siteLangId); ?> </h2>
				</section>
		  </div>
      </div>
	  <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
        <div class="order-summary">
          <div class="coupon">
            <div class="summary-listing"></div>
            <?php echo FatUtility::decodeHtmlEntities( $pageData['epage_content'] );?> </div>
        </div>
      </div>
    </div>
  </div>
  </section>
</div>
<script type="text/javascript">
	<?php if( isset($defaultAddress) ) { ?>
		$defaultAddress = 1;
	<?php } else { ?>
		$defaultAddress = 0;
	<?php } ?>
</script>
<script type="text/javascript">
$("document").ready(function(){
	$(document).on("click",".toggle--collapseable-js",function(e){
		var prodgroup_id = $(this).attr('data-prodgroup_id');
		$(this).toggleClass("is--active");
		$("#prodgroup_id_" + prodgroup_id ).slideToggle();
	});
});
</script>
