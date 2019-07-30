<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$request['charges'] = array_key_exists('charges', $request) ? array_values($request['charges']) : array();
$data = array(
    'canEscalateRequest' => $canEscalateRequest,
    'canWithdrawRequest' => $canWithdrawRequest,
    'request' => $request,
    'vendorReturnAddress' => !empty($vendorReturnAddress) ? $vendorReturnAddress : (object)array(),
    'returnRequestTypeArr' => $returnRequestTypeArr,
    'requestRequestStatusArr' => $requestRequestStatusArr,
    'returnRequestTypeArr' => $returnRequestTypeArr,
);
if (empty($request)) {
    $status = applicationConstants::OFF;
}
