<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($slides as $index => $slideDetail) {
    $slides[$index]['slide_image_url'] = CommonHelper::generateFullUrl('Image', 'slide', array($slideDetail['slide_id'], applicationConstants::SCREEN_MOBILE, $siteLangId, 'MOBILE'));
}
foreach ($sponsoredProds as $index => $product) {
    $sponsoredProds[$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
    $sponsoredProds[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], true, false, false);
    $sponsoredProds[$index]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], true, false, false);
}
foreach ($sponsoredShops as $shopIndex => $shopData) {
    foreach ($shopData["products"] as $index => $shopProduct) {
        $sponsoredShops[$shopIndex]['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($shopProduct['product_id'], "CLAYOUT3", $shopProduct['selprod_id'], 0, $siteLangId));
        $sponsoredShops[$shopIndex]['products'][$index]['selprod_price'] = CommonHelper::displayMoneyFormat($shopProduct['selprod_price'], true, false, false);
        $sponsoredShops[$shopIndex]['products'][$index]['theprice'] = CommonHelper::displayMoneyFormat($shopProduct['theprice'], true, false, false);
    }
}
foreach ($collections as $collectionIndex => $collectionData) {
    if (array_key_exists('products', $collectionData)) {
        foreach ($collectionData['products'] as $index => $product) {
            $collections[$collectionIndex]['products'][$index]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId));
            $collections[$collectionIndex]['products'][$index]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], true, false, false);
            $collections[$collectionIndex]['products'][$index]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], true, false, false);
        }
    } elseif (array_key_exists('categories', $collectionData)) {
        foreach ($collectionData['categories'] as $index => $category) {
            $collections[$collectionIndex]['categories'][$index]['prodcat_name'] = html_entity_decode($category['prodcat_name'], ENT_QUOTES, 'utf-8');
            $collections[$collectionIndex]['categories'][$index]['prodcat_description'] = strip_tags(html_entity_decode($category['prodcat_description'], ENT_QUOTES, 'utf-8'));
            $collections[$collectionIndex]['categories'][$index]['category_image_url'] = CommonHelper::generateFullUrl('Category', 'banner', array($category['prodcat_id'] , $siteLangId, 'MOBILE', applicationConstants::SCREEN_MOBILE));
        }
    } elseif (array_key_exists('shops', $collectionData)) {
        foreach ($collectionData['shops'] as $index => $shop) {
            $collections[$collectionIndex]['shops'][$index]['shop_logo'] = CommonHelper::generateFullUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId));
            $collections[$collectionIndex]['shops'][$index]['shop_banner'] = CommonHelper::generateFullUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'MOBILE', 0, applicationConstants::SCREEN_MOBILE));
        }
    } elseif (array_key_exists('brands', $collectionData)) {
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

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections) && empty($banners)) {
    $status = applicationConstants::OFF;
}
