<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);
$carrierServiceList = array();

if (!empty($options)) {
    $i = 0;
    foreach ($options as $key => $value) {
        $carrierServiceList[$i]['title'] = $value;
        $carrierServiceList[$i]['value'] = $key;
        $i++;
    }
}

$data = array(
    'carrierServiceList' => $carrierServiceList
);
