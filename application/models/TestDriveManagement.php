<?php
class TestDriveManagement extends MyAppModel
{
    const DB_TBL = 'tbl_test_drive_credit_slabs';
    const DB_TBL_PREFIX = 'tdcs_';

    private $requestId;

    public function __construct($reqId = 0)
    {
        $this->requestId =  $reqId;
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $reqId);
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL);
        return $srch;
    }

    public static function countSellerCompletedRides($seller_id)
    {
        $obj = TestDrive::getSearchObject();
        $obj->addCondition('sp.selprod_user_id', '=', $seller_id);
        $obj->addCondition('ptdr_status', '=', TestDrive::STATUS_COMPLETED);
        $rs = $obj->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs);
        return count($row);
    }

    public static function checkSellerCreditAmount($seller_id)
    {
        $amount = 0;
        $count = Self::countSellerCompletedRides($seller_id);
        $id = Self::getRangeIndex($count);
        if (empty($id)) {
            return $amount;
        }
        $array = Self::getAttributesById($id);
        $amount = $array['tdcs_amount'];
        return $amount;
    }

    public static function getRangeIndex($range)
    {
        $srch = Self::getSearchObject();
        $srch->addMultipleFields(array('tdcs_min_rides','tdcs_max_rides','tdcs_id'));
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $result = $db->fetchAll($rs);
        if (empty($result)) {
            return '';
        }
        foreach ($result as $key => $val) {
            $driveRanges[$val['tdcs_id']] = $val;
        }

        foreach ($driveRanges as $key => $val) {
            if ($val['tdcs_min_rides'] <= $range && $val['tdcs_max_rides'] >= $range) {
                return $key;
            }
        }
        return '';
    }

    public static function checkBuyerCreditAmount($user_id)
    {
        $totalRewards = 0;
        $obj = TestDrive::getSearchObject();
        $obj->addCondition('ptdr_user_id', '=', $user_id);
        $obj->addMultipleFields(array('ptdr_user_reward_points'));
        $rs = $obj->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs);

        if (empty($row)) {
            return true;
        }

        foreach ($row as $val) {
            $totalRewards += $val['ptdr_user_reward_points'];
        }

        if ($totalRewards > 0) {
            return false;
        }

        return true;
    }
}
