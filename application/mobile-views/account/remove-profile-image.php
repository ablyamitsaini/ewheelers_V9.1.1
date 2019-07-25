<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'userImage' => CommonHelper::generateFullUrl('Account', 'userProfileImage', array(UserAuthentication::getLoggedUserId(), 'croped', true)).'?'.time()
);
