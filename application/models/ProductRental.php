<?php
class ProductRental extends MyAppModel
{
    const DB_TBL = 'tbl_seller_products_data';
    const DB_TBL_PREFIX = 'sprodata_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0, $isDeleted = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'tspd');
		return $srch;
    }
	public static function getProductRentalData($selProdId) {
		$srch = self::getSearchObject();
		$srch->addCondition('sprodata_selprod_id', '=', $selProdId);
		$srch->addCondition('sprodata_is_for_rent', '=', 1);
		$rs = $srch->getResultSet();
		$prodRentalData = FatApp::getDb()->fetch($rs);
		return $prodRentalData;
	}
	
	public function getRentalProductQuantity($prodId, $startDate, $endDate, $prodBufferDays = 0, $extend_rental = 0) {
        /*$processingStatuses = array(
            Settings::getSetting("CONF_DEFAULT_PAID_ORDER_STATUS"),
            Settings::getSetting("CONF_IN_PROCESS_ORDER_STATUS"),
            Settings::getSetting("CONF_DEFAULT_SHIPPING_ORDER_STATUS"),
            //Settings::getSetting("CONF_DELIVERED_ORDER_STATUS"),
            Settings::getSetting("CONF_DEFAULT_DEIVERED_ORDER_STATUS"),
        ); */
		
		$processingStatuses = FatApp::getConfig('CONF_PROCESSING_ORDER_STATUS');
		$processingStatuses = unserialize($processingStatuses);
		
		$unavailableQty = 0;
        $prodBufferDays = (int) $prodBufferDays;
        $prodstartBufferDays = ($extend_rental == 1) ? 0 : (int) $prodBufferDays;
        $srch = new SearchBase(OrderProduct::DB_TBL);
		$srch->joinTable(OrderProductData::DB_TBL, 'LEFT JOIN', 'op_id = opd.opd_op_id', 'opd');
        $srch->addFld('sum(op_qty) as quantity');
        $srch->addCondition('op_selprod_id', '=', intval($prodId));
        $srch->addCondition('opd_sold_or_rented', '=', applicationConstants::PRODUCT_FOR_RENT);
        $srch->addCondition('op_status_id', 'IN', $processingStatuses);


        /* Please check this condition */
        $srch->addDirectCondition('(("' . $startDate . '" >= opd_rental_start_date AND "' . $startDate . '" <= (opd_rental_end_date + INTERVAL ' . $prodstartBufferDays . ' DAY)) OR ("' . $endDate . '" >= (opd_rental_start_date - INTERVAL ' . $prodBufferDays . ' DAY) AND "' . $endDate . '" <= opd_rental_end_date) OR ("' . $startDate . '" <= opd_rental_start_date AND "' . $endDate . '" >=  opd_rental_end_date))');

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
		
		if (!empty($row) && !empty($row['quantity']) && 0 < $row['quantity']) {
            $quantity = (int) $row['quantity'];
        }

        $srch = new SearchBase(SellerRentalProductUnavailableDate::DB_TBL);
        //$srch->addFld('sum(pu_quantity) as quantity');
        $srch->addCondition('pu_selprod_id', '=', intval($prodId));

        $srch->addDirectCondition('(("' . $startDate . '" >= pu_start_date AND "' . $startDate . '" <= (pu_end_date + INTERVAL ' . $prodBufferDays . ' DAY)) OR ("' . $endDate . '" >= (pu_start_date - INTERVAL ' . $prodBufferDays . ' DAY) AND "' . $endDate . '" <= pu_end_date) OR ("' . $startDate . '" <= pu_start_date AND "' . $endDate . '" >=  pu_end_date))');

        $rs = $srch->getResultSet();
        $unavailableData = FatApp::getDb()->fetchAll($rs);
		if (!empty($unavailableData)) {
			$dates = array();
			foreach($unavailableData as $anavialdata) {
				if(strtotime($anavialdata['pu_end_date']) < strtotime($endDate)) {
					$loopEnd = $anavialdata['pu_end_date'];
				} else {
					$loopEnd = date('Y-m-d', strtotime($endDate));
				}
				$loopEnd = strtotime($loopEnd);
				$loopStart = strtotime($anavialdata['pu_start_date']);
				for ($i = $loopStart; $i <=$loopEnd; ) {
					$date = date('Y-m-d', $i);
					if(isset($dates[$date])) {
						$dates[$date] += $anavialdata['pu_quantity'];
					} else {
						$dates[$date] = $anavialdata['pu_quantity'];
					}
					$i = $i+86400;
				}
			}
			$unavialQuanitity = 0; 
			if(!empty($dates)) {
				$startLoop = strtotime(date('Y-m-d', strtotime($startDate)));
				$endLoop = strtotime(date('Y-m-d', strtotime($endDate)));
				
				for($i = $startLoop; $i<=$endLoop;) {
					$date = date('Y-m-d', $i);
					if(array_key_exists($date, $dates)) {
						if ($dates[$date] > $unavialQuanitity) {
							$unavialQuanitity = $dates[$date];
						}
					}
					$i = $i+86400;
				}
			} 
			$quantity += (int) $unavialQuanitity;
		}
		/*if (!empty($row) && !empty($row['quantity']) && 0 < $row['quantity']) {
            $quantity += (int) $row['quantity'];
        } */
		
		$quantity = ($quantity > 0) ? (int) $quantity : 0;
        return $quantity;
    }
	
	public  function getDurationDiscounts($selProId = 0)
    {
        $srch = new SellerProductDurationDiscountSearch();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('produr_rental_duration', 'produr_discount_percent'));
        $srch->addCondition('produr_selprod_id', '=', $selProId);
        $srch->addOrder('produr_rental_duration', 'ASC');
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs);
    }
	
	public static function prodDisableDates($productOrders, $availableStock, $bufferDays = 0, $oprId = 0) {
        $fullyDisableDates = array();
        $disableDatesArray = array();
        if (!empty($productOrders)) {
			//echo "<pre>"; print_r($productOrders); echo "</pre>"; exit;
            foreach ($productOrders as $prodOrder) {
                extract($prodOrder);
                $opd_rental_start_date = date("Y-m-d", strtotime($opd_rental_start_date));
                $opd_rental_end_date = date("Y-m-d", strtotime($opd_rental_end_date));
                if ((0 < (int) $bufferDays) && (($oprId == 0) || ($oprId > 0 && $opr_id != $oprId))) {
                    $opd_rental_end_date = date("Y-m-d", strtotime("+" . $bufferDays . " day", strtotime($opd_rental_end_date)));
                    $opd_rental_start_date = date("Y-m-d", strtotime("-" . $bufferDays . " day", strtotime($opd_rental_start_date)));
                }
                while (strtotime($opd_rental_start_date) <= strtotime($opd_rental_end_date)) {
                    if (array_key_exists($opd_rental_start_date, $disableDatesArray)) {
                        $disableDatesArray[$opd_rental_start_date] += $op_qty;
                    } else {
                        $disableDatesArray[$opd_rental_start_date] = $op_qty;
                    }
                    $opd_rental_start_date = date("Y-m-d", strtotime("+1 day", strtotime($opd_rental_start_date)));
                }
            }
			
			if (!empty($disableDatesArray)) {
                foreach ($disableDatesArray as $key => $disabledate) {
                    if ($disabledate >= $availableStock) {
                        $fullyDisableDates[] = $key;
                    }
                }
            }
        }
        return $fullyDisableDates;
    }
	
	public static function validateDurationDiscountFields($columnIndex, $columnTitle, $columnValue, $langId)
    {
        $requiredFields = static::requiredDurationDiscountFields();
        return ImportexportCommon::validateFields($requiredFields, $columnIndex, $columnTitle, $columnValue, $langId);
    }
	
	public static function requiredDurationDiscountFields()
    {
        return array(
            ImportexportCommon::VALIDATE_POSITIVE_INT => array(
                'selprod_id',
                'produr_rental_duration',
            ),
            ImportexportCommon::VALIDATE_NOT_NULL => array(
                'produr_discount_percent',
            ),
            ImportexportCommon::VALIDATE_FLOAT => array(
                'produr_discount_percent',
            ),
        );
    }
	
	public static function validateUnavialableDatesFields($columnIndex, $columnTitle, $columnValue, $langId)
	{
		$requiredFields = static::requiredUnavialableDatesFields();
        return ImportexportCommon::validateFields($requiredFields, $columnIndex, $columnTitle, $columnValue, $langId);
	}
	
	public static function requiredUnavialableDatesFields()
    {
        return array(
            ImportexportCommon::VALIDATE_POSITIVE_INT => array(
                'selprod_id',
                'pu_quantity',
            )
        );
    }
}