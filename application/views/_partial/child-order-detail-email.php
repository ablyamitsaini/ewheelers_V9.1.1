<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$shop_address = Shop::getShopAddress($orderProducts['op_shop_id'], true, $siteLangId);
$seller_phone = $shop_address['shop_phone'];
$seller_address = $shop_address['shop_address_line_1'] . ' ' . $shop_address['shop_address_line_2'] . ' ' . $shop_address['shop_city'] . ' ' . $shop_address['state_identifier'];
$payToLabel = Labels::getLabel('LBL_Pending_Amount_to_be_paid', $siteLangId);

$str='<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border:1px solid #ddd; border-collapse:collapse;">
	<tr>
	<td width="40%" style="padding:10px;background:#eee;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;">'.Labels::getLabel('LBL_Product', $siteLangId).'</td>
	<td width="10%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;">'.Labels::getLabel('L_Qty', $siteLangId).'</td>
	<td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Price',$siteLangId).'</td>';
	
	if($orderProducts['op_is_booking'] == 1){
		$str.='<td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Booking_Price',$siteLangId).'</td>';
	}
	
	$str .='<td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Shipping',$siteLangId).'</td>
	<td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId).
	'</td><td width="15%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Tax_Charges',$siteLangId).'</td>
	<td width="20%" style="padding:10px;background:#eee;font-size:13px; border:1px solid #ddd;color:#333; font-weight:bold;" align="right">'.Labels::getLabel('LBL_Total',$siteLangId).'</td>
	</tr>';
	
	$opCustomerBuyingPrice = CommonHelper::orderProductAmount($orderProducts,'CART_TOTAL');
	$shippingPrice = CommonHelper::orderProductAmount($orderProducts,'SHIPPING');
	$volumeDiscount = CommonHelper::orderProductAmount($orderProducts,'VOLUME_DISCOUNT');
	$rewardPoints = CommonHelper::orderProductAmount($orderProducts,'REWARDPOINT');
	$discountTotal = CommonHelper::orderProductAmount($orderProducts,'DISCOUNT');	
	$taxCharged = CommonHelper::orderProductAmount($orderProducts,'TAX');
	$netAmount =  CommonHelper::orderProductAmount($orderProducts,'NETAMOUNT');
	
	$skuCodes = $orderProducts["op_selprod_sku"];
	$options = $orderProducts['op_selprod_options'];
	
	if($orderProducts['op_is_booking'] == 1){
		$total =  ($opCustomerBuyingPrice + $shippingPrice - abs($volumeDiscount));
	}else{
		$total =  ($opCustomerBuyingPrice + $shippingPrice+ $taxCharged - abs($volumeDiscount));
	}
	
	$prodOrBatchUrl = 'javascript:void(0)';
	/* if($orderProducts["op_is_batch"]){
		$prodOrBatchUrl  = CommonHelper::generateFullUrl('products','batch',array($orderProducts["op_selprod_id"]),"/");
	}else{
		$prodOrBatchUrl  = CommonHelper::generateFullUrl('products','view',array($orderProducts["op_selprod_id"]),"/");
	} */
	
	$str .= '<tr>
			<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">
			<a href="'.$prodOrBatchUrl.'" style="font-size:13px; color:#333;">'.$orderProducts["op_product_name"].'</a><br/>'.Labels::getLabel('Lbl_Brand',$siteLangId).':'.$orderProducts["op_brand_name"].'<br/>'.Labels::getLabel('Lbl_Sold_By',$siteLangId).':'.$orderProducts["op_shop_name"].'<br/>'.$options.'<br/>'. ($orderProducts['op_is_booking'] == 1?'<b>( Booking Product )</b><br/><b>'.$payToLabel.'</b><br/><b>'.$seller_address.'</b><br/><b>'.$seller_phone.'</b>' : '' ) .'
			</td>
			<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">'.$orderProducts['op_qty'].'</td>
			<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($orderProducts["op_product_amount_without_book"]).'</td>';
			if($orderProducts['op_is_booking'] == 1){
				$str.='<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">'.CommonHelper::displayMoneyFormat($orderProducts["op_unit_price"]).'</td>';
			}		
			$str .= '<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($shippingPrice).'</td>	<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($volumeDiscount).'</td>	<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($taxCharged).'</td>			
			<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($total).'</td>
		</tr>';			
	
/* 	$str .= '<tr><td colspan="4" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('L_TOTAL', $siteLangId).'</td><td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($total).'</td></tr>'; */
	$colCount = 7;
	if($orderProducts['op_is_booking'] != 1){
		$colCount = $colCount - 1;
	}
	
	$str .= '<tr><td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('L_CART_TOTAL_(_QTY_*_Product_price_)', $siteLangId).'</td><td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($opCustomerBuyingPrice).'</td></tr>';
	
	if ( $shippingPrice > 0 ){
	$str.='<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('LBL_SHIPPING',$siteLangId).'</td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($shippingPrice).'</td>
		</tr>';
	}
	  
	if ( $taxCharged > 0 ){
	$str.='<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('LBL_Tax',$siteLangId).'</td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($taxCharged).'</td>
		</tr>';
	}
	if ( $discountTotal ){
	$str.='<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('LBL_Discount',$siteLangId).'</td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($discountTotal).'</td>
		</tr>';
	}
	if ( $volumeDiscount ){
	$str.='<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId).'</td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($volumeDiscount).'</td>
		</tr>';
	}if ( $rewardPoints ){
	$str.='<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.Labels::getLabel('LBL_Reward_Point_Discount',$siteLangId).'</td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right">'.CommonHelper::displayMoneyFormat($rewardPoints).'</td>
		</tr>';
	}
	
	if($orderProducts['op_is_booking'] == 1) {

		$netAmountWithoutBook = CommonHelper::orderProductAmount($orderProducts,'NETAMOUNT',false,false,1);
		$str.= '<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.Labels::getLabel('LBL_Total_Order_Amount',$siteLangId).'</strong></td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.CommonHelper::displayMoneyFormat($netAmountWithoutBook).'</strong></td></tr>';
		
		$str.= '<tr>
		<td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.Labels::getLabel('LBL_Pending_Amount',$siteLangId).'</strong></td>
		<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.CommonHelper::displayMoneyFormat($netAmountWithoutBook - $opCustomerBuyingPrice ).'</strong></td></tr>';
		
	}
	  
	if($orderProducts['op_is_booking'] == 1){
		$str.= '<tr><td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.Labels::getLabel('LBL_Order_Amount',$siteLangId).'</strong></td><td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderProducts,'NETAMOUNT') - $taxCharged ).'</strong></td></tr>';
	}else{
		$str.= '<tr><td colspan="'.$colCount.'" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.Labels::getLabel('LBL_Order_Amount',$siteLangId).'</strong></td><td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" align="right"><strong>'.CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderProducts,'NETAMOUNT')).'</strong></td></tr>';
	}

	$str .= '</table>';
echo $str;