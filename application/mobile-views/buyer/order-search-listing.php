<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
$data = array(
    'orders' => $orders,
    'page' => $page,
    'pageCount' => $pageCount,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount
);
if (1 > count((array)$orders)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
