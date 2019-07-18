<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($addresses as $key => $value) {
    $isShippingAddress = 0;
    if ($shippingAddressId == $value['ua_id']) {
        $isShippingAddress = 1;
    }
    $addresses[$key]['isShippingAddress'] = $isShippingAddress;
}
$data = array(
    'addresses' => !empty($addresses) ? $addresses : array(),
);
if (!isset($addresses)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
