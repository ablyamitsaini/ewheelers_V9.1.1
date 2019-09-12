<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($offers as $key => $offer) {
    $offers[$key]['offerImage'] = CommonHelper::generateFullUrl('Image', 'coupon', array($offer['coupon_id'],$siteLangId,'NORMAL'));
    $offers[$key]['coupon_min_order_value'] = CommonHelper::displayMoneyFormat($offer['coupon_min_order_value'], false, false, false);
}

$data = array(
    'offers'=> array_values($offers),
);

if (empty($offers)) {
    $status = applicationConstants::OFF;
}
