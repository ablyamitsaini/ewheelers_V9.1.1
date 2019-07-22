<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$statusArr = array(
    'status'=> 1,
    'msg' => Labels::getLabel('MSG_Success', $siteLangId)
);

$rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId());

$rewardPointsDetail = array(
    'balance' => $rewardPoints,
    'convertedValue' => CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($rewardPoints)),
);
$data = array(
    'rewardPointsDetail' => $rewardPointsDetail,
    'rewardPointsStatement' => $arr_listing,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
    'convertReward' => $convertReward,
);
if (1 > count((array)$arr_listing)) {
    $statusArr['status'] = 0;
    $statusArr['msg'] = Labels::getLabel('MSG_No_record_found', $siteLangId);
}
