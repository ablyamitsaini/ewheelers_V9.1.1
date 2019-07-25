<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);
$data = array(
    'digitalDownloadLinks'=> $digitalDownloadLinks,
    'page'=> $page,
    'pageCount'=> $pageCount,
    'recordCount'=> $recordCount,
);

if (1 > count((array)$digitalDownloadLinks)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
