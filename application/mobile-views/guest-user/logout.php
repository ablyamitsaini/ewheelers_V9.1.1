<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);

