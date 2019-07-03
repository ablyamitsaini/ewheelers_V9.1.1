<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'orderDetail' => $orderDetail,
    'childOrderDetail' => array_values($childOrderDetail),
    'orderStatuses' => $orderStatuses,
    'primaryOrder' => $primaryOrder,
    'digitalDownloads' => $digitalDownloads,
    'digitalDownloadLinks' => $digitalDownloadLinks,
    'languages' => $languages,
    'yesNoArr' => $yesNoArr,
);
if (1 > count($orderDetail)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
