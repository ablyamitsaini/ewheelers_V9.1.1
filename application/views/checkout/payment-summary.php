<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<h2><?php echo Labels::getLabel('LBL_Payment_Summary',$siteLangId); ?></h2>
<?php $rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId());
	  if($rewardPoints > 0){ ?>
 <div class="make-payment-wrapper step__body">
	
	<h6><?php echo Labels::getLabel('LBL_Reward_Point_in_your_account', $siteLangId); ?>
    <strong><?php echo $rewardPoints; ?></strong>
    (<?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency(UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId())));?>) <?php echo Labels::getLabel('LBL_You_can_use_upto_', $siteLangId); ?> <strong><?php echo min(min($rewardPoints,CommonHelper::convertCurrencyToRewardPoint($cartSummary['cartTotal']-$cartSummary["cartDiscounts"]["coupon_discount_total"])),FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0)); ?></strong></h6>
	<?php
		$redeemRewardFrm->setFormTagAttribute('class','form form--secondary form--singlefield');
		$redeemRewardFrm->setFormTagAttribute('onsubmit','useRewardPoints(this); return false;');
		$redeemRewardFrm->setJsErrorDisplay('afterfield');
		echo $redeemRewardFrm->getFormTag();
		echo $redeemRewardFrm->getFieldHtml('redeem_rewards');
		echo $redeemRewardFrm->getFieldHtml('btn_submit');
		echo $redeemRewardFrm->getExternalJs();
		?>
	</form>
    <div class="gap"></div>
		<?php if(!empty($cartSummary['cartRewardPoints'])){?>
		<div class="alert alert--success relative">
		<a href="javascript:void(0)" class="close" onClick="removeRewardPoints()"></a>
		<p><?php echo Labels::getLabel('LBL_Reward_Points',$siteLangId);?> <strong><?php echo $cartSummary['cartRewardPoints'];?></strong> <?php echo Labels::getLabel('LBL_Successfully_Used',$siteLangId);?></p>
		</div>
	<?php }?>
	
<?php } /* CommonHelper::printArray($cartSummary); die; */ ?>

    <?php if( $userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0){ ?>
    <div id="wallet">
        <label class="checkbox brand" id="brand_95"><input onChange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" /><i class="input-helper"></i><?php if( $cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount'] ){
                echo '<strong>'.Labels::getLabel('LBL_Sufficient_balance_in_your_wallet', $siteLangId).'</strong>'; //';
            } else {
                echo Labels::getLabel('MSG_Use_My_Wallet_Credits', $siteLangId)?>:  (<?php echo CommonHelper::displayMoneyFormat($userWalletBalance)?>)
            <?php } ?> </label>

        <?php if( $cartSummary["cartWalletSelected"] ){ ?>
        <div class="listing--grids">
            <ul>
                <li>
                    <div class="boxwhite">
                        <p><?php echo Labels::getLabel('LBL_Payment_to_be_made', $siteLangId); ?></p>
                        <h5><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></h5>
                    </div>
                </li>
                <li>
                    <div class="boxwhite">
                    <p><?php echo Labels::getLabel('LBL_Amount_in_your_wallet', $siteLangId); ?></p>
                    <h5><?php echo CommonHelper::displayMoneyFormat($userWalletBalance); ?></h5>
                    </div>
                    <p><i><?php echo Labels::getLabel('LBL_Remaining_wallet_balance', $siteLangId);
                    $remainingWalletBalance = ($userWalletBalance - $cartSummary['orderNetAmount']);
                    $remainingWalletBalance = ( $remainingWalletBalance < 0 ) ? 0 : $remainingWalletBalance;
                    echo CommonHelper::displayMoneyFormat($remainingWalletBalance); ?></i></p>
                </li>
                <?php /* if( $userWalletBalance < $cartSummary['orderNetAmount'] ){ ?>
                <li>
                    <div class="boxwhite">
                        <p>Select an Option to pay balance</p>
                        <h5><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderPaymentGatewayCharges']); ?></h5>
                    </div>
                </li>
                <?php } */ ?>
                <?php if($userWalletBalance >= $cartSummary['orderNetAmount']){ ?>
                <li>
                    <?php
                    $btnSubmitFld = $WalletPaymentForm->getField('btn_submit');
                    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');

                    $WalletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                    $WalletPaymentForm->developerTags['fld_default_col'] = 12;
                    echo $WalletPaymentForm->getFormHtml(); ?>
                </li>
                <script type="text/javascript">
                    function confirmOrder(frm){
                        var data = fcom.frmData(frm);
                        var action = $(frm).attr('action');
                        fcom.updateWithAjax(fcom.makeUrl('Checkout', 'ConfirmOrder'), data, function(ans) {
                            $(location).attr("href", action);
                        });
                    }
                </script>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
    <?php } ?>


    <?php if($cartSummary['orderNetAmount'] <= 0) { ?>
    <div class="gap"></div>
    <div id="wallet">
        <h6><?php echo Labels::getLabel('LBL_Payment_to_be_made', $siteLangId); ?>
        <strong><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></strong></h6>
        <?php
        $btnSubmitFld = $confirmForm->getField('btn_submit');
        $btnSubmitFld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');

        $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
        $confirmForm->developerTags['fld_default_col'] = 12;
        echo $confirmForm->getFormHtml(); ?>
        <div class="gap"></div>
    </div>
    <?php }?>

    <?php $gatewayCount=0; foreach( $paymentMethods as $key => $val ){
        if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) continue;
        $gatewayCount++;
    } ?>
    <div class="gap"></div>
    <div class="make-payment-wrapper <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>">
      <?php if($cartSummary['orderPaymentGatewayCharges']){ ?>
      <div class="row">
        <?php if( $gatewayCount > 0 ){ ?>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xm-12 column">
          <?php if($paymentMethods){ ?>
          <div class="payment_methods_list scrollbar">
            <ul id="payment_methods_tab">
                <?php $count=0; foreach($paymentMethods as $key => $val ){
                    if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) continue;
                    $count++;
                ?>
                <li class="<?php echo ($count == 1) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Checkout', 'PaymentTab', array($orderInfo['order_id'], $val['pmethod_id']) ); ?>"><?php echo $val['pmethod_name']; ?></a></li>
                <?php } ?>
            </ul>
          </div>
          <?php } ?>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xm-12">
          <div class="payment-here">
            <div class="you-pay"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?>  : <strong><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderPaymentGatewayCharges']); ?>
            <?php if( CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) ){?>
            <li><p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderPaymentGatewayCharges']);  ?></p></li>
            <?php } ?></strong></div>
            <div class="gap"></div>

            <div id="tabs-container"></div>
          </div>
        </div>
        <?php }else{
              echo Labels::getLabel("LBL_Payment_method_is_not_available._Please_contact_your_administrator.", $siteLangId);
          } ?>
      </div>
      <?php } ?>
    </div>
</div>
<script>
if($(window).width()>1050){
	$('.scrollbar').enscroll({
		verticalTrackClass: 'scroll__track',
		verticalHandleClass: 'scroll__handle'
	});
}
</script>
<?php if($cartSummary['orderPaymentGatewayCharges']){ ?>
<script type="text/javascript">
var containerId = '#tabs-container';
var tabsId = '#payment_methods_tab';
$(document).ready(function(){
     if($(tabsId + ' LI A.is-active').length > 0){
         loadTab( $(tabsId + ' LI A.is-active') );
     }
     $(tabsId + ' A').click(function(){
          if( $(this).hasClass('is-active')){ return false; }
          $(tabsId + ' LI A.is-active').removeClass('is-active');
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
