<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => $product) {
    $products[$key]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    $optionTitle = '';
    if (is_array($product['options']) && count($product['options'])) {
        foreach ($product['options'] as $op) {
            $optionTitle .= $op['option_name'].': '.$op['optionvalue_name'].', ';
        }
    }
    $products[$key]['optionsTitle'] = rtrim($optionTitle, ', ');
}

$data = array(
    'products' => $products,
    'showProductShortDescription' => $showProductShortDescription,
    'showProductReturnPolicy' => $showProductReturnPolicy,
    'page' => $page,
    'recordCount' => $recordCount,
    'pageCount' => $pageCount,
);


if (empty($products)) {
    $status = applicationConstants::OFF;
}
