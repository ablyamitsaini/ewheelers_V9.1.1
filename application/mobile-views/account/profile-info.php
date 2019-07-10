<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'personalInfo' => $personalInfo,
    'bankInfo' => $bankInfo,
);

if (1 > count((array)$personalInfo) && 1 > count((array)$bankInfo)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
