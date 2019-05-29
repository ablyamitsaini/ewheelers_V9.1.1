<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="section-head">
    <div class="section__heading">
        <h2><?php echo Labels::getLabel('LBL_Payment_Summary', $siteLangId); ?></h2>
    </div>
</div>
<?php $rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId()); ?>
<div class="box box--white box--radius p-4">
    <section id="payment" class="section-checkout">
        <?php if ($rewardPoints > 0) { ?>
            <div class="section-head">
                <div class="section__heading">
                    <h6>
                        <?php echo Labels::getLabel('LBL_Reward_Point_in_your_account', $siteLangId); ?>
                        <strong>
                            <?php echo $rewardPoints; ?>
                        </strong>
                        (<?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency(UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId()))); ?>)
                        <?php echo Labels::getLabel('LBL_You_can_use_upto_', $siteLangId); ?>
                        <strong><?php echo min(min($rewardPoints, CommonHelper::convertCurrencyToRewardPoint($cartSummary['cartTotal']-$cartSummary["cartDiscounts"]["coupon_discount_total"])), FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0)); ?></strong>
                    </h6>
                </div>
            </div>
            <div class="align-items-center mb-4">
                <div class="">
                    <?php
                        $redeemRewardFrm->setFormTagAttribute('class', 'form form--secondary form--singlefield');
                        $redeemRewardFrm->setFormTagAttribute('onsubmit', 'useRewardPoints(this); return false;');
                        $redeemRewardFrm->setJsErrorDisplay('afterfield');
                        echo $redeemRewardFrm->getFormTag();
                        echo $redeemRewardFrm->getFieldHtml('redeem_rewards');
                        echo $redeemRewardFrm->getFieldHtml('btn_submit');
                        echo $redeemRewardFrm->getExternalJs(); ?>
                        </form>
                        <div class="gap"></div>
                    <?php if (!empty($cartSummary['cartRewardPoints'])) { ?>
                        <div class="alert alert--success relative">
                            <a href="javascript:void(0)" class="close" onClick="removeRewardPoints()"></a>
                            <p><?php echo Labels::getLabel('LBL_Reward_Points', $siteLangId); ?> <strong><?php echo $cartSummary['cartRewardPoints']; ?></strong> <?php echo Labels::getLabel('LBL_Successfully_Used', $siteLangId); ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="align-items-center mb-4">
            <?php if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0) { ?>
                <div>
                    <div id="wallet" class="wallet">
                        <label class="checkbox brand" id="brand_95">
                            <input onChange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" />
                            <i class="input-helper"></i>
                            <?php if ($cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount']) {
                                echo '<strong>'.Labels::getLabel('LBL_Sufficient_balance_in_your_wallet', $siteLangId).'</strong>'; //';
                            } else {
                                echo '<strong>'.Labels::getLabel('MSG_Use_My_Wallet_Credits', $siteLangId)?>: (<?php echo CommonHelper::displayMoneyFormat($userWalletBalance)?>)</strong>
                            <?php } ?>
                        </label>
                        <?php if ($cartSummary["cartWalletSelected"]) { ?>
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
                                        <p>
                                            <i>
                                                <?php echo Labels::getLabel('LBL_Remaining_wallet_balance', $siteLangId);
                                                $remainingWalletBalance = ($userWalletBalance - $cartSummary['orderNetAmount']);
                                                $remainingWalletBalance = ($remainingWalletBalance < 0) ? 0 : $remainingWalletBalance;
                                                echo CommonHelper::displayMoneyFormat($remainingWalletBalance); ?>
                                            </i>
                                        </p>
                                    </li>
                                    <?php /* if( $userWalletBalance < $cartSummary['orderNetAmount'] ){ ?> <li>
                                        <div class="boxwhite">
                                            <p>Select an Option to pay balance</p>
                                            <h5><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderPaymentGatewayCharges']); ?></h5>
                                        </div>
                                    </li> <?php } */ ?>
                                    <?php if ($userWalletBalance >= $cartSummary['orderNetAmount']) { ?>
                                        <li>
                                            <?php $btnSubmitFld = $WalletPaymentForm->getField('btn_submit');
                                            $btnSubmitFld->addFieldTagAttribute('class', 'btn btn--primary-border');

                                            $WalletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                                            $WalletPaymentForm->developerTags['fld_default_col'] = 12;
                                            echo $WalletPaymentForm->getFormHtml(); ?>
                                        </li>
                                        <script type="text/javascript">
                                            function confirmOrder(frm) {
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
                </div>
            <?php } ?>
            <?php if ($cartSummary['orderNetAmount'] <= 0) { ?>
                <div class="gap"></div>
                <div id="wallet">
                    <h6><?php echo Labels::getLabel('LBL_Payment_to_be_made', $siteLangId); ?> <strong><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></strong></h6> <?php
                    $btnSubmitFld = $confirmForm->getField('btn_submit');
                    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');

                    $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
                    $confirmForm->developerTags['fld_default_col'] = 12;
                    echo $confirmForm->getFormHtml(); ?> <div class="gap"></div>
                </div>
            <?php } ?>
        </div>
        <?php
        $gatewayCount=0;
        foreach ($paymentMethods as $key => $val) {
            if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                continue;
            }
            $gatewayCount++;
        }
        if ($cartSummary['orderPaymentGatewayCharges']) { ?>
            <div class="payment_methods_list mb-4" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                <?php if ($cartSummary['orderPaymentGatewayCharges'] && 0 < $gatewayCount && 0 < count($paymentMethods)) { ?>
                        <ul id="payment_methods_tab" class="simplebar-horizontal" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: -15px;">
                                        <div class="simplebar-content" style="height: auto; overflow: scroll hidden;">
                                            <div class="simplebar-resize-wrapper" style="padding: 0px;">
                                            <?php $count=0;
                                            foreach ($paymentMethods as $key => $val) {
                                                if (in_array($val['pmethod_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                                    continue;
                                                }
                                                $count++; ?>
                                                <li>
                                                    <a href="<?php echo CommonHelper::generateUrl('Checkout', 'PaymentTab', array($orderInfo['order_id'], $val['pmethod_id'])); ?>">
                                                        <div class="payment-box">
                                                            <i class="payment-icn">
                                                                <img src="<?php echo CommonHelper::generateUrl('Image', 'paymentMethod', array($val['pmethod_id'],'SMALL')); ?>" alt="">
                                                            </i>
                                                            <span><?php echo $val['pmethod_name']; ?></span>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: auto; height: 90px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: visible;">
                                <div class="simplebar-scrollbar" style="width: 381px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="height: 90px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                            </div>
                        </ul>
                <?php } ?>
            </div>
            <div class="payment-from">
                <div class="you-pay">
                    <?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?> :
                    <strong>
                        <?php echo CommonHelper::displayMoneyFormat($cartSummary['orderPaymentGatewayCharges']); ?>
                        <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                            <li>
                                <p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderPaymentGatewayCharges']); ?></p>
                            </li>
                        <?php } ?>
                    </strong>
                </div>
                <div class="gap"></div>
                <div id="tabs-container"></div>
        <?php } else {
            echo Labels::getLabel("LBL_Payment_method_is_not_available._Please_contact_your_administrator.", $siteLangId);
        } ?>
    </section>
</div>
<?php if ($cartSummary['orderPaymentGatewayCharges']) { ?>
    <script type="text/javascript">
        var containerId = '#tabs-container';
        var tabsId = '#payment_methods_tab';
        $(document).ready(function() {
            if ($(tabsId + ' LI A.is-active').length > 0) {
                loadTab($(tabsId + ' LI A.is-active'));
            }
            $(tabsId + ' A').click(function() {
                if ($(this).hasClass('is-active')) {
                    return false;
                }
                $(tabsId + ' LI A.is-active').removeClass('is-active');
                $('li').removeClass('is-active');
                $(this).parent().addClass('is-active');
                loadTab($(this));
                return false;
            });
        });

        function loadTab(tabObj) {
            if (!tabObj || !tabObj.length) {
                return;
            }
            $(containerId).html(fcom.getLoader());
            fcom.ajax(tabObj.attr('href'), '', function(response) {
                $(containerId).html(response);
            });
        }
    </script>
<?php } ?>
