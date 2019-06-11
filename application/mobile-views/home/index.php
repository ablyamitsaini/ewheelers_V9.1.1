<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


$data = array(
    'status' => 1,
    'data'=> array(
        array(
            'type' => 'sponsoredProds',
            'title' => Labels::getLabel('LBL_Sponsored_Products', $langId),
            'data' => $sponsoredProds
        ),
        array(
            'type' => 'sponsoredShops',
            'title' => Labels::getLabel('LBL_Sponsored_Shops', $langId),
            'data' => $sponsoredShops
        ),
        array(
            'type' => 'slides',
            'title' => Labels::getLabel('LBL_Slides', $langId),
            'data' => $slides
        ),
        array(
            'type' => 'collections',
            'title' => Labels::getLabel('LBL_Collections', $langId),
            'data' => $collections
        ),
    )
);
$bannersArr = array();
foreach ($banners as $bannerType => $banner) {
    $data['data'][] = array(
        'type' => $bannerType,
        'title' => Labels::getLabel('LBL_Banners', $langId),
        'data' => $banner
    );
}

if (1 > count($sponsoredProds) && 1 > count($sponsoredShops) && 1 > count($slides) && 1 > count($collections) && 1 > count($banners)) {
    $data['status'] = 0;
    $data['msg'] = Labels::getLabel('MSG_No_record_found', $langId);
}
