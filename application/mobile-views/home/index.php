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

$data = array_merge($data, $banners);

if (1 > count($sponsoredProds) && 1 > count($sponsoredShops) && 1 > count($slides) && 1 > count($collections) && 1 > count($banners)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
