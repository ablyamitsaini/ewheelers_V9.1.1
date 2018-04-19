<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="section-head">
  <?php if( $cartHasPhysicalProduct ){ echo '4.'; } else { echo '3.'; } ?>
  <?php echo Labels::getLabel('LBL_Review_Order',$siteLangId); ?></div>
<div class="review-wrapper">
  <?php if( $cartHasDigitalProduct && $cartHasPhysicalProduct ){ ?>
  <div class="">
    <div class="tabs tabs--small tabs--scroll clearfix setactive-js">
      <ul>
        <li class="is-active "><a rel="physical_product_tab" href="javascript:void(0)" ><?php echo Labels::getLabel('LBL_Tab_Physical_Product', $siteLangId); ?></a></li>
        <li class="digitalProdTab-js"><a rel="digital_product_tab" href="javascript:void(0)" class=""><?php echo Labels::getLabel('LBL_Tab_Digital_Product', $siteLangId); ?></a></li>
      </ul>
    </div>
  </div>
  <?php }?>
  <div class="short-detail">
    <table class="cart-summary item-yk">
      <tbody>
        <?php 
		if( count($products) ){
			foreach( $products as $product ){
				$productUrl = !$isAppUser?CommonHelper::generateUrl('Products', 'View', array($product['selprod_id']) ):'javascript:void(0)'; 
				$shopUrl = !$isAppUser?CommonHelper::generateUrl('Shops', 'View', array($product['shop_id']) ):'javascript:void(0)';				
				$imageUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
				?>
<tr class="<?php echo (!$product['in_stock']) ? 'disabled' : ''; echo ($product['is_digital_product'])?'digital_product_tab-js':'physical_product_tab-js'; ?>">
<td class="text-center"><div class="product-img"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a></div></td>
<td class="text-left"><div class="item-yk-head">
  <div class="item-yk-head-category"><a href="<?php echo $shopUrl; ?>"><?php echo $product['shop_name']; ?> </a></div>
  <div class="item-yk-head-title"><a href="<?php echo $productUrl; ?>" title="<?php echo $product['product_name']; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?> </a></div>
  <div class="item-yk-head-specification">
	<?php
	if(isset($product['options']) && count($product['options'])){
	foreach($product['options'] as $option){ ?>
	<?php echo ' | ' . $option['option_name'].':'; ?> <?php echo $option['optionvalue_name']; ?>
	<?php
	}
	}
	?>
	| <?php echo Labels::getLabel('LBL_Quantity', $siteLangId) ?> <?php echo $product['quantity']; ?> </div>
</div></td>
<td class="text-right" ><div class="product_price"><span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
  <?php if( $product['special_price_found'] ){ ?>
  <span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
  <?php } ?>
</div>
<a href="javascript:void(0)" onclick="cart.remove('<?php echo md5($product['key']); ?>','checkout','cartReview')" class="btn btn--sm btn--gray ripplelink removeCart-Js"><?php echo Labels::getLabel('LBL_Remove', $siteLangId);?></a></td>
</tr>
<?php } } else {
				echo Labels::getLabel('LBL_Your_cart_is_empty', $siteLangId);
			}
		 ?>
      </tbody>
    </table>
  </div>
  <div class="cartdetail__footer">
    <table>
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
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Tax', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTaxTotal']); ?></td>
      </tr>
      <?php if(!empty($cartSummary['cartRewardPoints'])){?>
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::rewardPointDiscount($cartSummary['orderNetAmount'],$cartSummary['cartRewardPoints'])); ?></td>
      </tr>
      <?php } ?>
      <?php if(!empty($cartSummary['cartDiscounts'])){?>
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
        <td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></td>
      </tr>
      <tr>
        <td></td>
        <td class="text-right"><a href="javascript:void(0)" onClick="loadPaymentSummary();" class="btn btn--secondary ripplelink block-on-mobile"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?> </a></td>
      </tr>
    </table>
  </div>
</div>

<!-- <a class="btn btn--primary btn--h-large" onClick="loadPaymentSummary();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?></a> --> 
<script type="text/javascript">
$("document").ready(function(){
	<?php if($cartHasPhysicalProduct ){ ?>
	$('.digital_product_tab-js').hide();
	<?php }?>
	$(document).on("click",'.setactive-js li a',function(){
		var rel = $(this).attr('rel');
		if(rel =='digital_product_tab'){
			$('.physical_product_tab-js').hide();
			$('.digital_product_tab-js').show();
		}else{
			$('.digital_product_tab-js').hide();
			$('.physical_product_tab-js').show();
		}
	});
});
</script>