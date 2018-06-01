<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php /* CommonHelper::printArray($cartSummary); die; */ if(!empty($cartSummary['cartDiscounts']['coupon_code'])){ ?>

<div class="applied-coupon"> <span><?php echo Labels::getLabel("LBL_Coupon", $siteLangId); ?> "<strong><?php echo $cartSummary['cartDiscounts']['coupon_code'];?></strong>" <?php echo Labels::getLabel("LBL_Applied", $siteLangId); ?></span> <a href="javascript:void(0)" onClick="removePromoCode()" class="btn btn--sm btn--white ripplelink "><?php echo Labels::getLabel("LBL_Remove", $siteLangId); ?></a></div>
<?php } else { ?>
<div class="coupon"> <a class="coupon-input btn btn--secondary btn--block ripplelink" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_I_have_a_coupon', $siteLangId);?></a> </div>
<div class="gap"></div>
<div class="heading4 align--center"><?php echo Labels::getLabel('LBL_Order_Summary', $siteLangId); ?> <span>[<?php echo count($products); ?> <?php echo Labels::getLabel('LBL_Items', $siteLangId); ?>]</span> </div>
<?php } ?>
<ul>
  <?php foreach($products as $product){ ?>
  <li>
    <div class="item-yk-head-title"><?php echo $product['product_name']?> </div>
    <div class="item-yk-head-category"><?php echo $product['selprod_title']?> </div>
    <div class="gap"></div>
    <div class="product_qty">
      <div class="qty"> <span class="decrease decrease-js">-</span>
		<input name="qty_<?php echo md5($product['key']); ?>" class="cartQtyTextBox" value="<?php echo $product['quantity']; ?>" type="text" />
        <span class="increase increase-js">+</span> </div>
		<a class="refresh" title="<?php echo Labels::getLabel("LBL_Update_Quantity", $siteLangId); ?>" href="javascript:void(0)" onclick="cart.update('<?php echo md5($product['key']); ?>','loadFinancialSummary')"><i class="fa fa-refresh"></i></a>
		<a class="remove" title="<?php echo Labels::getLabel("LBL_Remove", $siteLangId); ?>" href="javascript:void(0)" onclick="cart.remove('<?php echo md5($product['key']); ?>','checkout','')"><i class="fa fa-times"></i></a>
    </div>
    <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']*$product['quantity']); ?> </div>
  </li>
  <?php } ?>
</ul>
<div class="cartdetail__footer">
  <table>
    <tbody>
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></td>
      </tr>
      <?php if( $cartSummary['shippingTotal'] ){ ?>
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
