<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'personalInfo' => (object)$personalInfo,
    'bankInfo' => (object)$bankInfo,
);

if (empty((array)$personalInfo) && empty((array)$bankInfo)) {
    $status = applicationConstants::OFF;
}
