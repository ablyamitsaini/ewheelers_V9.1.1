<?php
class Report extends MyAppModel
{
	const COMBINED_REPORT = 1;
    const BOOKING_REPORT = 2; 
	
    public static function salesReportObject($langId = 0, $joinSeller = false, $attr = array(),$booking_report = 0)
    {
        $ocSrch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $ocSrch->doNotCalculateRecords();
        $ocSrch->doNotLimitRecords();
        $ocSrch->addMultipleFields(array('opcharge_op_id','sum(opcharge_amount) as op_other_charges'));
        $ocSrch->addGroupBy('opc.opcharge_op_id');
        $qryOtherCharges = $ocSrch->getQuery();

        $srch = new OrderProductSearch($langId, true);
        $srch->joinPaymentMethod();

        if ($joinSeller) {
            $srch->joinSellerUser();
        }

        $srch->joinTable('(' . $qryOtherCharges . ')', 'LEFT OUTER JOIN', 'op.op_id = opcc.opcharge_op_id', 'opcc');
        $srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_TAX, 'optax');
        $srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_SHIPPING, 'opship');

        $cnd = $srch->addCondition('o.order_is_paid', '=', Orders::ORDER_IS_PAID);
		if($booking_report == 1){
			$srch->addCondition('op.op_is_booking', '=', 1);
		}else{
			$cnd->attachCondition('pmethod_code', '=', 'cashondelivery');
		}
        $srch->addStatusCondition(unserialize(FatApp::getConfig('CONF_COMPLETED_ORDER_STATUS')));

        if (empty($attr)) {
            $srch->addMultipleFields(array('DATE(order_date_added) as order_date','count(op_id) as totOrders','SUM(op_qty) as totQtys','SUM(op_refund_qty) as totRefundedQtys','SUM(op_qty - op_refund_qty) as netSoldQty','sum((op_commission_charged - op_refund_commission)) as totalSalesEarnings','sum(op_refund_amount) as totalRefundedAmount','op.op_qty','op.op_product_amount_without_book','op.op_unit_price','op.op_unit_cost','SUM( op.op_unit_cost * op_qty ) as inventoryValue','IFNULL(op_other_charges, 0) as op_other_charges','sum(( (CASE WHEN op.op_is_booking = 1 THEN op_product_amount_without_book ELSE op_unit_price END) * op_qty ) + IFNULL(op_other_charges, 0) - op_refund_amount) as orderNetAmount','(SUM(optax.opcharge_amount)) as taxTotal','(SUM(opship.opcharge_amount)) as shippingTotal'));
        } else {
            $srch->addMultipleFields($attr);
        }

        return $srch ;
    }
}
