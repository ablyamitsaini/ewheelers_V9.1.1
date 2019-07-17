<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
if (1 > $opId) {
    $childOrderDetail = array_values($childOrderDetail);
}
$orderDetail['charges'] = !empty($orderDetail['charges']) ? $orderDetail['charges'] : (object)array();
$orderDetail['billingAddress'] = !empty($orderDetail['billingAddress']) ? $orderDetail['billingAddress'] : (object)array();
$orderDetail['shippingAddress'] = !empty($orderDetail['shippingAddress']) ? $orderDetail['shippingAddress'] : (object)array();

if (!empty($orderDetail['charges'])) {
    $charges = array();
    $i = 0;
    foreach ($orderDetail['charges'] as $key => $value) {
        $charges[$key] = array_values($value);
        $i++;
    }
    $orderDetail['charges'] = $charges;
}
// echo $primaryOrder; die;
if ($primaryOrder) {
    $childArr[] = $childOrderDetail;
} else {
    $childArr = $childOrderDetail;
}
$cartTotal = 0;
$shippingCharges = 0;
foreach ($childArr as $index => $childOrder) {
    $childArr[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($childOrder['selprod_product_id'], "THUMB", $childOrder['op_selprod_id'], 0, $siteLangId));

    $cartTotal = $cartTotal + CommonHelper::orderProductAmount($childOrder, 'cart_total');
    $shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($childOrder, 'shipping');
    $volumeDiscount = CommonHelper::orderProductAmount($childOrder, 'VOLUME_DISCOUNT');
    $rewardPointDiscount = CommonHelper::orderProductAmount($childOrder, 'REWARDPOINT');
    $childArr[$index]['priceDetail'] = array(
        array(
            'key' => Labels::getLabel('LBL_Price', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($childOrder['op_unit_price']),
        ),
        array(
            'key' => Labels::getLabel('LBL_Shipping_Charges', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder, 'shipping')),
        ),
        array(
            'key' => Labels::getLabel('LBL_Volume/Loyalty_Discount', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($volumeDiscount),
        ),
        array(
            'key' => Labels::getLabel('LBL_Tax_Charges', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder, 'tax')),
        ),
        array(
            'key' => Labels::getLabel('LBL_Reward_Point_Discount', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($rewardPointDiscount),
        )
    );
    $childArr[$index]['totalAmount'] = array(
        'key' => Labels::getLabel('LBL_Total', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder)),
    );
}

$data = array(
    'orderDetail' => $orderDetail,
    'childOrderDetail' => $childArr,
    'orderStatuses' => !empty($orderStatuses) ? $orderStatuses : (object)array()    ,
    'primaryOrder' => $primaryOrder,
    'digitalDownloads' => !empty($digitalDownloads) ? $digitalDownloads : (object)array(),
    'digitalDownloadLinks' => !empty($digitalDownloadLinks) ? $digitalDownloadLinks : (object)array(),
    'languages' => !empty($languages) ? $languages : (object)array(),
    'yesNoArr' => $yesNoArr,
);
if (1 > count((array)$orderDetail)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
