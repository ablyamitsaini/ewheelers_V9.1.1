<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body checkout-page">
  <div class="fixed-container">
    <div class="row ">
      <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
        <section class="section">
          <?php if (!UserAuthentication::isUserLogged()) { ?>
          <div id="login-register" class="step is-current">
            <div class="section-head step__head">1. <?php echo Labels::getLabel('LBL_Login', $siteLangId); ?> </div>
            <div class="check-login-wrapper step__body" style="display:none;"></div>
          </div>
          <?php } else { ?>
          <div class="selected-panel " id="alreadyLoginDiv">
            <div class="selected-panel-type">1. <?php echo Labels::getLabel('LBL_Login', $siteLangId); ?></div>
            <div class="selected-panel-data"><?php echo UserAuthentication::getLoggedUserAttribute('user_email'); ?></div>
            <!--<div class="selected-panel-action"><a onClick="showLoginDiv();" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_Change_Login', $siteLangId); ?></a></div>-->
          </div>
          <?php } ?>
        </section>
        <section class="section" id="address">
          <div class="section-head ">2. <?php echo Labels::getLabel('LBL_Billing/Shipping_Address',$siteLangId); ?></div>
        </section>
        <section class="section" id="shipping-summary" <?php if( !$cartHasPhysicalProduct ){ ?>style="display:none" <?php }?>>
          <div class="section-head ">3. <?php echo Labels::getLabel('LBL_Shipping_Summary',$siteLangId); ?></div>
        </section>
        <section class="section" id="cart-review">
          <div class="section-head ">
            <?php if( $cartHasPhysicalProduct ){ ?>
            4.
            <?php } else { echo '3.'; } ?>
            <?php echo Labels::getLabel('LBL_Review_Order',$siteLangId); ?></div>
        </section>
        <section class="section" id="payment" >
          <div class="section-head">
            <?php if( $cartHasPhysicalProduct ){ ?>
            5.
            <?php } else { echo '4.'; } ?>
            <?php echo Labels::getLabel('LBL_Make_Payment', $siteLangId); ?> </div>
        </section>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
        <div class="order-summary">
          <div class="coupon">
            <div class="summary-listing"></div>
            <?php echo FatUtility::decodeHtmlEntities( $pageData['epage_content'] );?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="gap"></div>
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
