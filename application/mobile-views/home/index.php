<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'status'=>1,
    'sponsoredProds' => $sponsoredProds,
    'sponsoredShops' => $sponsoredShops,
    'slides' => $slides,
    'banners' => $banners,
    'collections' => $collections,
);

$data = array_merge($commonData,$data);
CommonHelper::jsonEncodeUnicode($data);
