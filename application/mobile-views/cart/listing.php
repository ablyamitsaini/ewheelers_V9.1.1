<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'products' => $products,
    'cartSummary' => $cartSummary,
    'cartSelectedBillingAddress' => $cartSelectedBillingAddress,
    'cartSelectedShippingAddress' => $cartSelectedShippingAddress,
    'hasPhysicalProduct' => $hasPhysicalProduct,
    'isShippingSameAsBilling' => $isShippingSameAsBilling,
    'selectedBillingAddressId' => $selectedBillingAddressId,
    'selectedShippingAddressId' => $selectedShippingAddressId,
);

if (1 > count($products)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
