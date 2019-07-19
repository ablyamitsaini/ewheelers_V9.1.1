<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
foreach ($requests as $key => $request) {
    $requests[$key]['statusName'] = $OrderReturnRequestStatusArr[$request['orrequest_status']];
    $requests[$key]['product_image_url'] = CommonHelper::generateFullUrl('image', 'product', array($request['selprod_product_id'], "THUMB", $request['op_selprod_id'], 0, $siteLangId));
}
$data = array(
    'requests' => $requests,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'returnRequestTypeArr' => $returnRequestTypeArr,
    'OrderReturnRequestStatusArr' => $OrderReturnRequestStatusArr,
);
if (1 > count((array)$requests)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
