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
);
