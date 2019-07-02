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

$data = array(
    'reviews' => $reviews,
    'codEnabled' => (true === $codEnabled ? 1 : 0),
    'shippingRates' => $shippingRates,
    'shippingDetails' => $shippingDetails,
    'optionRows' => $optionRows,
    'productSpecifications' => $productSpecifications,
    'buyTogether' => $upsellProducts,
    'relatedProducts' => array_values($relatedProductsRs),
    'banners' => $banners,
    'product' => $product,
    'shop_rating' => $shop_rating,
    'shop' => $shop,
    'shopTotalReviews' => $shopTotalReviews,
    'productImagesArr' => array_values($productImagesArr),
    'pollQuest' => $pollQuest,
    'volumeDiscountRows' => $volumeDiscountRows,
    'recommendedProducts' => $recommendedProducts,
);

if (0 < count($socialShareContent)) {
    $data['socialShareContent'] = $socialShareContent;
}

if (1 > count($shippingRates) && 1 > count($shippingDetails) && 1 > count($optionRows) && 1 > count($productSpecifications) && 1 > count($upsellProducts) && 1 > count($relatedProductsRs) && 1 > count($banners) && 1 > count($product) && 1 > count($shop_rating) && 1 > count($shop) && 1 > count($shopTotalReviews) && 1 > count($productImagesArr) && 1 > count($pollQuest) && 1 > count($volumeDiscountRows)  && 1 > count($recommendedProducts)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
