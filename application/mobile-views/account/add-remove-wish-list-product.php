<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
$data = array(
    'wish_list_id' => $wish_list_id,
    'totalWishListItems' => $totalWishListItems,
);
