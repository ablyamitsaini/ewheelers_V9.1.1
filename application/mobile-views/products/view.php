<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($upsellProducts as $index => $btProduct) {
    $upsellProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($btProduct['product_id'], "THUMB", $btProduct['selprod_id'], 0, $siteLangId));
    $upsellProducts[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($btProduct['selprod_price'], false, false, false);
    $upsellProducts[$index]['theprice'] = CommonHelper::displayMoneyFormat($btProduct['theprice'], false, false, false);
}

foreach ($relatedProductsRs as $index => $rProduct) {
    $relatedProductsRs[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($rProduct['product_id'], "THUMB", $rProduct['selprod_id'], 0, $siteLangId));
    $relatedProductsRs[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($rProduct['selprod_price'], false, false, false);
    $relatedProductsRs[$index]['theprice'] = CommonHelper::displayMoneyFormat($rProduct['theprice'], false, false, false);
}

foreach ($recommendedProducts as $index => $recProduct) {
    $recommendedProducts[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($recProduct['product_id'], "THUMB", $recProduct['selprod_id'], 0, $siteLangId));
    $recommendedProducts[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($recProduct['selprod_price'], false, false, false);
    $recommendedProducts[$index]['theprice'] = CommonHelper::displayMoneyFormat($recProduct['theprice'], false, false, false);
}

foreach ($recentlyViewed as $index => $recViewed) {
    $recentlyViewed[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($recViewed['product_id'], "THUMB", $recViewed['selprod_id'], 0, $siteLangId));
    $recentlyViewed[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($recViewed['selprod_price'], false, false, false);
    $recentlyViewed[$index]['theprice'] = CommonHelper::displayMoneyFormat($recViewed['theprice'], false, false, false);
}

foreach ($productImagesArr as $afile_id => $image) {
    $originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
    $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
    $productImagesArr[$afile_id]['product_image_url'] = $mainImgUrl;
}

$selectedOptionsArr = $product['selectedOptionValues'];
foreach ($optionRows as $key => $option) {
    foreach ($option['values'] as $index => $opVal) {
        $optionRows[$key]['values'][$index]['isAvailable'] = 1;
        $optionRows[$key]['values'][$index]['isSelected'] = 1;
        if (!in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) {
            $optionRows[$key]['values'][$index]['isSelected'] = 0;
            $optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
            $optionUrlArr = explode("::", $optionUrl);
            if (is_array($optionUrlArr) && count($optionUrlArr) == 2) {
                $optionRows[$key]['values'][$index]['isAvailable'] = 0;
            }
        }
    }
}

if (!empty($product)) {
    $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
    $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
    if (!empty($product['selprod_return_policies'])) {
        $product['productPolicies'][] = array(
            'title' => $product['selprod_return_policies']['ppoint_title'],
            'icon' => CONF_WEBROOT_URL.'images/retina/sprite.svg#easyreturns'
        );
    }
    if (!empty($product['selprod_warranty_policies'])) {
        $product['productPolicies'][] = array(
            'title' => $product['selprod_warranty_policies']['ppoint_title'],
            'icon' => CONF_WEBROOT_URL.'images/retina/sprite.svg#yearswarranty'
        );
    }
    if (isset($shippingDetails['ps_free']) && $shippingDetails['ps_free'] == applicationConstants::YES) {
        $product['productPolicies'][] = array(
            'title' => Labels::getLabel('LBL_Free_Shipping_on_this_Order', $siteLangId),
            'icon' => CONF_WEBROOT_URL.'images/retina/sprite.svg#freeshipping'
        );
    } else if (count($shippingRates) > 0) {
        $product['productPolicies'][] = array(
            'title' => Labels::getLabel('LBL_Shipping_Rates', $siteLangId),
            'icon' => CONF_WEBROOT_URL.'images/retina/sprite.svg#shipping-policies'
        );
    }
    if (0 < $codEnabled) {
        $product['productPolicies'][] = array(
            'title' => Labels::getLabel('LBL_Cash_on_delivery_is_available', $siteLangId),
            'icon' => CONF_WEBROOT_URL.'images/retina/sprite.svg#safepayments'
        );
    }
    $product['youtubeUrlThumbnail'] = '';
    if (!empty($product['product_youtube_video'])) {
        $youtubeVideoUrl = $product['product_youtube_video'];
        $videoCode = CommonHelper::parseYouTubeurl($youtubeVideoUrl);
        $product['youtubeUrlThumbnail'] = 'https://img.youtube.com/vi/'.$videoCode.'/hqdefault.jpg';
    }
    $product['productUrl'] = CommonHelper::generateFullUrl('Products', 'View', array($product['selprod_id']));
}

$product['selprod_return_policies'] = !empty($product['selprod_return_policies']) ? $product['selprod_return_policies'] : (object)array();
$product['selprod_warranty_policies'] = !empty($product['selprod_warranty_policies']) ? $product['selprod_warranty_policies'] : (object)array();

$product['product_description'] = strip_tags(html_entity_decode($product['product_description'], ENT_QUOTES, 'utf-8'), applicationConstants::ALLOWED_HTML_TAGS_FOR_APP);

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
