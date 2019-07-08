<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($productSelectedShippingMethodsArr as $key => $value) {
    $productSelectedShippingMethodsArr[$key] = array_values($value);
}

$data = array(
    'productSelectedShippingMethodsArr' => !empty($productSelectedShippingMethodsArr) ? $productSelectedShippingMethodsArr : (object)array(),
    'shipStationCarrierList' => !empty($shipStationCarrierList) ? $shipStationCarrierList : (object)array(),
    'shippingMethods' => !empty($shippingMethods) ? $shippingMethods : (object)array(),
    'products' => array_values($products),
    'cartSummary' => $cartSummary,
    'shippingAddressDetail' => !empty($shippingAddressDetail) ? $shippingAddressDetail : (object)array(),
);


if (1 > count($productSelectedShippingMethodsArr)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
