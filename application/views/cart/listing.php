<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="white--bg">
  <div class="tbl-heading"><?php echo Labels::getLabel('LBL_Shopping_Cart', $siteLangId); ?> <span class="gray-txt">(<?php echo count($products)>1 ? count($products)." ".Labels::getLabel('LBL_Items', $siteLangId) : count($products)." ".Labels::getLabel('LBL_Item', $siteLangId)?>)</span></div>
  <table class="table cart--full item-yk" width="100%">
    <thead>
      <tr class="hide--mobile">
        <th><?php echo Labels::getLabel('LBL_Item_Details',$siteLangId); ?></th>
        <th></th>
        <th><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></th>
        <th><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></th>
        <th><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php 
			if( count($products) ){
					foreach( $products as $product ){
						$productUrl = CommonHelper::generateUrl('Products', 'View', array($product['selprod_id']) ); 
						$shopUrl = CommonHelper::generateUrl('Shops', 'View', array($product['shop_id']) );
						$imageUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
						?>
      <tr class="<?php echo (!$product['in_stock']) ? 'disabled' : ''; ?>">
        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Item_Details',$siteLangId); ?></span>
          <div class="product-img"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a></div></td>
        <td><span class="hide--desktop mobile-thead"></span>
          <div class="item-yk-head">
            <div class="item-yk-head-category"><?php echo Labels::getLabel('LBL_Brand', $siteLangId).': '; ?><span class="text--dark"><?php echo $product['brand_name']; ?></div>
            <div class="item-yk-head-title"><a title="<?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a></div>
            <div class="item-yk-head-specification">
				<?php
				if( isset($product['options']) && count($product['options']) ){
					foreach($product['options'] as $option){
						echo ' | ' . $option['option_name'].':'; ?> <span class="text--dark"><?php echo $option['optionvalue_name']; ?></span>
						<?php
					}
				}
				?>
            </div>
          </div>
          <div class="gap"></div>
          <a href="javascript:void(0)" class="btn btn--sm btn--gray ripplelink" onclick="cart.remove('<?php echo md5($product['key']); ?>','cart')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a>
          </td>
        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></span>
          <div class="qty">
			<span class="decrease decrease-js">-</span>
            <input name="qty_<?php echo md5($product['key']); ?>" class="cartQtyTextBox" value="<?php echo $product['quantity']; ?>" type="text" />
			<span class="increase increase-js">+</span>
            </div>
			<a class="refresh" title="<?php echo Labels::getLabel("LBL_Update_Quantity", $siteLangId); ?>" href="javascript:void(0)" onclick="cart.update('<?php echo md5($product['key']); ?>')"><i class="fa fa-refresh"></i></a>
          <?php 
			$stockText = ($product['in_stock']) ? Labels::getLabel('LBL_In_Stock',$siteLangId) : Labels::getLabel('LBL_Out_of_Stock',$siteLangId);
			$stockTextClass = ($product['in_stock']) ? 'text--normal-primary' : 'text--normal-secondary';	
			?>
          <span class="text--normal <?php echo $stockTextClass; ?>"><?php echo $stockText; ?></span></td>
        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
          <?php if( $product['special_price_found'] ){ ?>
          <span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
          <?php } ?></td>
        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['total']); ?> </span></td>
      </tr>
      <?php
					}
				}
			/* if( count($products['single']) ){
				foreach( $products['single'] as $product ){ 					
					$productUrl = CommonHelper::generateUrl('Products', 'View', array($product['selprod_id']) ); 
					$shopUrl = CommonHelper::generateUrl('Shops', 'View', array($product['shop_id']) );
					$imageUrl = CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId));
			?>
			<tr class="<?php echo (!$product['in_stock']) ? 'disabled' : ''; ?>">
				<td>
					<div class="item__group">
						<span class="caption--td"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId); ?></span>
						<div class="item__group--left">
							<figure class="item__pic">
								<a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a>
							</figure>
						</div>
						<div class="item__group--right">
							<div class="item__description">
								<span class="item__title"><a href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a></span>
								<?php if($product['selprod_title']){ ?>
								<p><?php echo $product['product_name']; ?></p>
								<?php } ?>
								<p><?php echo Labels::getLabel('LBL_Brand', $siteLangId).': '; ?><span class="text--dark"><?php echo $product['brand_name']; ?></span>
								<?php
									if(isset($product['options']) && count($product['options'])){
										foreach($product['options'] as $option){ ?>
											<?php echo ' | ' . $option['option_name'].':'; ?>
											<span class="text--dark"><?php echo $option['optionvalue_name']; ?></span>
											<?php
										}
									}
								?>
								</p>
								<span class="text--normal"><?php echo Labels::getLabel('LBL_Sold_by',$siteLangId).': '; ?><a href="<?php echo $shopUrl; ?>"><?php echo $product['shop_name']; ?></a></span>
							</div>
							<div class="item__description">
								<ul class="links--inline">
									<li><a href="javascript:void(0)" onclick="cart.remove('<?php echo md5($product['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>"><i class="fa fa-times"></i><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a></li>
								</ul>
							</div>
						</div>
					</div>
				</td>
				<td>
					<span class="caption--td"><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></span>
					<div class="qty">
						<input name="qty_<?php echo md5($product['key']); ?>" class="cartQtyTextBox" value="<?php echo $product['quantity']; ?>" maxlength="3" type="text" /><a href="javascript:void(0)" onclick="cart.update('<?php echo md5($product['key']); ?>')"><i class="fa fa-refresh"></i></a>
					</div>
					<?php 
					$stockText = ($product['in_stock']) ? Labels::getLabel('LBL_In_Stock',$siteLangId) : Labels::getLabel('LBL_Out_of_Stock',$siteLangId);
					$stockTextClass = ($product['in_stock']) ? 'text--normal-primary' : 'text--normal-secondary';	
					?>
					<span class="text--normal <?php echo $stockTextClass; ?>"><?php echo $stockText; ?></span>
				</td>
				<td>
					<span class="caption--td"><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></span>
					<span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
					<?php if( $product['special_price_found'] ){ ?>
					<span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
					<?php } ?>
				</td>
				<td>
					<span class="caption--td"><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></span>
					<span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['total']); ?> </span>
				</td>
			</tr>
			
			
			<?php } } */ ?>
    </tbody>
  </table>
  
  <!-- cart Footer[ -->
  <div class="cart-footer"> 
    <!--div class="row">
			<div class="col-md-offset-7 col-md-5">
				<div class="form__cover">
				   <h6><?php echo Labels::getLabel('LBL_Apply_Promo_Coupons',$siteLangId);?></h6>
					<?php 
						$PromoCouponsFrm->setFormTagAttribute('class','form form--secondary form--singlefield');
						$PromoCouponsFrm->setFormTagAttribute('onsubmit','applyPromoCode(this); return false;');
						echo $PromoCouponsFrm->getFormTag(); 
						echo $PromoCouponsFrm->getFieldHtml('coupon_code'); 
						echo $PromoCouponsFrm->getFieldHtml('btn_submit'); 
						echo $PromoCouponsFrm->getExternalJs();
						?>
					</form>	
					<span class="gap"></span>	
					<?php if(!empty($cartSummary['cartDiscounts']['coupon_code'])){ ?>
					<div class="alert alert--success">
						<a href="javascript:void(0)" class="close" onClick="removePromoCode()"></a>
						<p><?php echo Labels::getLabel('LBL_Promo_Code',$siteLangId);?> <strong><?php echo $cartSummary['cartDiscounts']['coupon_code'];?></strong> <?php echo Labels::getLabel('LBL_Successfully_Applied',$siteLangId);?></p>
					</div>
					<?php }?>
				</div>		
			</div>		
		</div-->
    <div class="cartdetail__footer">
      <table>
        <tbody>
          <tr>
            <td class="text-left"><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?></td>
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
          <?php if(!empty($cartSummary['cartDiscounts'])){ ?>
          <tr>
            <td class="text-left"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></td>
            <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></td>
          </tr>
          <?php } ?>
          <?php if(!empty($cartSummary['cartRewardPoints'])){?>
          <tr>
            <td class="text-left"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></td>
            <td class="text-right"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::rewardPointDiscount($cartSummary['orderNetAmount'],$cartSummary['cartRewardPoints'])); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
            <td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount']); ?></td>
          </tr>
          <tr>
            <td colspan="2" class="text-right"><a class="btn btn--primary ripplelink block-on-mobile" href="<?php echo CommonHelper::generateUrl(); ?>"><?php echo Labels::getLabel('LBL_Continue_Shopping', $siteLangId); ?></a> <a class="btn btn--secondary ripplelink block-on-mobile" href="<?php echo CommonHelper::generateUrl('Checkout'); ?>"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?></a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="cart-advices">
      <?php if( CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) ){?>
      <div class="summary__row">
        <p class="align--right"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderNetAmount']); /*echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['cartTotal']); */  ?> </p>
      </div>
      <?php } ?>
      <div class="bullet-list">
        <ul>
          <li class="heading"><?php echo Labels::getLabel('LBL_Delivery_and_payment_options', $siteLangId); ?></li>
          <li><?php echo Labels::getLabel('LBL_Safe_&_Secure', $siteLangId); ?></li>
          <li><?php echo Labels::getLabel('LBL_Payment_Protection', $siteLangId); ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>
