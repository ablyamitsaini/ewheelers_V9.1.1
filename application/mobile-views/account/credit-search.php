<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


$txnStatusArr = $statusArr;


foreach ($arrListing as $key => $value) {
    $arrListing[$key]['utxn_statusLabel'] = $txnStatusArr[$value['utxn_status']];
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
    'txnStatusArr' => $txnStatusArr,
);

if (1 > $recordCount) {
   $status = applicationConstants::OFF;
}
