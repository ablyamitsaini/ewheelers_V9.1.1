<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$frmShippingApi->developerTags['colClassPrefix'] = 'col-md-';
$frmShippingApi->developerTags['fld_default_col'] = 12;

$frmShippingApi->setFormTagAttribute('onSubmit', 'setUpShippingApi(this); return false;');

$shippingapi_idFld = $frmShippingApi->getField('shippingapi_id');
$shippingapi_idFld->developerTags['col'] = 6;
//$btnSubmit->setFieldTagAttribute('class','btn btn--primary btn--h-large');
?>
<div class="review-wrapper">
	<div class="section-head step__head">3. <?php echo Labels::getLabel('LBL_Shipping_Summary', $siteLangId); ?></div>
	<div class="short-detail">
		<table class="cart-summary item-yk">
			<tbody>
				<?php usort($products, function($a, $b) {
					  return $a['shop_id'] - $b['shop_id'];
					});

					$prevShopId = 0;
				if( count($products) ){
					foreach( $products as $product ){
						if( $product['shop_id'] != $prevShopId){ ?>
							<tr class="-row-heading">
								<td colspan="3"><?php echo $product['shop_name']; ?></td>
								<td class="text-right" colspan="2"><?php
								if($product['shop_eligible_for_free_shipping'] > 0) {
									echo '<div class="note-messages">'.Labels::getLabel('LBL_free_shipping_is_available_for_this_shop', $siteLangId).'</div>' ;
								}
								elseif($product['shop_free_ship_upto'] > 0 && $product['shop_free_ship_upto'] > $product['totalPrice']){
									$str = Labels::getLabel('LBL_Upto_{amount}_you_will_get_free_shipping', $siteLangId);
									$str = str_replace( '{amount}', $product['shop_free_ship_upto'], $str );
									echo '<div class="note-messages">'.$str.'</div>';
								}
								?>
								</td>
							</tr>
						<?php } $prevShopId = $product['shop_id']; $newShippingMethods = $shippingMethods;
						$productUrl = !$isAppUser?CommonHelper::generateUrl('Products', 'View', array($product['selprod_id']) ):'javascript:void(0)';
						$shopUrl = !$isAppUser?CommonHelper::generateUrl('Shops', 'View', array($product['shop_id']) ):'javascript:void(0)';
						$imageUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
						?>
						<tr class="<?php echo (!$product['in_stock']) ? 'disabled' : ''; ?>">
							<td class="text-center"><div class="product-img"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $imageUrl; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>"></a></div></td>
							<td class="text-left">
								<div class="item-yk-head">
								  <div class="item-yk-head-category"><a href="<?php echo $shopUrl; ?>"><?php echo $product['shop_name']; ?> </a></div>
								  <div class="item-yk-head-title"><a href="<?php echo $productUrl; ?>"><a title="<?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a></a></div>
								  <div class="item-yk-head-specification">
									<?php
										if(isset($product['options']) && count($product['options'])){
											foreach($product['options'] as $option){ ?>
												<?php echo ' | ' . $option['option_name'].':'; ?>
												<?php echo $option['optionvalue_name']; ?>
												<?php
											}
										}
									?>
									| <?php echo Labels::getLabel('LBL_Quantity', $siteLangId) ?> <?php echo $product['quantity']; ?>
									</div>
									<?php if(($product['shop_eligible_for_free_shipping'] > 0 || ($product['shop_free_ship_upto'] > 0 && $product['shop_free_ship_upto'] > $product['totalPrice']))  && $product['psbs_user_id'] == 0) { ?>
									<div class="item-yk-head-specification note-messages">
										<?php echo Labels::getLabel('LBL_free_shipping_is_not_eligible_for_this_product', $siteLangId);	?>
									</div>										
									<?php } ?>
								</div>
							</td>
							<td>
								<?php
                        $selectedShippingType = "";
                        $displayManualOptions = "style='display:none'";
                        $displayShipStationOption = "style='display:none'";
					 	$shipping_options = array();
                        $shipping_options[$product['product_id']][0] = Labels::getLabel("LBL_Select_Shipping",$siteLangId);

                        if (count($product["shipping_rates"])) {

                            foreach ($product["shipping_rates"] as $skey => $sval):
                                $country_code = empty($sval["country_code"]) ? "" : " (" . $sval["country_code"] . ")";
								$product["shipping_free_availbilty"];	
								if($product['shop_eligible_for_free_shipping'] > 0 && $product['psbs_user_id'] > 0) {
									$shipping_charges = Labels::getLabel('LBL_Free_Shipping',$siteLangId);
								}else{
									$shipping_charges = $product["shipping_free_availbilty"] == 0 ? "+" . CommonHelper::displayMoneyFormat($sval['pship_charges']) : 0;
								}
								$shippingDurationTitle = ShippingDurations::getShippingDurationTitle( $sval, $siteLangId );
                                $shipping_options[$product['product_id']][$sval['pship_id']] =  $sval["scompany_name"] ." - " . $shippingDurationTitle . $country_code . " (" . $shipping_charges . ")";
                            endforeach;
                            if ($product['is_shipping_selected']== ShippingMethods::MANUAL_SHIPPING) {

                                 $selectedShippingType = ShippingMethods::MANUAL_SHIPPING;
								 $displayManualOptions = "style='display:block'";
                            }
                        }

						$servicesList = array();
						$cartObj = new Cart();
                        if (array_key_exists(ShippingMethods::SHIPSTATION_SHIPPING,$shippingMethods)) {

                            $carrierCode = "";
							$selectedService ='';
                            if ($product['is_shipping_selected'] == ShippingMethods::SHIPSTATION_SHIPPING) {

                                $service_code = str_replace("_", " ", $product['selected_shipping_option']['mshipapi_key']);
								$shippingCodes = explode(" ", $service_code);
								$carrierCode = $shippingCodes[0];
                                $servicesList = $cartObj->getCarrierShipmentServicesList(md5($product['key']), $carrierCode,$siteLangId);
								$selectedShippingType = ShippingMethods::SHIPSTATION_SHIPPING;
                                $displayShipStationOption = "style='display:block'";
                                foreach ($servicesList as $key => $value) {

									if($key == $product['selected_shipping_option']['mshipapi_key']){
										$selectedService = $key;
									}
                                }
                            }
							$courierProviders = CommonHelper::createDropDownFromArray('shipping_carrier[' . md5($product['key']) . ']', $shipStationCarrierList, $carrierCode, 'class="form-control courier_carriers" onChange="loadShippingCarriers(this);"  data-product-key=\'' . md5($product['key']) . '\'', '');
							$serviceProviders = CommonHelper::createDropDownFromArray('shipping_services[' . md5($product['key']) . ']', $servicesList, $selectedService, 'class="form-control courier_services "  ', '');
                        }
                        $select_shipping_options = CommonHelper:: createDropDownFromArray('shipping_locations[' . md5($product['key']) . ']', $shipping_options[$product['product_id']], isset($product["pship_id"])?$product["pship_id"]:'', 'class="form-control "', '');

                        ?>
                        <?php Labels::getLabel('M_Select_Shipping', $siteLangId) ?>
						<ul class="shipping-selectors">
                        <?php


						if(sizeof($shipping_options[$product['product_id']])<2){

							unset($newShippingMethods[SHIPPINGMETHODS::MANUAL_SHIPPING]);
						}

						if( !$product['is_physical_product'] && $product['is_digital_product'] ){
								echo $shippingOptions = CommonHelper::displayNotApplicable($siteLangId, '');
							}
							else{


								if(sizeof($newShippingMethods)>0){

								   echo '<li>'. CommonHelper::createDropDownFromArray('shipping_type[' . md5($product['key']) . ']', $newShippingMethods, $selectedShippingType, 'class="form-control shipping_method"  data-product-key="' . md5($product['key']) . '" ', Labels::getLabel('LBL_Select_Shipping_Method',$siteLangId)) .'</li>';
								}
								else{
									echo '<li class="info-message">'.Labels::getLabel('MSG_Product_is_not_available_for_shipping',$siteLangId).'</li>';
								}?>

								<li class='manual_shipping' <?php echo $displayManualOptions ?>>
									<?php  Labels::getLabel('M_Select_Shipping_Provider',$siteLangId) ?>

									<?php echo $select_shipping_options ?>
								</li>

								<?php if (array_key_exists(ShippingMethods::SHIPSTATION_SHIPPING,$shippingMethods) ) { ?>


								<li class='shipstation_selectbox' <?php echo $displayShipStationOption;?>>
									<?php echo Labels::getLabel('M_Select_Shipping_Provider',$siteLangId) ?>
									<?php echo $courierProviders ?>
								</li>
								<li class='shipstation_selectbox' <?php echo $displayShipStationOption;?>>
									<?php echo  Labels::getLabel('M_Select_Shipping_Carrier',$siteLangId) ?>
									<div class="services_loader"></div>
									<?php echo $serviceProviders ?>
								</li>


								<?php } ?>
								</ul>
								<?php
							}
								// CommonHelper::printArray($product['shipping_rates']);die;
								/* if( !empty($product['shipping_rates']) ){
									$shippingOptions = '<select class="sduration_id-Js" name="sduration_id['.$product['selprod_id'].']" onChange="getProductShippingComment( this, '.$product['selprod_id'].')">';
									$shippingOptions .= '<option value="">'.Labels::getLabel('LBL_Select_Shipping', $siteLangId).'</option>';
									$isSuccess = false;
									foreach( $product['shipping_rates'] as $shippingRates ){
										$shippingOptions .= '<option  value="'.$shippingRates['sduration_id'].'">' . $shippingRates['sduration_name'] .'</option>';
									}
								}
								else {
									$shippingOptions = Labels::getLabel('MSG_No_Shipping_duration_set', $siteLangId);
								}
								echo $shippingOptions; */

								/* if( !empty($shippingDurations) && $product['is_physical_product'] ){
									$shippingOptions = '<select class="sduration_id-Js" name="sduration_id['.$product['selprod_id'].']" onChange="getProductShippingComment( this, '.$product['selprod_id'].')">';
									$shippingOptions .= '<option value="">'.Labels::getLabel('LBL_Select_Shipping', $siteLangId).'</option>';
									$isSuccess = false;
									foreach( $shippingDurations as $shippingDuration ){
										$sduration_id = $shippingDuration['sduration_id'];
										$price_filter_data = array(
											'mshipapi_sduration_id' => $sduration_id,
											'weight'	=>	$product['product_weight'],
											'weight_unit' => $product['product_weight_unit'],
											'length'	=>	$product['product_length'],
											'width'	=>	$product['product_width'],
											'height'	=>	$product['product_height'],
											'product_dimension_unit' => $product['product_dimension_unit'],
											'zipCode'	=>	$shippingAddressDetail['ua_zip'],
											'state'		=>	$shippingAddressDetail['ua_state_id'],
											'country'	=>	$shippingAddressDetail['ua_country_id'],
										);

										$shippingPriceInfo = ShippingApi::getShippingPrice( $price_filter_data, $siteLangId, $error );
										if( !$shippingPriceInfo || empty($shippingPriceInfo) ){
											if(!$isSuccess){
												$isError = $error;
												if( empty($shippingPriceInfo) ){
													$isError = Labels::getLabel('LBL_Product_Shipping_details_are_not_configured.', $siteLangId);
												}
											}
										} else {
											$isSuccess = true;
											$shippingPriceArr[$sduration_id] = $shippingPriceInfo;

											$selectedString = '';
											if( isset($selectedProductShippingMethod['product'][$product['selprod_id']]['sduration_id']) ){
												$selectedString = ( $sduration_id == $selectedProductShippingMethod['product'][$product['selprod_id']]['sduration_id'] ) ? 'selected = "selected"' : '';
											}
											$shippingDurationName = $shippingDuration['sduration_name'];

											$shippingDurationTitle = ShippingDurations::getShippingDurationTitle($shippingDuration, $siteLangId);
											$shippingDurationName .= ' - '. $shippingDurationTitle;

											$shippingDurationName .= ' - '.CommonHelper::displayMoneyFormat($shippingPriceArr[$sduration_id]['mshipapi_cost']);

											$shippingOptions .= '<option '.$selectedString.' value="'.$sduration_id.'">' . $shippingDurationName .'</option>';
										}
									}
									$shippingOptions.= '</select>';

									if($isSuccess ){
										foreach( $shippingPriceArr as $sduration_id => $info ){
											$shippingOptions .= '<div class = "text--small shipping_comment_'.$product['selprod_id'].'" style="display:none;" id="shipping_comment_'.$product['selprod_id'].'_'.$sduration_id.'">'.$info['mshipapi_comment'].'</div>';
										}
									}

								} else {
									$shippingOptions = Labels::getLabel('MSG_No_Shipping_duration_set', $siteLangId);
								}
								if( $product['is_digital_product'] ){
									$shippingOptions = CommonHelper::displayNotApplicable($siteLangId, '');
								}
								echo $shippingOptions; */
								?>
							</td>
							<td class="text-right" ><div class="product_price"><span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']*$product['quantity']); ?> </span>
								<?php if( $product['special_price_found'] ){ ?>
								<span class="text--normal text--normal-secondary"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
								<?php } ?></div>
								<a href="javascript:void(0)" onclick="cart.remove('<?php echo md5($product['key']); ?>','checkout')" class="btn btn--sm btn--gray ripplelink"><?php echo Labels::getLabel('LBL_Remove', $siteLangId);?></a>
							</td>
						</tr>
						<?php }
					} else {
						echo Labels::getLabel('LBL_Your_cart_is_empty', $siteLangId);
					} ?>
			</tbody>
		</table>
	</div>
	<div class="cartdetail__footer">
		<table>
		  <tr>
			<td class="text-left"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?> </td>
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
		  <?php if(!empty($cartSummary['cartRewardPoints'])){
			$appliedRewardPointsDiscount = CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']);
			?>
			<tr>
			  <td class="text-left"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></td>
			  <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($appliedRewardPointsDiscount); ?></td>
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
			<td class="text-right"><a class="btn btn--secondary " onClick="setUpShippingMethod();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?></a></td>
		  </tr>
		</table>
	</div>
</div><!--box box--white ends -->

<script>
 $('.shipping_method').on("change", function () {

        if ($(this).val() == "0") {
            $(this).parent().parent().find('.shipstation_selectbox').hide();
            $(this).parent().parent().find('.manual_shipping').hide();
        } else if ($(this).val() == "1") {

            $(this).parent().parent().find('.shipstation_selectbox').hide();
            $(this).parent().parent().find('.manual_shipping').show();
        }
		else if ($(this).val() == "2") {
       /*      resetShipstationSelectBox(this); */
           $(this).parent().parent().find('.shipstation_selectbox').show();
            $(this).parent().parent().find('.manual_shipping').hide();
        }
    });

    function resetShipstationSelectBox(obj) {
        $('.courier_carriers').val(0);
        loadShippingCarriers(obj);
        return true;
    }
	 function loadShippingCarriers(obj) {


        $(obj).parent().next().find('.services_loader').html(fcom.getLoader());
        $(obj).parent().next().find('.courier_services ').hide();
		 /* $(".shipstation_selectbox").LoadingOverlay("show",{'image':''}); */
		 var carrier_id = $(obj).val();
		 var product_key = $(obj).attr('data-product-key');

		   var href = fcom.makeUrl('checkout', 'getCarrierServicesList',[product_key,carrier_id]);

		   fcom.ajax(href, '', function(response) {
			    $(obj).parent().next().find('.services_loader').html('');
				 $(obj).parent().next().find('.courier_services ').show();
				$(obj).parent().next().find('.courier_services').html(response);


			});




        }
</script>
