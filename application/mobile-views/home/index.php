<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'status'=>1,
    'sponsoredProds' => $sponsoredProds,
    'sponsoredShops' => $sponsoredShops,
    'slides' => $slides,
    'collections' => $collections,
);

$data = array_merge($data, $banners);

if (1 > count($sponsoredProds) && 1 > count($sponsoredShops) && 1 > count($slides) && 1 > count($collections) && 1 > count($banners)) {
    $data['status'] = 0;
    $data['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
