<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($productSelectedShippingMethodsArr as $key => $value) {
    $productSelectedShippingMethodsArr[$key] = array_values($productSelectedShippingMethodsArr[$key]);
}

$data = array(
    'productSelectedShippingMethodsArr' => $productSelectedShippingMethodsArr,
    'shipStationCarrierList' => $shipStationCarrierList,
    'shippingMethods' => $shippingMethods,
    'products' => $products,
    'cartSummary' => $cartSummary,
    'shippingAddressDetail' => $shippingAddressDetail,
    'selectedProductShippingMethod' => $selectedProductShippingMethod,
);


if (1 > count($productSelectedShippingMethodsArr) && 1 > count($shipStationCarrierList) && 1 > count($shippingMethods) && 1 > count($products) && 1 > count($cartSummary) && 1 > count($shippingAddressDetail) && 1 > count($selectedProductShippingMethod)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
