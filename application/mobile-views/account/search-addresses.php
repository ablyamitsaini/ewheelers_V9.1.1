<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


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

if (empty($addresses)) {
    $status = applicationConstants::OFF;
}
