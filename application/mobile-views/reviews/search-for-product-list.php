<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'reviewsList' => $reviewsList,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
);

if (empty($reviewsList)) {
    $status = applicationConstants::OFF;
}
