<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($slides as $index => $slideDetail) {
    $slides[$index]['slide_image_url'] = CommonHelper::generateFullUrl('Image', 'slide', array($slideDetail['slide_id'],0,$siteLangId));
}
foreach ($sponsoredProds as $index => $product) {
    $sponsoredProds[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
}
foreach ($sponsoredShops as $shopIndex => $shopData) {
    foreach ($shopData["products"] as $index => $shopProduct) {
        $sponsoredShops[$shopIndex]['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($shopProduct['product_id'], "CLAYOUT3", $shopProduct['selprod_id'], 0, $siteLangId));
    }
}
foreach ($collections as $collectionIndex => $collectionData) {
    if (isset($collectionData['products'])) {
        foreach ($collectionData['products'] as $index => $product) {
            $collections[$collectionIndex]['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
        }
    } elseif (isset($collectionData['categories'])) {
        foreach ($collectionData['categories'] as $index => $category) {
            $collections[$collectionIndex]['categories'][$index]['category_image_url'] = CommonHelper::generateFullUrl('Category', 'banner', array($category['prodcat_id'] , $siteLangId));
        }
    } elseif (isset($collectionData['shops'])) {
        foreach ($collectionData['shops'] as $index => $shop) {
            $collections[$collectionIndex]['shops'][$index]['shop_logo'] = CommonHelper::generateFullUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId));
            $collections[$collectionIndex]['shops'][$index]['shop_banner'] = CommonHelper::generateFullUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId));
        }
    } elseif (isset($collectionData['brands'])) {
        foreach ($collectionData['brands'] as $index => $shop) {
            $collections[$collectionIndex]['brands'][$index]['brand_image'] = CommonHelper::generateFullUrl('image', 'brand', array($shop['brand_id'], $siteLangId));
        }
    }
}

$data = array(
    'sponsoredProds' => array(
                        'title' => FatApp::getConfig('CONF_PPC_PRODUCTS_HOME_PAGE_CAPTION_'.$siteLangId, FatUtility::VAR_STRING, Labels::getLabel('LBL_SPONSORED_PRODUCTS', $siteLangId)),
                        'data'=> $sponsoredProds),
    'sponsoredShops' => array(
                        'title' => FatApp::getConfig('CONF_PPC_SHOPS_HOME_PAGE_CAPTION_'.$siteLangId, FatUtility::VAR_STRING, Labels::getLabel('LBL_SPONSORED_SHOPS', $siteLangId)),
                        'data'=> $sponsoredShops),
    'slides' => $slides,
    'collections' => $collections,
);

foreach ($banners as $location => $bannerLocationDetail) {
    foreach ($bannerLocationDetail['banners'] as $index => $bannerDetail) {
        $banners[$location]['banners'][$index]['banner_image_url'] = CommonHelper::generateFullUrl('Banner', 'showOriginalBanner', array($bannerDetail['banner_id'], $siteLangId));
    }
}

$data = array_merge($data, $banners);

if (1 > count((array)$sponsoredProds) && 1 > count((array)$sponsoredShops) && 1 > count((array)$slides) && 1 > count((array)$collections) && 1 > count((array)$banners)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
