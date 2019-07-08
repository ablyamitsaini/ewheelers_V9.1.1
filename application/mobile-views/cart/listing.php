<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($products as $key => $product) {
    $products[$key]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
}

$data = array(
    'products' => array_values($products),
    'cartSummary' => $cartSummary,
    'cartSelectedBillingAddress' => empty($cartSelectedBillingAddress) ? (object)array() : $cartSelectedBillingAddress,
    'cartSelectedShippingAddress' => empty($cartSelectedShippingAddress) ? (object)array() : $cartSelectedShippingAddress,
    'hasPhysicalProduct' => $hasPhysicalProduct,
    'isShippingSameAsBilling' => $isShippingSameAsBilling,
    'selectedBillingAddressId' => $selectedBillingAddressId,
    'selectedShippingAddressId' => $selectedShippingAddressId,
);

$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$cartTaxTotal = isset($cartSummary['cartTaxTotal']) ? $cartSummary['cartTaxTotal'] : 0;
$cartVolumeDiscount = isset($cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0;
$coupon_discount_total = isset($cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0;

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

$netChargeAmt = $cartTotal + $cartTaxTotal - ((0 < $cartVolumeDiscount)?$cartVolumeDiscount:0);
$netChargeAmt = $netChargeAmt - ((0 < $coupon_discount_total)?$coupon_discount_total:0);

$data['netPayable'] = array(
    'key' => Labels::getLabel('LBL_Net_Payable', $siteLangId),
    'value' => CommonHelper::displayMoneyFormat($netChargeAmt)
);

if (!empty($data['cartSummary']) && array_key_exists('cartDiscounts', $data['cartSummary'])) {
    $data['cartSummary']['cartDiscounts'] = !empty($data['cartSummary']['cartDiscounts']) ? $data['cartSummary']['cartDiscounts'] : (object)array();
}

if (1 > count($products)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
