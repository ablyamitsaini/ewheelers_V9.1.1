<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

if (!empty($cartSummary) && array_key_exists('cartDiscounts', $cartSummary)) {
    $cartSummary['cartDiscounts'] = !empty($cartSummary['cartDiscounts']) ? $cartSummary['cartDiscounts'] : (object)array();
}

foreach ($products as $index => $product) {
    $products[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    $products[$index]['total'] = !empty($products[$index]['total']) ? CommonHelper::displayMoneyFormat($products[$index]['total']) : 0;
    $products[$index]['totalPrice'] = !empty($products[$index]['totalPrice']) ? CommonHelper::displayMoneyFormat($products[$index]['totalPrice']) : 0;
    $products[$index]['netTotal'] = !empty($products[$index]['netTotal']) ? CommonHelper::displayMoneyFormat($products[$index]['netTotal']) : 0;
    $shipping_options = array(
        array(
            'title' => Labels::getLabel("LBL_Select_Shipping", $siteLangId),
            'value' => 0,
        )
    );
    if (count($product["shipping_rates"])) {
        $i = 1;
        foreach ($product["shipping_rates"] as $skey => $sval) {
            $country_code = empty($sval["country_code"]) ? "" : " (" . $sval["country_code"] . ")";
            $product["shipping_free_availbilty"];
            if ($product['shop_eligible_for_free_shipping'] > 0 && $product['psbs_user_id'] > 0) {
                $shipping_charges = Labels::getLabel('LBL_Free_Shipping', $siteLangId);
            } else {
                $shipping_charges = $product["shipping_free_availbilty"] == 0 ? "+" . CommonHelper::displayMoneyFormat($sval['pship_charges']) : 0;
            }
            $shippingDurationTitle = ShippingDurations::getShippingDurationTitle($sval, $siteLangId);
            $shipping_options[$i]['title'] =  $sval["scompany_name"] ." - " . $shippingDurationTitle . $country_code . " (" . $shipping_charges . ")";
            $shipping_options[$i]['value'] =  $sval['pship_id'];
            $i++;
        }
    }

    $shipStation = array();
    if (!empty($shipStationCarrierList)) {
        $i = 0;
        foreach ($shipStationCarrierList as $key => $value) {
            $shipStation[$i]['title'] = $value;
            $shipStation[$i]['value'] = $key;
            $i++;
        }
    }
    $newShippingMethods = $shippingMethods;
    if (2 > sizeof($shipping_options)) {
        unset($newShippingMethods[SHIPPINGMETHODS::MANUAL_SHIPPING]);
    }
    $i = 0;
    foreach ($newShippingMethods as $key => $value) {
        $products[$index]['shippingMethods'][$i]['title'] = $value;
        $products[$index]['shippingMethods'][$i]['value'] = $key;
        switch ($key) {
            case ShippingMethods::MANUAL_SHIPPING:
                $products[$index]['shippingMethods'][$i]['rates'] = $shipping_options;
                break;
            case ShippingMethods::SHIPSTATION_SHIPPING:
                $products[$index]['shippingMethods'][$i]['rates'] = $shipStation;
                break;
        }
        $i++;
    }
}

$data = array(
    'products' => array_values($products),
    'cartSummary' => $cartSummary,
    'shippingAddressDetail' => !empty($shippingAddressDetail) ? $shippingAddressDetail : (object)array(),
);


if (1 > count((array)$products)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
