<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => $product) {
    $products[$key]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    $products[$key]['selectedProductShippingMethod'] = $selectedProductShippingMethod['product'][$product['selprod_id']];
}

$data = array(
    'cartHasDigitalProduct' => $cartHasDigitalProduct,
    'cartHasPhysicalProduct' => $cartHasPhysicalProduct,
    'products' => array_values($products),
    'cartSummary' => $cartSummary,
    'billingAddress' => empty($billingAddress) ? (object)array() : $billingAddress,
    'shippingAddress' => empty($shippingAddress) ? (object)array() : $shippingAddress,
);

$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$shippingTotal = isset($cartSummary['shippingTotal']) ? $cartSummary['shippingTotal'] : 0;
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
if (0 < $shippingTotal) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Shipping_Charges', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($shippingTotal)
    );
}

$netChargeAmt = $cartTotal + ($cartTaxTotal - ((0 < $cartVolumeDiscount) ? $cartVolumeDiscount : 0)) + $shippingTotal;
$netChargeAmt = $netChargeAmt - ((0 < $coupon_discount_total) ? $coupon_discount_total : 0);

$data['netPayable'] = array(
    'key' => Labels::getLabel('LBL_Net_Payable', $siteLangId),
    'value' => CommonHelper::displayMoneyFormat($netChargeAmt)
);
