<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'userImage' => CommonHelper::generateFullUrl('Account', 'userProfileImage', array(UserAuthentication::getLoggedUserId(), 'croped', true)).'?'.time()
);
