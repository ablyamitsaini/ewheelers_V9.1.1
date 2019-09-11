<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

unset($data['frmProductSearch'], $data['postedData']);

if (array_key_exists('products', $data)) {
    foreach ($data['products'] as $index => $product) {
        $data['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
        $data['products'][$index]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], true, false, false);
        $data['products'][$index]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], true, false, false);
    }
}
if (empty($data)) {
    $status = applicationConstants::OFF;
}
