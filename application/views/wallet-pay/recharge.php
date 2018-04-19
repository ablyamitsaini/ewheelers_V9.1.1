<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<section class="section">
  <div class="section-head"><?php echo Labels::getLabel("LBL_Add_Money_to_wallet", $siteLangId); ?></div>
 
 
 <div class="fixed-container"> <div class="make-payment-wrapper">
    <?php if( $orderInfo['order_net_amount'] ){ ?>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-xm-12">
        <?php if( $paymentMethods ){ ?>
        <div class="payment_methods_list">
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
      <div class="col-lg-8 col-md-8 col-sm-12 col-xm-12">
        <div class="payment-here">
          <div class="you-pay"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?> : <strong><?php echo CommonHelper::displayMoneyFormat($orderInfo['order_net_amount']); ?>
            <?php if( CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) ){?>
            <li>
              <p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderInfo['order_net_amount']);  ?></p>
            </li>
            <?php } ?>
            </strong> </div>
          <div class="gap"></div>
          <!--<div class="heading4"><?php //echo Labels::getLabel('LBL_Pay_With_Credit_Card', $siteLangId); ?></div>-->
          <div id="tabs-container"></div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div> </div>
</section>
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
