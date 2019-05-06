<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="d-flex justify-content-between cart-head mb-3">
	<h5><?php echo count($products).' '.Labels::getLabel('LBL_Items_In_Cart', $siteLangId); ?></h5>
	<a href="javascript:void(0)" onclick="cart.remove('all','cart')"  class="btn btn--primary-border btn--sm"><?php echo Labels::getLabel('LBL_Empty_Cart', $siteLangId); ?></a>
</div>
<div class="box box--white box--radius box--space">
	<table class="table cart--full js-scrollable scroll-hint" style="position: relative; overflow: auto;">
		<thead>
			<tr>
				<th><?php echo Labels::getLabel('LBL_Item_Details',$siteLangId); ?></th>
				<th></th>
				<th><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></th>
				<th><?php echo Labels::getLabel('LBL_Remove',$siteLangId); ?></th>
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
            <div class="item-yk-head-title">
                <a title="<?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a>
            </div>
            <div class="item-yk-head-specification">
				<?php
				if( isset($product['options']) && count($product['options']) ){
                    $count = 0;
					foreach($product['options'] as $option){
						echo ($count > 0) ? ' | ' : '' ; echo $option['option_name'].':'; ?> <span class="text--dark"><?php echo $option['optionvalue_name']; ?></span>
						<?php $count++;
					}
				}
				?>
            </div>

            <?php
				$showAddToFavorite = true;
				if( UserAuthentication::isUserLogged() && ( !User::isBuyer() ) ){
					$showAddToFavorite = false;
				}
			?>

            <?php if($showAddToFavorite) { ?>
                    <br>
                    <?php if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
                        if( empty($product['ufp_id']) ){
                        ?>
                            <a href="javascript:void(0)" class="btn btn--sm btn--gray ripplelink" onClick="addToFavourite( '<?php echo md5($product['key']); ?>',<?php echo $product['selprod_id']; ?> );" title="<?php echo Labels::getLabel('LBL_Move_to_wishlist', $siteLangId); ?>">
                                <?php echo Labels::getLabel('LBL_Move_to_favourites', $siteLangId); ?>
                            </a>
                 <?php  }else{
                            ?>
                            <?php
                            echo Labels::getLabel('LBL_Already_marked_as_favourites.', $siteLangId);
                        }
                    } else {
                        if( empty( $product['is_in_any_wishlist'] ) ){
                        ?>
                            <a href="javascript:void(0)" class="btn btn--sm btn--gray ripplelink" onClick="moveToWishlist( <?php echo $product['selprod_id']; ?>, event, '<?php echo md5($product['key']); ?>' );" title="<?php echo Labels::getLabel('LBL_Move_to_wishlist', $siteLangId); ?>">
                                <?php echo Labels::getLabel('LBL_Move_to_wishlist', $siteLangId); ?>
                            </a>
                  <?php }else{
                            echo Labels::getLabel('LBL_Already_added_to_your_wishlist.', $siteLangId);
                        }
                    }
                } ?>

          </div>
          </td>
        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></span><div class="qty-wrapper">  <div class="qty" data-stock="<?php echo $product['selprod_stock']; ?>">
			<span class="decrease decrease-js">-</span>
            <input name="qty_<?php echo md5($product['key']); ?>" class="cartQtyTextBox productQty-js" value="<?php echo $product['quantity']; ?>" type="number" min="0"/>
			<span class="increase increase-js">+</span>
            </div>
			<a class="refresh" title="<?php echo Labels::getLabel("LBL_Update_Quantity", $siteLangId); ?>" href="javascript:void(0)" onclick="cart.update('<?php echo md5($product['key']); ?>')"><i class="fa fa-refresh"></i></a>
          <?php
			$stockText = ($product['in_stock']) ? Labels::getLabel('LBL_In_Stock',$siteLangId) : Labels::getLabel('LBL_Out_of_Stock',$siteLangId);
			$stockTextClass = ($product['in_stock']) ? 'text--normal-primary' : 'text--normal-secondary';
			?>
          <span class="text--normal <?php echo $stockTextClass; ?>"><?php echo $stockText; ?></span></div>
		</td>
		<td>
			<a href="javascript:void(0)" class="icons-wrapper" onclick="cart.remove('<?php echo md5($product['key']); ?>','cart')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>"><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin"></use></svg>
			</i></a>
		</td>
		        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
		          <?php if( $product['special_price_found'] ){ ?>
		          <span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
		          <?php } ?></td>
		        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['total']); ?> </span></td>
		      </tr>
		      <?php } } ?>
	  </tbody>
</table>
<?php if(!empty($cartSummary['cartDiscounts']['coupon_code'])){ ?>
<div class="alert alert--success">
	<a href="javascript:void(0)" class="close" onClick="removePromoCode()"></a>
	<p><?php echo Labels::getLabel('LBL_Promo_Code',$siteLangId);?> <strong><?php echo $cartSummary['cartDiscounts']['coupon_code'];?></strong> <?php echo Labels::getLabel('LBL_Successfully_Applied',$siteLangId);?></p>
</div>
<?php }?>
<div class="cart-footer">
	<div class="row">
		<div class="col-lg-4 col-md-12 d-none d-xl-block d-lg-block">
			<div class="cart-advices">
				<h5><?php echo Labels::getLabel('LBL_Delivery_And_Payment_Options',$siteLangId);?></h5>
				<div class="row">
					<div class="col-lg-5">
						<div class="advices-icons"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/icn-safe.svg"></i><?php echo Labels::getLabel('LBL_Safe_&_Secure',$siteLangId);?></div>
					</div>
					<div class="col-lg-5">
						<div class="advices-icons"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/icn-protection.svg"></i><?php echo Labels::getLabel('LBL_Payment_Protection',$siteLangId);?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-12"></div>
		<div class="col-lg-5 col-md-12">
			<div class="cartdetail__footer">
				<table>
					<tbody>
					  <tr>
						<td class="text-left"><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?></td>
						<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></td>
					  </tr>
					  <?php if( $cartSummary['cartTaxTotal'] ){ ?>
					  <tr>
						<td class="text-left"><?php echo Labels::getLabel('LBL_Tax', $siteLangId); ?></td>
						<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTaxTotal']); ?></td>
					  </tr>
					  <?php } ?>
                      <?php if( $cartSummary['cartVolumeDiscount'] ){ ?>
                      <tr>
                        <td class="text-left"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></td>
                        <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></td>
                      </tr>
					  
                      <?php } ?>
                      <tr>
                        <td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
                        <td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat( $cartSummary['netChargeAmount'] ); ?></td>
                      </tr>
					  <tr>
						<td colspan="2" class="text-right">
						<div class="gap"></div>
						<div class="btns-group">
							<a class="btn btn--primary btn--lg" href="<?php echo CommonHelper::generateUrl(); ?>"><?php echo Labels::getLabel('LBL_Continue_Shopping', $siteLangId); ?></a>
							<a class="btn btn--secondary btn--lg" href="<?php echo CommonHelper::generateUrl('Checkout'); ?>"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?></a>
						</div>
						</td>
					  </tr>
					</tbody>
			  </table>
			</div>
				<?php if( CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) ){?>
				  <div class="summary__row">
					<p class="align--right"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderNetAmount']); ?> </p>
				  </div>
				  <?php } ?>
		</div>
	</div>
</div>
