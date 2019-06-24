<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'reviewsList' => $reviewsList,
    'page' => $page,
    'pageCount' => $pageCount,
    'postedData' => $postedData,
    'startRecord' => $startRecord,
    'totalRecords' => $totalRecords,
);

if (1 > count($reviewsList)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
