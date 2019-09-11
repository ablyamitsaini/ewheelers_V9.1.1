<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => $product) {
    $products[$key]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    $products[$key]['total'] = !empty($products[$key]['total']) ? CommonHelper::displayMoneyFormat($products[$key]['total']) : 0;
    $products[$key]['totalPrice'] = !empty($products[$key]['totalPrice']) ? CommonHelper::displayMoneyFormat($products[$key]['totalPrice']) : 0;
    $products[$key]['netTotal'] = !empty($products[$key]['netTotal']) ? CommonHelper::displayMoneyFormat($products[$key]['netTotal']) : 0;
    $products[$key]['selectedProductShippingMethod'] = !empty($selectedProductShippingMethod['product'][$product['selprod_id']]) ? $selectedProductShippingMethod['product'][$product['selprod_id']] : (object)array();
}

$data = array(
    'cartHasDigitalProduct' => $cartHasDigitalProduct,
    'cartHasPhysicalProduct' => $cartHasPhysicalProduct,
    'products' => array_values($products),
    'cartSummary' => $cartSummary,
    'billingAddress' => empty($billingAddress) ? (object)array() : $billingAddress,
    'shippingAddress' => empty($shippingAddress) ? (object)array() : $shippingAddress,
);

require_once(CONF_THEME_PATH.'cart/price-detail.php');

if (empty($products)) {
    $status = applicationConstants::OFF;
}
