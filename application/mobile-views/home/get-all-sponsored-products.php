<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'sponsoredProds' => $sponsoredProds,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'postedData' => $postedData
);
if (empty($sponsoredProds)) {
    $status = applicationConstants::OFF;
}
