<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
unset($postedData['btn_submit']);
unset($postedData['btn_clear']);
$data = array(
    'messages' => $arr_listing,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'loggedUserId' => $loggedUserId,
    'page' => $page,
    'pageSize' => $pageSize,
    'postedData' => $postedData,
);

if (1 > count($arr_listing)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
