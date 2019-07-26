<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);

$threadDetails['threadTypeTitle'] = $threadTypeArr[$threadDetails['thread_type']];

$data = array(
    'threadDetails' => $threadDetails,
    'threadTypeArr' => $threadTypeArr,
);

if (1 > count((array)$threadDetails)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
