<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
$data = array(
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'shops' => !empty(array_filter($shops)) ? $shops : array()
);

if (empty(array_filter($shops))) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
