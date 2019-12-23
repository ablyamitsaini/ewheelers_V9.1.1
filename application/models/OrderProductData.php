<?php
class OrderProductData extends MyAppModel
{
    const DB_TBL = 'tbl_order_products_data';
    const DB_TBL_PREFIX = 'opd_';

	public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0)
    {
        $srch = new SearchBase(static::DB_TBL, 'opd');
		return $srch;
    }

	public static function getOrderProductData($op_id, $extendedOrder = false) {
		$srch = self::getSearchObject();
		if($extendedOrder) {
			$srch->addCondition('opd_extend_from_op_id', '=', $op_id);
		} else {
			$srch->addCondition('opd_op_id', '=', $op_id);
		}
		$rs = $srch->getResultSet();
		$data = FatApp::getDb()->fetch($rs);
		return $data;
	}
	
	/* Get order of particular product for particular time interval */

    public static function getProductOrders($prodId, $startDate, $endDate, $prodBufferDays = 0, $extend_rental = 0) {
        if (1 > $prodId) {
            return false;
        }
        
		$processingStatuses = FatApp::getConfig('CONF_PROCESSING_ORDER_STATUS');
		$processingStatuses = unserialize($processingStatuses);
		
		$unavailableQty = 0;
        $prodBufferDays = (int) $prodBufferDays;

        $prodstartBufferDays = ($extend_rental == 1) ? 0 : (int) $prodBufferDays;
        $srch = new SearchBase('tbl_order_products', 'op');
		$srch->joinTable(static::DB_TBL, 'LEFT OUTER JOIN', 'op.op_id = opd.opd_op_id', 'opd');
        $srch->addCondition('op_selprod_id', '=', intval($prodId));
        $srch->addCondition('opd_sold_or_rented', '=', 2);
		$srch->addCondition('op_status_id', 'IN', $processingStatuses);
		$srch->addFld('op_id, op_qty, opd_rental_start_date, opd_rental_end_date');

        /* Please check this condition */
        $srch->addDirectCondition('(("' . $startDate . '" >= opd_rental_start_date AND "' . $startDate . '" <= (opd_rental_end_date + INTERVAL ' . $prodstartBufferDays . ' DAY)) OR ("' . $endDate . '" >= (opd_rental_start_date - INTERVAL ' . $prodBufferDays . ' DAY) AND "' . $endDate . '" <= opd_rental_end_date) OR ("' . $startDate . '" <= opd_rental_start_date AND "' . $endDate . '" >=  opd_rental_end_date))');

        $srch->doNotLimitRecords(true);
        $srch->doNotCalculateRecords(true);
        $query = $srch->getQuery();

        $query .= ' UNION ';

        $srch = new SearchBase('tbl_prod_unavailable_rental_durations');
        $srch->addFld('"0" as op_id, pu_quantity as op_qty,  pu_start_date as opd_rental_start_date, pu_end_date as opd_rental_end_date');
        $srch->addCondition('pu_selprod_id', '=', intval($prodId));

        $srch->addDirectCondition('(("' . $startDate . '" >= pu_start_date AND "' . $startDate . '" <= (pu_end_date + INTERVAL ' . $prodBufferDays . ' DAY)) OR ("' . $endDate . '" >= (pu_start_date - INTERVAL ' . $prodBufferDays . ' DAY) AND "' . $endDate . '" <= pu_end_date) OR ("' . $startDate . '" <= pu_start_date AND "' . $endDate . '" >=  pu_end_date))');

        $srch->doNotLimitRecords(true);
        $srch->doNotCalculateRecords(true);
        $query .= $srch->getQuery();
		$rs = FatApp::getDb()->query($query);
        $rows = FatApp::getDb()->fetchAll($rs);
        return $rows;
    }
}