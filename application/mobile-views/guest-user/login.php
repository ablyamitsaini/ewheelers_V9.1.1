<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'status'=>1,
    'token' => $token,
    'user_name' => $userInfo['user_name'],
    'user_id' => $userInfo['user_id'],
    'user_image' => CommonHelper::generateFullUrl('image', 'user', array($userInfo['user_id'],'thumb',1)).'?'.time()
);
