<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (array_key_exists('products', $data)) {
    foreach ($data['products'] as $index => $product) {
        $data['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    }
}
if (!empty($data['shop'])) {
    if (!empty($data['shop']['shop_payment_policy'])) {
        $data['shop']['policies'][] = $data['shop']['shop_payment_policy'];
    }
    if (!empty($data['shop']['shop_delivery_policy'])) {
        $data['shop']['policies'][] = $data['shop']['shop_delivery_policy'];
    }
    if (!empty($data['shop']['shop_refund_policy'])) {
        $data['shop']['policies'][] = $data['shop']['shop_refund_policy'];
    }
    if (!empty($data['shop']['shop_additional_info'])) {
        $data['shop']['policies'][] = $data['shop']['shop_additional_info'];
    }
    if (!empty($data['shop']['shop_seller_info'])) {
        $data['shop']['policies'][] = $data['shop']['shop_seller_info'];
    }

    unset($data['shop']['shop_payment_policy'], $data['shop']['shop_delivery_policy'], $data['shop']['shop_refund_policy'], $data['shop']['shop_additional_info'], $data['shop']['shop_seller_info']);
}

$data['shop'] = !empty($data['shop']) ? $data['shop'] : (object)array();

if (empty($data['products'])) {
    $status = applicationConstants::OFF;
}
