<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
foreach ($paymentMethods as $key => $val) {
    $paymentMethods[$key]['image'] = CommonHelper::generateFullUrl('Image', 'paymentMethod', array($val['pmethod_id'],'SMALL'));
}
$rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId());
$canBeUse = min(min($rewardPoints, CommonHelper::convertCurrencyToRewardPoint($cartSummary['cartTotal']-$cartSummary["cartDiscounts"]["coupon_discount_total"])), FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0));
$canBeUseRPAmt = CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($canBeUse));

$data = array(
    'orderId' => $orderId,
    'orderType' => $orderType,
    'paymentMethods' => $paymentMethods,
    'userWalletBalance' => $userWalletBalance,
    'rewardPoints' => $rewardPoints,
    'canBeUseRP' => trim($canBeUse),
    'canBeUseRPAmt' => trim($canBeUseRPAmt),
    'remainingWalletBalance' => CommonHelper::displayMoneyFormat($userWalletBalance),
    'orderNetAmount' => $cartSummary['orderNetAmount'],
);

$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$shippingTotal = isset($cartSummary['shippingTotal']) ? $cartSummary['shippingTotal'] : 0;
$cartTaxTotal = isset($cartSummary['cartTaxTotal']) ? $cartSummary['cartTaxTotal'] : 0;
$cartVolumeDiscount = isset($cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0;
$coupon_discount_total = isset($cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0;
$appliedRewardPointsDiscount = isset($cartSummary['cartRewardPoints']) ? $cartSummary['cartRewardPoints'] : 0;

$data['priceDetail'] = array(
    array(
        'key' => Labels::getLabel('LBL_Items', $siteLangId),
        'value' => count($products)
    ),
    array(
        'key' => Labels::getLabel('LBL_Total', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartTotal)
    )
);

if (0 < $cartTaxTotal) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Tax', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartTaxTotal)
    );
}
if (0 < $appliedRewardPointsDiscount) {
    $usedRPAmt = CommonHelper::convertRewardPointToCurrency($appliedRewardPointsDiscount);
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Reward_point_discount', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($usedRPAmt)
    );
}
if (0 < $cartVolumeDiscount) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Volume_Discount', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartVolumeDiscount)
    );
}
if (0 < $coupon_discount_total) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Discount', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($coupon_discount_total)
    );
}
if (0 < $shippingTotal) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Shipping_Charges', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($shippingTotal)
    );
}

$data['netPayable'] = array(
    'key' => Labels::getLabel('LBL_Net_Payable', $siteLangId),
    'value' => CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'])
);

if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $cartSummary["cartWalletSelected"]) {
    $remainingWalletBalance = ($userWalletBalance - $cartSummary['orderNetAmount']);
    $remainingWalletBalance = ($remainingWalletBalance < 0) ? 0 : $remainingWalletBalance;
    $data['remainingWalletBalance'] = CommonHelper::displayMoneyFormat($remainingWalletBalance);
}
