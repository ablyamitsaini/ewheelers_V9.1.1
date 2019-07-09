<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$data = array(
    'creditsListing' => array_values($arrListing),
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'userWalletBalance' => $userWalletBalance,
    'userTotalWalletBalance' => $userTotalWalletBalance,
    'promotionWalletToBeCharged' => $promotionWalletToBeCharged,
    'withdrawlRequestAmount' => $withdrawlRequestAmount,
);

if (1 > $recordCount) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
