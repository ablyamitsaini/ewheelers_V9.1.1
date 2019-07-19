<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($offers as $key => $offer) {
    $offers[$key]['offerImage'] = CommonHelper::generateFullUrl('Image', 'coupon', array($offer['coupon_id'],$siteLangId,'NORMAL'));
}
$data = array(
    'offers'=> array_values($offers),
);
if (1 > count((array)$offers)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
