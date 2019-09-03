<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'digitalDownloadLinks'=> $digitalDownloadLinks,
    'page'=> $page,
    'pageCount'=> $pageCount,
    'recordCount'=> $recordCount,
);

if (empty($digitalDownloadLinks)) {
    $status = applicationConstants::OFF;
}
