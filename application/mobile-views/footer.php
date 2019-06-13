<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$data = array_merge($commonData,$data);
CommonHelper::jsonEncodeUnicode($data);
