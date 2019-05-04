<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="section-head">
			<div class="section__heading">
				<h2><?php echo Labels::getLabel('LBL_My_Cart', $siteLangId); ?></h2>
			</div>
			<div class="section__action">
					<a href="javascript:void(0)" onclick="cart.remove('all','cart')"  class="btn btn--primary-border btn--sm"><?php echo Labels::getLabel('LBL_Empty_Cart', $siteLangId); ?></a>
			</div>
	</div>
	<div class="row">
		<div class="col-md-9">


				<div class="box box--white box--radius box--space">
				<table class="table cart--full js-scrollable scroll-hint" style="position: relative; overflow: auto;">
					<thead>
						<tr>
							<th colspan="2"><?php echo Labels::getLabel('LBL_Item(s)_in_cart', $siteLangId).'
							'.count($products); ?></th>

							<th><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></th>
							<th width="12%"><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></th>
							<th width="10%"><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></th>
                            <th></th>
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
                            <div class="product-img"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a></div>
                        </td>
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
                        </td>
                        <td>
                            <span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Quantity',$siteLangId); ?></span>

                            <div class="qty-wrapper">
                                <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">

                                <input name="qty_<?php echo md5($product['key']); ?>" data-key="<?php echo md5($product['key']); ?>" class="qty-input cartQtyTextBox productQty-js" value="<?php echo $product['quantity']; ?>" type="number" min="0"/>
                                </div>
                                <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                                    <span class="increase increase-js"></span>
                                    <span class="decrease decrease-js"></span>
                                </div>


                            <!-- <a class="refresh" title="<?php echo Labels::getLabel("LBL_Update_Quantity", $siteLangId); ?>" href="javascript:void(0)" onclick="cart.update('<?php echo md5($product['key']); ?>')"><i class="fa fa-refresh"></i></a> -->
                          <?php
                            /* $stockText = ($product['in_stock']) ? Labels::getLabel('LBL_In_Stock',$siteLangId) : Labels::getLabel('LBL_Out_of_Stock',$siteLangId);
                            $stockTextClass = ($product['in_stock']) ? 'text--normal-primary' : 'text--normal-secondary'; */
                            ?></div>
                        </td>
                        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_Price',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?> </span>
                          <?php if( $product['special_price_found'] ){ ?>
                          <span class="text--normal text--normal-primary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
                          <?php } ?>
                        </td>
                        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_SubTotal',$siteLangId); ?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['total']); ?> </span>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="icons-wrapper" onclick="cart.remove('<?php echo md5($product['key']); ?>','cart')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>"><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#bin"></use></svg>
                            </i></a>
                        </td>
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

			</div>


		</div>
		<div class="col-md-3">
<div class="box box--white box--radius box--space cart-footer">

<div class="coupon"> <a class="coupon-input btn btn--secondary btn--block" href="javascript:void(0)">I Have A Coupon</a> </div>

			<div class="cartdetail__footer">
				<table class="table--justify">
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
											<?php } $netChargeAmt = $cartSummary['cartTotal']+$cartSummary['cartTaxTotal'] - (( 0 < $cartSummary['cartVolumeDiscount'])?$cartSummary['cartVolumeDiscount']:0);?>
											<tr>
												<td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></td>
												<td class="text-right hightlighted"><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></td>
											</tr>
						<tr>
						<td colspan="2">

						<div class="buy-group">
							<a class="btn btn--primary" href="<?php echo CommonHelper::generateUrl(); ?>"><?php echo Labels::getLabel('LBL_Shop_More', $siteLangId); ?></a>
							<a class="btn btn--primary-border" href="<?php echo CommonHelper::generateUrl('Checkout'); ?>"><?php echo Labels::getLabel('LBL_Checkout', $siteLangId); ?></a>
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



					<div class="cart-advices">
						<div class="row">
							<div class="col-lg-6 mb-sm-2">
								<div class="advices-icons"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/icn-safe.svg"></i>
								<h6>	<?php echo Labels::getLabel('LBL_Safe_&_Secure',$siteLangId);?></h6>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="advices-icons"><i class="icn"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/icn-protection.svg"></i>
									<h6><?php echo Labels::getLabel('LBL_Payment_Protection',$siteLangId);?></h6></div>
							</div>
						</div>
					</div>
</div>
		</div>

	</div>
