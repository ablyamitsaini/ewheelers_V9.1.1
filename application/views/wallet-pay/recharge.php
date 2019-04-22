<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php $gatewayCount=0; foreach( $paymentMethods as $key => $val ){
	if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_ADD_MONEY_TO_WALLET])) continue;
	$gatewayCount++;
}
?>
<div id="body" class="body" role="main">
 <section class="">
    <div class="container">
		<div class="row">
            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 checkout--steps">
                <div class="checkout--steps__inner">
                    <section class="section is-current">
                      <h3><?php echo Labels::getLabel("LBL_Add_Money_to_wallet", $siteLangId); ?></h3>
                      <div class="make-payment-wrapper">
                        <?php if( $orderInfo['order_net_amount'] ){ ?>
                        <div class="row">
                        <?php if( $gatewayCount > 0 ){ ?>
                          <div class="col-lg-5 col-md-5 col-sm-12 col-xm-12 column">
                            <?php if( $paymentMethods ){ ?>
                            <div class="payment_methods_list" data-simplebar>
                              <ul id="payment_methods_tab">
                                <?php $count=0; foreach( $paymentMethods as $key => $val ){
                                    if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_ADD_MONEY_TO_WALLET])) continue;
                                    $count++;
                                ?>
                                <li class="<?php echo ($count == 1) ? 'is-active' : ''; ?>"><a class="<?php echo ($count == 1) ? 'is-active' : ''; ?>" href="<?php echo CommonHelper::generateUrl('WalletPay', 'PaymentTab', array($orderInfo['order_id'], $val['pmethod_id']) ); ?>"><?php echo $val['pmethod_name']; ?></a></li>
                                <?php } ?>
                              </ul>
                            </div>
                            <?php } ?>
                          </div>
                          <div class="col-lg-7 col-md-7 col-sm-12 col-xm-12">
                            <div class="payment-here">
                              <div class="you-pay">
																<?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?> : <strong><?php echo CommonHelper::displayMoneyFormat($orderInfo['order_net_amount']); ?>
                                <?php if( CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) ){?>

                                  <p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderInfo['order_net_amount']);  ?></p>

                                <?php } ?>
                                </strong> </div>
                              <div class="gap"></div>
                              <!--<div class="heading4"><?php //echo Labels::getLabel('LBL_Pay_With_Credit_Card', $siteLangId); ?></div>-->
                              <div id="tabs-container"></div>
                            </div>
                          </div>
                          <?php }else{

                              echo Labels::getLabel("LBL_Payment_method_is_not_available._Please_contact_your_administrator.", $siteLangId);
                          } ?>
                        </div>
                        <?php } ?>
                      </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
 </section>
</div>
<script>
if($(window).width()>1050){
	$('.scrollbar-js').enscroll({
		verticalTrackClass: 'scroll__track',
		verticalHandleClass: 'scroll__handle'
	});
}
</script>
<?php if( $orderInfo['order_net_amount'] ){ ?>
<script type="text/javascript">
var containerId = '#tabs-container';
var tabsId = '#payment_methods_tab';
$(document).ready(function(){
	if( $(tabsId + ' li a.is-active').length > 0 ){
		loadTab( $(tabsId + ' li A.is-active') );
	}
	$( tabsId + ' a' ).click(function(){
	if( $(this).hasClass('is-active')){ return false; }
		$(tabsId + ' li A.is-active').removeClass('is-active');
		$('li').removeClass('is-active');
		$(this).parent().addClass('is-active');
		loadTab($(this));
		return false;
	});
});

function loadTab( tabObj ){
	if(!tabObj || !tabObj.length){ return; }
	$(containerId).html( fcom.getLoader() );
	//$(containerId).fadeOut('fast');
	fcom.ajax(tabObj.attr('href'),'',function(response){
		$(containerId).html(response);
	});
	/* $(containerId).load( tabObj.attr('href'), function(){
		//$(containerId).fadeIn('fast');
	}); */
}
</script>
<?php } ?>
