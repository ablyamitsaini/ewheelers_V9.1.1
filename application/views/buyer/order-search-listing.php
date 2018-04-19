<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'order_id'	=>	Labels::getLabel('LBL_Order_ID_Date', $siteLangId),
	'product'	=>	Labels::getLabel('LBL_Ordered_Product', $siteLangId),
	'total'		=>	Labels::getLabel('LBL_Total', $siteLangId),
	'status'	=>	Labels::getLabel('LBL_Status', $siteLangId),
	'action'	=>	Labels::getLabel('LBL_Action', $siteLangId),
);

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
$canCancelOrder = true;
$canReturnRefund = true;
foreach ($orders as $sn => $order){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array( 'class' => '' ));
	$orderDetailUrl = CommonHelper::generateUrl('Buyer', 'viewOrder', array($order['order_id'],$order['op_id']) );
	
	if( $order['op_product_type'] == Product::PRODUCT_TYPE_DIGITAL ){
		$canCancelOrder = ( in_array($order["op_status_id"],(array)Orders::getBuyerAllowedOrderCancellationStatuses(true)) );
		$canReturnRefund = ( in_array( $order["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses(true) ) );
	} else {
		$canCancelOrder = ( in_array($order["op_status_id"],(array)Orders::getBuyerAllowedOrderCancellationStatuses()) );
		$canReturnRefund = ( in_array( $order["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses() ) );
	}
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'order_id':
			$txt = '<span class="caption--td">'.$val.'</span><a title="'.Labels::getLabel('LBL_View_Order_Detail', $siteLangId).'" href="'.$orderDetailUrl.'">';
			if( $order['totOrders'] > 1 ){
				$txt .= $order['op_invoice_number'];
			} else {
				$txt .= $order['order_id'];
			}
			$txt .= '</a><br/>'. FatDate::format($order['order_date_added']);
			$td->appendElement('plaintext', array(), $txt , true);
			break;
			case 'product':
				$txt = '<span class="caption--td">'.$val.'</span>';
				if( $order['op_selprod_title'] != '' ){
					$txt .= '<div class="item-yk-head-title">'.$order['op_selprod_title'].'</div>';
				}
				$txt .= '<div class="item-yk-head-sub-title">'.$order['op_product_name'].' ('.Labels::getLabel('LBL_Qty', $siteLangId).': '.$order['op_qty'].')</div>';
				$txt .= '<div class="item-yk-head-brand">'.Labels::getLabel('LBL_Brand', $siteLangId).': '.$order['op_brand_name'].'</div>';
				if( $order['op_selprod_options'] != '' ){
					$txt .= ' | ' . $order['op_selprod_options'];
				}
				if( $order['totOrders'] > 1 ){
					$txt .= '<div class="item-yk-head-specification">'.Labels::getLabel('LBL_Part_combined_order', $siteLangId).' <a title="'.Labels::getLabel('LBL_View_Order_Detail', $siteLangId).'" href="'.CommonHelper::generateUrl('Buyer', 'viewOrder', array($order['order_id']) ).'">'.$order['order_id'].'</div>';
				}
				$td->appendElement('plaintext', array(), $txt , true);
			break;
			case 'total':
				$txt = '<span class="caption--td">'.$val.'</span>';
				/* if( $order['totOrders'] == 1 ){
					$txt .= CommonHelper::displayMoneyFormat($order['order_net_amount'], true, true);
				} else {
					$txt .= '-';
				} */
				// var_dump($order['totOrders']);
				// CommonHelper::displayMoneyFormat($order['order_net_amount'], true, true);
				$txt .= CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($order));
				$td->appendElement('plaintext', array(), $txt, true);
			break;
			case 'status':
			$pMethod ='';
				if( $order['order_pmethod_id']==PaymentSettings::CashOnDelivery && $order['order_status']==FatApp::getConfig('CONF_DEFAULT_ORDER_STATUS')){
						$pMethod = " - ".$order['pmethod_name'] ;
				}
				$txt = '<span class="caption--td">'.$val.'</span>'.$order['orderstatus_name'].$pMethod;
				$td->appendElement('plaintext', array(), $txt , true);
			break;
			
			
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"),'<span class="caption--td">'.$val.'</span>',true);
				
				$opCancelUrl = CommonHelper::generateUrl('Buyer', 'orderCancellationRequest', array($order['op_id']) );
				
				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=> $orderDetailUrl, 'class'=>'',
				'title'=>Labels::getLabel('LBL_View_Order',$siteLangId)),
				'<i class="fa fa-eye"></i>', true);
				
				if( $canCancelOrder ){
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> $opCancelUrl, 'class'=>'',
					'title'=>Labels::getLabel('LBL_Cancel_Order',$siteLangId)),
					'<i class="fa fa-close"></i>', true);
				}
				
				if(FatApp::getConfig("CONF_ALLOW_REVIEWS")){
					$opFeedBackUrl = CommonHelper::generateUrl('Buyer', 'orderFeedback', array($order['op_id']) );
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> $opFeedBackUrl, 'class'=>'',
					'title'=>Labels::getLabel('LBL_Feedback',$siteLangId)),
					'<i class="fa fa-star"></i>', true);
				}
				
				if( $canReturnRefund ){
					$opRefundRequestUrl = CommonHelper::generateUrl('Buyer', 'orderReturnRequest', array($order['op_id']) );
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=> $opRefundRequestUrl, 'class'=>'',
					'title'=>Labels::getLabel('LBL_Refund',$siteLangId)),
					'<i class="fa fa-dollar"></i>', true);
				}
				
			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$order[$key],true);
			break;
		}
	}
}
if (count($orders) == 0){
	// $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_Unable_to_find_any_record', $siteLangId));
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	echo $tbl->getHtml();
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmOrderSrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToOrderSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);