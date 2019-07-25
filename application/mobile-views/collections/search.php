<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'recordCount' => !empty($recordCount) ? $recordCount : 0,
    'collection' => !empty($collection) ? $collection : (object)array(),
    'collectionItems' => !empty($collections) ? $collections : array(),
);


if (empty($collection)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
