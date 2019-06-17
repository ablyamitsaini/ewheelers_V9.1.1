<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array('file'=>$file);

if (empty($file)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_Image_not_uploaded', $siteLangId);
}
