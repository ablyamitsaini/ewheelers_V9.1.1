<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$user_is_buyer = 0;
if( UserAuthentication::isUserLogged() ){
	$user_is_buyer = User::getAttributesById( UserAuthentication::getLoggedUserId(), 'user_is_buyer' );
}
?>
<?php if( $user_is_buyer > 0 || (!UserAuthentication::isUserLogged()) ){ ?>
<a href="javascript:void(0)">
<span class="icn"> </span>
<span class="icn-txt"><strong><?php echo Labels::getLabel("LBL_Cart", $siteLangId); ?></strong>
	<span class="cartQuantity"><?php echo $totalCartItems.' '.Labels::getLabel("LBL_Items", $siteLangId); ?></span>
</span>
</a>
<div class="dropsection cart-detail">
<a href="javascript:void(0)" id="close-cart-js" class="close-layer"></a>
  <?php if($totalCartItems>0) { ?>
  <div class="cartdetail__body">
    <div class="short-detail">
      <table class="cart-summary item-yk">
        <tbody>
          <?php
					if( count($products) ){
						foreach( $products as $product ){
							$productUrl = CommonHelper::generateUrl('Products', 'View', array($product['selprod_id']) );
							$shopUrl = CommonHelper::generateUrl('Shops', 'View', array($product['shop_id']) );
							$imageUrl =  FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "EXTRA-SMALL", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
							?>
          <tr class="<?php echo (!$product['in_stock']) ? 'disabled' : ''; echo ($product['is_digital_product'])?'digital_product_tab-js':'physical_product_tab-js'; ?>">
            <td class="text-center"><div class="product-img"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a></div></td>
            <td class="text-left"><div class="item-yk-head">
                <div class="item-yk-head-category"><a href="<?php echo $shopUrl; ?>"><?php echo $product['shop_name']; ?> </a></div>
                <div class="item-yk-head-title"><a title="<?php echo $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a></div>
                <div class="item-yk-head-specification">
                  <?php
								if(isset($product['options']) && count($product['options'])){
									foreach($product['options'] as $option){ ?>
                  <?php echo ' | ' . $option['option_name'].':'; ?> <?php echo $option['optionvalue_name']; ?>
                  <?php
									}
								}
							?>
                  | <?php echo Labels::getLabel('LBL_Quantity:', $siteLangId) ?> <?php echo $product['quantity']; ?> </div>
              </div></td>
            <td ><div class="product_price"><span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
                <?php if( $product['special_price_found'] ){ ?>
                <span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
                <?php } ?>
              </div>
              </td>
<td class="text-right"><a href="javascript:void(0)" class="cart-remove" onclick="cart.remove('<?php echo md5($product['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_', $siteLangId); ?></a></td>
          </tr>
          <?php } } else {
							echo Labels::getLabel('LBL_Your_cart_is_empty', $siteLangId);
						}
					 ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="cartdetail__footer">
    <table>
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></td>
      </tr>
      <tr>
        <td class="text-left"><?php echo Labels::getLabel('LBL_Tax', $siteLangId); ?></td>
        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTaxTotal']); ?></td>
      </tr>
      <tr>
        <td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
        <td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']+$cartSummary['cartTaxTotal']); ?></td>
      </tr>
      <tr>
        <td class="text-left"><a href="<?php echo CommonHelper::generateUrl('cart'); ?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_View_Bag', $siteLangId); ?> </a></td>
        <td class="text-right"><a class="btn btn--secondary ripplelink" href="<?php echo CommonHelper::generateUrl('Checkout'); ?>"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?></a></td>
      </tr>
    </table>
  </div>
  <?php } else { ?>
  <div class="block--empty align--center"> <img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty_cart.svg" alt="<?php echo Labels::getLabel('LBL_No_Record_Found', $siteLangId);?>" width="80">
    <h4><?php echo Labels::getLabel('LBL_Your_Shopping_Bag_is_Empty', $siteLangId); ?></h4>
  </div>
  <?php } ?>
</div>
<?php } ?>

<script>
$("document").ready(function(){
	$('#close-cart-js').click(function(){
		if($('html').hasClass('cart-is-active')){
			$('html').removeClass('cart-is-active');
			$('.cart').toggleClass("cart-is-active");
		}
	});
});
</script>
