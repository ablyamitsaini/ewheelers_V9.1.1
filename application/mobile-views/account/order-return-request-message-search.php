<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);
$data = array(
    'messagesList' => array_values($messagesList),
    'page' => $page,
    'pageCount' => $pageCount,
    'totalRecords' => $totalRecords,
    'startRecord' => $startRecord,
    'endRecord' => $endRecord,
);

if (1 > count((array)$messagesList)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
