<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


$txnStatusArr = $statusArr;

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

foreach ($arrListing as $key => $value) {
    $arrListing[$key]['utxn_status'] = $txnStatusArr[$value['utxn_status']];
    $arrListing[$key]['utxn_id'] = Transactions::formatTransactionNumber($value['utxn_status']);
}

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
