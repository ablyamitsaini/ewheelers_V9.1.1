<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'sponsoredProds' => $sponsoredProds,
    'sponsoredShops' => $sponsoredShops,
    'slides' => $slides,
    'collections' => $collections,
);

foreach ($banners as $location => $bannerLocationDetail) {
    foreach ($bannerLocationDetail['banners'] as $index => $bannerDetail) {
        $banners[$location]['banners'][$index]['banner_image_url'] = CommonHelper::generateFullUrl('Banner', 'showOriginalBanner', array($bannerDetail['banner_id'], $siteLangId));
    }
}

$data = array_merge($data, $banners);

if (1 > count($sponsoredProds) && 1 > count($sponsoredShops) && 1 > count($slides) && 1 > count($collections) && 1 > count($banners)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
