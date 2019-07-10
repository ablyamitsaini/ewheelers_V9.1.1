<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
if (1 > $opId) {
    $childOrderDetail = array_values($childOrderDetail);
}
$orderDetail['charges'] = !empty($orderDetail['charges']) ? $orderDetail['charges'] : (object)array();
$orderDetail['billingAddress'] = !empty($orderDetail['billingAddress']) ? $orderDetail['billingAddress'] : (object)array();
$orderDetail['shippingAddress'] = !empty($orderDetail['shippingAddress']) ? $orderDetail['shippingAddress'] : (object)array();

if (!empty($orderDetail['charges'])) {
    $charges = array();
    $i = 0;
    foreach ($orderDetail['charges'] as $key => $value) {
        $charges[$key] = array_values($value);
        $i++;
    }
    $orderDetail['charges'] = $charges;
}

$data = array(
    'orderDetail' => $orderDetail,
    'childOrderDetail' => !empty($childOrderDetail) ? $childOrderDetail : (object)array(),
    'orderStatuses' => !empty($orderStatuses) ? $orderStatuses : (object)array()    ,
    'primaryOrder' => $primaryOrder,
    'digitalDownloads' => !empty($digitalDownloads) ? $digitalDownloads : (object)array(),
    'digitalDownloadLinks' => !empty($digitalDownloadLinks) ? $digitalDownloadLinks : (object)array(),
    'languages' => !empty($languages) ? $languages : (object)array(),
    'yesNoArr' => $yesNoArr,
);
if (1 > count((array)$orderDetail)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
