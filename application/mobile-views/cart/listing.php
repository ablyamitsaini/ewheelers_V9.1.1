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
    'cartSelectedBillingAddress' => $cartSelectedBillingAddress,
    'cartSelectedShippingAddress' => $cartSelectedShippingAddress,
    'hasPhysicalProduct' => $hasPhysicalProduct,
    'isShippingSameAsBilling' => $isShippingSameAsBilling,
    'selectedBillingAddressId' => $selectedBillingAddressId,
    'selectedShippingAddressId' => $selectedShippingAddressId,
);

$data['priceDetail'] = array(
    array(
        'key' => Labels::getLabel('LBL_Items', $siteLangId),
        'value' => count($products)
    ),
    array(
        'key' => Labels::getLabel('LBL_Total', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartSummary['cartTotal'])
    ),
    array(
        'key' => Labels::getLabel('LBL_Tax', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartSummary['cartTaxTotal'])
    )
);

if (isset($cartSummary['cartDiscounts']['coupon_discount_total'])) {
    $data['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_Discount', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total'])
    );
}
// $data['priceDetail'][] = array(
//     'key' => Labels::getLabel('LBL_Net_Payable', $siteLangId),
//     'value' => CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'])
// );

if (1 > count($products)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
