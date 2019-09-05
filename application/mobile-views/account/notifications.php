<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'notifications' => $notifications,
    'total_pages' => $total_pages,
    'total_records' => $total_records,
);

if (empty($notifications)) {
    $status = applicationConstants::OFF;
}
