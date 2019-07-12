<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($upsellProducts as $index => $btProduct) {
    $upsellProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($btProduct['product_id'], "THUMB", $btProduct['selprod_id'], 0, $siteLangId));
}

foreach ($relatedProductsRs as $index => $rProduct) {
    $relatedProductsRs[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($rProduct['product_id'], "THUMB", $rProduct['selprod_id'], 0, $siteLangId));
}

foreach ($recommendedProducts as $index => $recProduct) {
    $recommendedProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($recProduct['product_id'], "THUMB", $recProduct['selprod_id'], 0, $siteLangId));
}

$data = array(
    'reviews' => empty($reviews) ? (object)array() : $reviews,
    'codEnabled' => (true === $codEnabled ? 1 : 0),
    'shippingRates' => $shippingRates,
    'shippingDetails' => empty($shippingDetails) ? (object)array() : $shippingDetails,
    'optionRows' => $optionRows,
    'productSpecifications' => ($productSpecifications),
    'banners' => $banners,
    'product' => empty($product) ? (object)array() : $product,
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
    )
);


if (1 > count((array)$reviews)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
