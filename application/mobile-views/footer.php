<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$data = array_merge($commonData, $data);
$data = array_merge($statusArr, array('data' => $data ));
CommonHelper::jsonEncodeUnicode($data);
