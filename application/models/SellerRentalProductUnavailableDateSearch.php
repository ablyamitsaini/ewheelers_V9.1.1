<?php
class SellerRentalProductUnavailableDateSearch extends SearchBase
{
    public function __construct($langId = 0)
    {
        parent::__construct(SellerRentalProductUnavailableDate::DB_TBL, 'spud');
    }

    public static function getSearchObject($pu_id = '', $selprod_id = '', $userId = '', $attr = '')
    {
        $srch = new SearchBase(SellerRentalProductUnavailableDate::DB_TBL, 'spud');
        if (!empty($attr)) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } else {
                $srch->addfld($attr);
            }
        }
        if (!empty($pu_id) && 0 < $pu_id) {
            $srch->addCondition('pu_id', '=', $pu_id);
            $srch->setPageSize(1);
        }
        if (!empty($selprod_id) && 0 < $selprod_id) {
            $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_id = spud.produr_selprod_id', 'sp');
            $srch->addCondition('produr_selprod_id', '=', $selprod_id);
        }

        if (!empty($userId) && 0 < $userId) {
            $srch->addCondition('selprod_user_id', '=', $userId);
        }
        return $srch;
    }
	public static function getProductUnavailableDates($selprod_id, $stock) {
		$srch = self::getSearchObject();
		$srch->addCondition('pu_selprod_id', '=', $selprod_id);
		$srch->addCondition('pu_quantity', '=', $stock);
		$srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
		$rs = $srch->getResultSet();
		$dates = FatApp::getDb()->fetchAll($rs);
		$allDates = array();
		if (!empty($dates)) {
			foreach($dates as $date) {
				$pu_start_date = $date['pu_start_date'];
				$pu_end_date = $date['pu_end_date'];
				$date1 = strtotime($pu_start_date); 
				$date2 = strtotime($pu_end_date); 
				for ($currentDate = $date1; $currentDate <= $date2; $currentDate += (86400)) {
                    $newdate = date('Y-m-d', $currentDate); 
					$allDates[] = $newdate; 
				} 
			}
		}
		return $allDates;
	}
}