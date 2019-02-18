<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="gap"></div>
<div class="txt-order-summary"><?php echo Labels::getLabel('LBL_Order_Summary', $siteLangId); ?> <span><span>[<?php echo count($products); ?> <?php echo Labels::getLabel('LBL_Items', $siteLangId); ?>]</span></span> </div>
<div class="gap"></div>
<ul>
  <?php foreach($products as $product){ ?>
  <li>
    <div class="products__title"><?php echo $product['product_name']?> </div>
    <div class="products__category"><?php echo $product['selprod_title']?> </div>
    <div class="gap"></div>
    <div class="product_qty">
      <div class="qty"> <span class="decrease decrease-js">-</span>
		<input name="qty_<?php echo md5($product['key']); ?>" class="cartQtyTextBox" value="<?php echo $product['quantity']; ?>" type="text" />
        <span class="increase increase-js">+</span> </div>
		<ul class="actions">
			<li><a href="javascript:void(0)" onclick="cart.remove('<?php echo md5($product['key']); ?>','checkout','')" title="<?php echo Labels::getLabel("LBL_Remove", $siteLangId); ?>" class="icons-wrapper"><i class="icn"><svg class="svg">
							<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin"></use>
						</svg></i></a>
			</li>
		</ul>
		<!--<a class="refresh" title="<?php /* echo Labels::getLabel("LBL_Update_Quantity", $siteLangId); */ ?>" href="javascript:void(0)" onclick="cart.update('<?php /* echo md5($product['key']); */ ?>','loadFinancialSummary')"><i class="fa fa-refresh"></i></a>-->
		<div class="products__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']*$product['quantity']); ?> </div>
    </div>
  </li>
  <?php } ?>
</ul>
<div class="box box--white box--radius box--space cartdetail__footer">
	<?php if(!empty($cartSummary['cartDiscounts']['coupon_code'])){ ?>
	<div class="applied-coupon"> <span><?php echo Labels::getLabel("LBL_Coupon", $siteLangId); ?> "<strong><?php echo $cartSummary['cartDiscounts']['coupon_code'];?></strong>" <?php echo Labels::getLabel("LBL_Applied", $siteLangId); ?></span> <a href="javascript:void(0)" onClick="removePromoCode()" class="btn btn--sm btn--white ripplelink "><?php echo Labels::getLabel("LBL_Remove", $siteLangId); ?></a></div>
	<?php } else { ?>
	<div class="coupon"> <a class="coupon-input btn btn--secondary btn--block ripplelink" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_I_have_a_coupon', $siteLangId);?></a> </div>
	<div class="gap"></div>
	<?php } ?>
	
	<table>
		<tbody>
			<tr>
				<td class="text-left"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></td>
				<td class="text-right"> <?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></td>
			</tr>
			<?php if( $cartSummary['originalShipping'] ){ ?>
			<tr>
				<td class="text-left"><?php echo Labels::getLabel('LBL_Delivery_Charges', $siteLangId); ?></td>
				<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['shippingTotal']); ?></td>
			</tr>
		  <?php } ?>
		  <?php if( $cartSummary['cartTaxTotal'] ){ ?>
			<tr>
				<td class="text-left"><?php echo Labels::getLabel('LBL_Tax', $siteLangId); ?></td>
				<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTaxTotal']); ?></td>
			</tr>
		  <?php } ?>
		  <?php if( $cartSummary['cartVolumeDiscount'] ){ ?>
			<tr>
				<td class="text-left"><?php echo Labels::getLabel('LBL_Loyalty/Volume_Discount', $siteLangId); ?></td>
				<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></td>
			 </tr>
		  <?php } ?>
		  <?php if(!empty($cartSummary['cartDiscounts'])){?>
			<tr>
				<td class="text-left"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></td>
				<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></td>
			</tr>
		  <?php }?>
		  
		  <?php if(!empty($cartSummary['cartRewardPoints'])){
			 $appliedRewardPointsDiscount = CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']);
			?>
			<tr>
			   <td class="text-left"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></td>
			   <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($appliedRewardPointsDiscount); ?></td>
			</tr>
		 <?php } ?>
			<tr>
				<td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
				<td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></td>
			</tr>
		</tbody>
	</table>
</div>
<div class="gap"></div>
