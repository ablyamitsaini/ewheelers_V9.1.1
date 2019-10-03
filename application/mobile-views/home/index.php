<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($slides as $index => $slideDetail) {
    $uploadedTime = AttachedFile::setTimeParam($slideDetail['slide_img_updated_on']);
    $slides[$index]['slide_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Image', 'slide', array($slideDetail['slide_id'], applicationConstants::SCREEN_MOBILE, $siteLangId, 'MOBILE')).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
}
foreach ($sponsoredProds as $index => $product) {
    $uploadedTime = AttachedFile::setTimeParam($product['product_image_updated_on']);
    $sponsoredProds[$index]['product_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $sponsoredProds[$index]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
    $sponsoredProds[$index]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
}
foreach ($sponsoredShops as $shopIndex => $shopData) {
    foreach ($shopData["products"] as $index => $shopProduct) {
        $uploadedTime = AttachedFile::setTimeParam($shopProduct['product_image_updated_on']);
        $sponsoredShops[$shopIndex]['products'][$index]['product_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'product', array($shopProduct['product_id'], "CLAYOUT3", $shopProduct['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $sponsoredShops[$shopIndex]['products'][$index]['selprod_price'] = CommonHelper::displayMoneyFormat($shopProduct['selprod_price'], false, false, false);
        $sponsoredShops[$shopIndex]['products'][$index]['theprice'] = CommonHelper::displayMoneyFormat($shopProduct['theprice'], false, false, false);
    }
}
foreach ($collections as $collectionIndex => $collectionData) {
    if (array_key_exists('products', $collectionData)) {
        foreach ($collectionData['products'] as $index => $product) {
            $uploadedTime = AttachedFile::setTimeParam($product['product_image_updated_on']);
            $collections[$collectionIndex]['products'][$index]['product_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');;
            $collections[$collectionIndex]['products'][$index]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
            $collections[$collectionIndex]['products'][$index]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
        }
    } elseif (array_key_exists('categories', $collectionData)) {
        foreach ($collectionData['categories'] as $index => $category) {
            $collections[$collectionIndex]['categories'][$index]['prodcat_name'] = html_entity_decode($category['prodcat_name'], ENT_QUOTES, 'utf-8');
            $collections[$collectionIndex]['categories'][$index]['prodcat_description'] = strip_tags(html_entity_decode($category['prodcat_description'], ENT_QUOTES, 'utf-8'));
            $collections[$collectionIndex]['categories'][$index]['category_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Category', 'banner', array($category['prodcat_id'] , $siteLangId, 'MOBILE', applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg');
        }
    } elseif (array_key_exists('shops', $collectionData)) {
        foreach ($collectionData['shops'] as $index => $shop) {
            $collections[$collectionIndex]['shops'][$index]['shop_logo'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
            $collections[$collectionIndex]['shops'][$index]['shop_banner'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'MOBILE', 0, applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg');
        }
    } elseif (array_key_exists('brands', $collectionData)) {
        foreach ($collectionData['brands'] as $index => $shop) {
            $collections[$collectionIndex]['brands'][$index]['brand_image'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('image', 'brand', array($shop['brand_id'], $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
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
        $uploadedTime = AttachedFile::setTimeParam($bannerDetail['banner_img_updated_on']);
        $banners[$location]['banners'][$index]['banner_image_url'] = FatCache::getCachedUrl(CommonHelper::generateFullUrl('Banner', 'showOriginalBanner', array($bannerDetail['banner_id'], $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    }
}

$data = array_merge($data, $banners, $orderProducts);

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections) && empty($banners)) {
    $status = applicationConstants::OFF;
}
