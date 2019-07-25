<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => !empty($msg) ? $msg : Labels::getLabel('MSG_Success', $siteLangId)
);
$request['charges'] = array_values($request['charges']);
$data = array(
    'canEscalateRequest' => $canEscalateRequest,
    'canWithdrawRequest' => $canWithdrawRequest,
    'request' => $request,
    'vendorReturnAddress' => !empty($vendorReturnAddress) ? $vendorReturnAddress : (object)array(),
    'returnRequestTypeArr' => $returnRequestTypeArr,
    'requestRequestStatusArr' => $requestRequestStatusArr,
    'returnRequestTypeArr' => $returnRequestTypeArr,
);
if (1 > count((array)$request)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
