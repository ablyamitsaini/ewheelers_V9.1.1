<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($upsellProducts as $index => $btProduct) {
    $upsellProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($btProduct['product_id'], "THUMB", $btProduct['selprod_id'], 0, $siteLangId));
}

foreach ($relatedProductsRs as $index => $rProduct) {
    $relatedProductsRs[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($rProduct['product_id'], "THUMB", $rProduct['selprod_id'], 0, $siteLangId));
}

foreach ($recommendedProducts as $index => $recProduct) {
    $recommendedProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($recProduct['product_id'], "THUMB", $recProduct['selprod_id'], 0, $siteLangId));
}

foreach ($recentlyViewed as $index => $recViewed) {
    $recentlyViewed[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($recViewed['product_id'], "THUMB", $recViewed['selprod_id'], 0, $siteLangId));
}

foreach ($productImagesArr as $afile_id => $image) {
    $originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
    $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
    $productImagesArr[$afile_id]['product_image_url'] = $mainImgUrl;
}

$product['selprod_return_policies'] = !empty($product['selprod_return_policies']) ? $product['selprod_return_policies'] : (object)array();
$product['selprod_warranty_policies'] = !empty($product['selprod_warranty_policies']) ? $product['selprod_warranty_policies'] : (object)array();
$product['product_description'] = strip_tags(html_entity_decode($product['product_description'], ENT_QUOTES, 'utf-8'));


if (!empty($shop['shop_payment_policy'])) {
    $shop['policies'][] = array(
        'title' => Labels::getLabel('LBL_PAYMENT_POLICY', $siteLangId),
        'description' => $shop['shop_payment_policy'],
    );
}
if (!empty($shop['shop_delivery_policy'])) {
    $shop['policies'][] = array(
        'title' => Labels::getLabel('LBL_DELIVERY_POLICY', $siteLangId),
        'description' => $shop['shop_delivery_policy'],
    );
}
if (!empty($shop['shop_refund_policy'])) {
    $shop['policies'][] = array(
        'title' => Labels::getLabel('LBL_REFUND_POLICY', $siteLangId),
        'description' => $shop['shop_refund_policy'],
    );
}
if (!empty($shop['shop_additional_info'])) {
    $shop['policies'][] = array(
        'title' => Labels::getLabel('LBL_ADDITIONAL_INFO', $siteLangId),
        'description' => $shop['shop_additional_info'],
    );
}
if (!empty($shop['shop_seller_info'])) {
    $shop['policies'][] = array(
        'title' => Labels::getLabel('LBL_SELLER_INFO', $siteLangId),
        'description' => $shop['shop_seller_info'],
    );
}
$data = array(
    'reviews' => empty($reviews) ? (object)array() : $reviews,
    'codEnabled' => (true === $codEnabled ? 1 : 0),
    'shippingRates' => $shippingRates,
    'shippingDetails' => empty($shippingDetails) ? (object)array() : $shippingDetails,
    'optionRows' => $optionRows,
    'productSpecifications' => array(
        'title' => Labels::getLabel('LBL_Specifications', $siteLangId),
        'data' => $productSpecifications,
    ),
    'banners' => $banners,
    'product' => array(
        'title' => Labels::getLabel('LBL_Detail', $siteLangId),
        'data' => empty($product) ? (object)array() : $product,
    ),
    'shop_rating' => $shop_rating,
    'shop' => empty($shop) ? (object)array() : $shop,
    'shopTotalReviews' => $shopTotalReviews,
    'productImagesArr' => array_values($productImagesArr),
    'volumeDiscountRows' => $volumeDiscountRows,
    'socialShareContent' => empty($socialShareContent) ? (object)array() : $socialShareContent,
    'buyTogether' => array(
        'title' => Labels::getLabel('LBL_Product_Add-ons', $siteLangId),
        'data' => $upsellProducts,
    ),
    'relatedProducts' => array(
        'title' => Labels::getLabel('LBL_Similar_Products', $siteLangId),
        'data' => array_values($relatedProductsRs)
    ),
    'recommendedProducts' => array(
        'title' => Labels::getLabel('LBL_Recommended_Products', $siteLangId),
        'data' => $recommendedProducts
    ),
    'recentlyViewed' => array(
        'title' => Labels::getLabel('LBL_Recently_Viewed', $siteLangId),
        'data' => array_values($recentlyViewed)
    )
);


if (empty((array)$product)) {
    $status = applicationConstants::OFF;
}
