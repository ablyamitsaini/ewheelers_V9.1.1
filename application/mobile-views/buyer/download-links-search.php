<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

array_walk($digitalDownloadLinks, function (&$value) {
    unset($value['opddl_downloadable_link']);
});

$data = array(
    'digitalDownloadLinks'=> $digitalDownloadLinks,
    'page'=> $page,
    'pageCount'=> $pageCount,
    'recordCount'=> $recordCount,
);

if (empty($digitalDownloadLinks)) {
    $status = applicationConstants::OFF;
}
