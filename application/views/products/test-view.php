<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class','qty-input cartQtyTextBox productQty-js');
?>
<div id="body" class="body" role="main">
<section class="pt-3">
	<div class="container">  
     <div class="breadcrumbs">
      <?php  $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
    </div></div>
</section>
<section>
  <div class="container">
    
      <div class="row">
        <div class="col-lg-7">
          <div id="img-static" class="product-detail-gallery">
              <?php $data['product'] = $product;
				$data['productImagesArr'] = $productImagesArr;
				$data['imageGallery'] = true;
				/* $this->includeTemplate('products/product-gallery.php',$data,false); */
			   ?>
				<div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-for">
				<?php if( $productImagesArr ){ ?>
				  <?php
					foreach( $productImagesArr as $afile_id => $image ){
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
				  ?>
				  <img class="xzoom" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				<?php break; }?>
				<?php } else {
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'ORIGINAL', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');?>
				  <img class="xzoom" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				  <?php } ?>
				</div>
				<?php if( $productImagesArr ){ ?>
					<div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-nav">
						<?php foreach( $productImagesArr as $afile_id => $image ){
							$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							/* $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */
						?>
						<div class="thumb"><a href="<?php echo $originalImgUrl; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>"></a></div>
					  <?php } ?>
					</div>
				<?php } ?>
				 
          </div>
        </div>
        <div class="col-lg-5">
			<div class="product-description">
				<div class="product-description-inner">
					<div class="products__title">
					<div class="section-head">
						<div class="section__heading"><h2><?php echo $product['selprod_title'];?></h2></div>
						<?php $productView = true; ?>	
					<?php include(CONF_THEME_PATH.'_partial/collection-ui.php'); ?>
					</div>
					</div>					
					<div class="detail-grouping">
					<div class="row mb-3">
						<div class="col">Brand: Nike</div>
						<div class="col-auto">Sold By: <a href="#" class="">Vike fashion store</a> </div>
					</div>					
					<div class="row mb-3">
						<div class="col">
							<div class="products__rating"> <i class="icn"><svg class="svg">
                                <use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
                            </svg></i> <span class="rate">2.7 Out Of 5 - <a href="/yokartv8/reviews/shop/1">1 Reviews</a> </span>
                    </div>                    
						</div> <div class="col-auto">
							<a href="#" class="btn btn--primary-border btn--sm">Ask Question</a>
						</div> 
						</div>
						
					</div> 
				</div>
				
				
        

			<?php  if($shop['shop_free_ship_upto'] > 0 && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']){ ?>
            <div class="gap"> </div>
					<?php $freeShipAmt = CommonHelper::displayMoneyFormat($shop['shop_free_ship_upto']);
				?>
			 
			<?php }?>
			<?php if( count($productSpecifications)>0 ){ ?>
			<div class="gap"></div>
		 
			<?php }?>
			<?php if( !empty($optionRows) ){ ?>
			<div class="gap"></div>
			<div class="box box--gray box--radius box--space">
				<div class="row">
					<?php $selectedOptionsArr = $product['selectedOptionValues'];

					foreach($optionRows as $option){ ?>
					<div class="<?php echo ($option['option_is_color']) ? 'col-auto column' : 'col-auto column'; ?>">
						<div class="h6"><?php echo $option['option_name']; ?> :</div>
						<div class="article-options <?php echo ($option['option_is_color']) ? 'options--color' : 'options--size'; ?>">
							<?php if($option['values']){ ?>
							<ul>
								<?php foreach( $option['values'] as $opVal ){
									$isAvailable = true;
									if(in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])){
										$optionUrl = CommonHelper::generateUrl('Products','view',array($product['selprod_id']));
									} else {
									$optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
										$optionUrlArr = explode("::", $optionUrl);
										if( is_array($optionUrlArr) && count($optionUrlArr) == 2 ){
											$optionUrl = $optionUrlArr[0];
											$isAvailable = false;
										}
									}
								?>
							  <li class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' is--active' : ' '; echo (!$optionUrl) ? ' is-disabled' : ''; echo (!$isAvailable) ? 'not--available':'';?>">
								<?php   if($option['option_is_color'] && $opVal['optionvalue_color_code'] != '' ){ ?>
								<a  optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues = "<?php echo implode("_",$selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" class="<?php echo (!$option['option_is_color']) ? 'selector__link' : ''; echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' ' : ' '; echo (!$optionUrl) ? ' is-disabled' : '';  ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>"> <span style="background-color:#<?php echo $opVal['optionvalue_color_code']; ?>;"></span></a>
								<?php   } else{ ?>
								<a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues = "<?php echo implode("_",$selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? '' : ' '; echo (!$optionUrl) ? ' is-disabled' : '' ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>"> <?php echo $opVal['optionvalue_name'];  ?> </a>
								<?php } ?>
							  </li>
							  <?php } ?>
							</ul>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php }?>

			
              <!-- ] -->
			  <?php if($product['product_upc']!='') { ?>
				<div class="gap"></div>
				<div><?php echo Labels::getLabel('LBL_EAN/UPC_code', $siteLangId).' : '.$product['product_upc'];?></div>
			  <?php }?>

            <div class="gap"></div>
            <div class="">
              <!-- Add To Cart [ -->
              <?php if( $product['in_stock'] ){
					echo $frmBuyProduct->getFormTag();
					$qtyField =  $frmBuyProduct->getField('quantity');
					$qtyFieldName =  $qtyField->getCaption();
					if(strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){
					?>
                
                   <div class="row align-items-end">
                   <div class="col-auto form__group">
                    <label><?php echo $qtyFieldName;?></label>
                    <div class="qty-wrapper">
                        <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                            <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                        </div>
                        <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                            <span class="increase increase-js"></span>
                            <span class="decrease decrease-js"></span>
                        </div>
                    </div>
                </div>
                
                 <div class="col products__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>  <?php if($product['special_price_found']){ ?>
				<span class="products__price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span> <span class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span><?php } ?>
				</div>
            </div>
             
              </div>
              
             
			  <?php }?>
              <div class="gap"></div>
              <div class="buy-group">
                <?php
					if(strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){
						echo $frmBuyProduct->getFieldHtml('btnProductBuy');
						echo $frmBuyProduct->getFieldHtml('btnAddToCart');
					}
					echo $frmBuyProduct->getFieldHtml('selprod_id');
					?>
              </div>
              
              </form>
              
              <?php /* Volume Discounts[ */
			 if( isset($volumeDiscountRows) && !empty($volumeDiscountRows) ){
			?>
			<div class="gap"></div>
			<div class="box box--gray box--radius box--space">
				<div class="h6 js-acc-triger acc-triger active"><?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)',$siteLangId);?>:</div>
				<ul class="js--discount-slider discount-slider acc-data" dir="<?php echo CommonHelper::getLayoutDirection();?>" >
                    <?php foreach($volumeDiscountRows as $volumeDiscountRow ){
							$volumeDiscount = $product['theprice'] * ( $volumeDiscountRow['voldiscount_percentage'] / 100 );
							$price = ($product['theprice'] - $volumeDiscount);
					?>
					<li>
					  <div class="qty__value"><?php echo ($volumeDiscountRow['voldiscount_min_qty']); ?> <?php echo Labels::getLabel('LBL_Or_more',$siteLangId);?> (<?php echo $volumeDiscountRow['voldiscount_percentage'].'%';?>) <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($price); ?> / <?php echo Labels::getLabel('LBL_Product',$siteLangId);?></span><span class="item__price--old"><?php echo CommonHelper::displayMoneyFormat($product['theprice']);?></span></div>
					</li>
                    <?php } ?>
                  </ul>
			</div>
			<script type="text/javascript">
				$("document").ready(function(){
					$('.js--discount-slider').slick( getSlickSliderSettings(2,1,langLbl.layoutDirection) );
				});
			</script>
			<?php } /* ] */ ?>
             
             <!-- Upsell Products [ -->
            <?php if (count($upsellProducts)>0) { ?>
                <div class="gap"></div>
                <div class="box box--gray box--radius box--space">
                    <div class="h6 js-acc-triger acc-triger"><?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?></div>
                    <div class="acc-data">
                       <div class="addons-scrollbar" data-simplebar> <table class="table cart--full cart-tbl cart-tbl-addons">
                            <tbody>
                            <?php  foreach ($upsellProducts as $usproduct) {
                            $cancelClass ='';
                            $uncheckBoxClass='';
                            if($usproduct['selprod_stock']<=0){
                                $cancelClass ='cancelled--js';
                                $uncheckBoxClass ='remove-add-on';
                            }
                        ?>
                        <tr>
                          <td class="<?php echo $cancelClass;?>"><figure class="item__pic"><a title="<?php echo $usproduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('products','view',array($usproduct['selprod_id']))?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($usproduct['product_id'], 'MINI', $usproduct['selprod_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');?>" alt="<?php echo $usproduct['product_identifier']; ?>"> </a></figure></td>
                          <td class="<?php echo $cancelClass;?>"><div class="item__description">
                                            <div class="item__title"><a href="<?php echo CommonHelper::generateUrl('products', 'view', array($usproduct['selprod_id']) )?>" ><?php echo $usproduct['selprod_title']?></a></div></div>
                           <?php if($usproduct['selprod_stock']<=0){ ?>
                              <div class="addon--tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></div>
                              <?php  } ?></td>
                          <td class="<?php echo $cancelClass;?>"><div class="item__price"><?php echo CommonHelper::displayMoneyFormat($usproduct['theprice']); ?></div></td>
                          <td class="<?php echo $cancelClass;?>">
                            <div class="qty-wrapper">
                                <div class="qty-input-wrapper" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                    <input type="text" value="1" placeholder="Qty" class="qty-input cartQtyTextBox productQty-js" lang="addons[<?php echo $usproduct['selprod_id']?>]" name="addons[<?php echo $usproduct['selprod_id']?>]">
                                </div>
                                <div class="quantity" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                    <span class="increase increase-js"></span>
                                    <span class="decrease decrease-js"></span>
                                </div>
                            </div>
                          </td>
                          <td class="<?php echo $cancelClass;?>"><label class="checkbox">
                              <input <?php if($usproduct['selprod_stock']>0){ ?>checked="checked" <?php } ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass;?>" id="check_addons" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId);?>">
                              <i class="input-helper"></i> </label>
                            </td>
                        </tr>
                        <?php } ?>
                            </tbody>
                        </table></div>                       
                    </div>
                </div>
            <?php } ?>         
              
              
              <?php echo $frmBuyProduct->getExternalJs();
					} else { ?>
              <div class="sold">
                <h4 class=""><?php echo Labels::getLabel('LBL_Sold_Out',$siteLangId); ?></h4>
                <p class=""><?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?></p>
              </div>
              <?php } ?>
			  <?php if(strtotime($product['selprod_available_from'])> strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){?>
				<div class="sold">
					<h4><?php echo Labels::getLabel('LBL_Not_Available',$siteLangId); ?></h4>
					<p><?php echo str_replace('{available-date}',FatDate::Format($product['selprod_available_from']),Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?></p>
				  </div>
			  <?php }?>
              <!-- ] --> 
            </div>
          </div>
          </div>
        </div>
      </div>
	 </section>
	 <?php if($recommendedProducts){ ?>	 
	 <section class="section certified-bar">
	 	<div class="container">
	 		<div class="row justify-content-between">
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#freeshipping" href="/yokartv8/images/retina/sprite.svg#freeshipping"></use>
			</svg>
		</i><p>30 Days Warranty</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#easyreturns" href="/yokartv8/images/retina/sprite.svg#easyreturns"></use>
			</svg>
		</i>
	 					<p>No Returns</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#yearswarranty" href="/yokartv8/images/retina/sprite.svg#yearswarranty"></use>
			</svg>
		</i>
	 					<p>Free Shipping on this Order</p>
	 				</div>
	 			</div>
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#safepayments" href="/yokartv8/images/retina/sprite.svg#safepayments"></use>
			</svg>
		</i>
	 					<p>Shipping Policies</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#safepayments" href="/yokartv8/images/retina/sprite.svg#safepayments"></use>
			</svg>
		</i>
	 					<p>Cash On Delivery Is Available </p>
	 				</div>
	 			</div>
	 			
	 		</div>
	 	</div>	 	
	 </section>
	 
	 
	 <section class="section">
	 	<div class="container">
	 		<div class="row">
	 			<div class="col-md-6">
	 			<div class="section-head">
			<div class="section__heading">
			<h2>Description</h2>
			</div>
		</div>
	 				<div class="cms product-specifications border rounded p-4" data-simplebar>
	 				<p>Perfect Keto Nut Butter is the ultimate snack for a low-carb or ketogenic lifestyle. It’s packed with raw macadamia nuts, cashews, coconut butter and MCT oil, plus real vanilla beans you can actually see (just look at the bottom of the jar). It’s so good you’ll want to eat it straight from the jar. And with nothing but clean ingredients, you can. Enjoy it by the spoonful (no judgement here) or in your favorite keto recipe. Hint: it’s amazing on top of a Keto Bar (all three flavors).
<br>
Perfect Keto Nut Butter is the ultimate snack for a low-carb or ketogenic lifestyle. It’s packed with raw macadamia nuts, cashews, coconut butter and MCT oil, plus real vanilla beans you can actually see (just look at the bottom of the jar). It’s so good you’ll want to eat it straight from the jar. And with nothing but clean ingredients, you can. Enjoy it by the spoonful (no judgement here) or in your favorite keto recipe. Hint: it’s amazing on top of a Keto Bar (all three flavors).</p>
 			</div>
	 			</div>
	 			
	 			<div class="col-md-6">
	 			<div class="section-head">
			<div class="section__heading">
			<h2>Specifications</h2>
			</div>
		</div>
	 				<div class="cms product-specifications border rounded p-4" data-simplebar> 
	 				<table>
										<tbody>
																						<tr>
												<th>Neck Type :</th>
												<td>Round Neck</td>
											</tr>
																						<tr>
												<th>Ideal For :</th>
												<td>Women's</td>
											</tr>
																						<tr>
												<th>Pattern :</th>
												<td>Solid, Striped</td>
											</tr>
																						<tr>
												<th>Sleeve :</th>
												<td>Full Sleeve</td>
											</tr>
																						<tr>
												<th>Suitable For :</th>
												<td>Western Wear</td>
											</tr>
																						<tr>
												<th>Fabric :</th>
												<td>Cotton</td>
											</tr>
																						<tr>
												<th>Sleeve Type :</th>
												<td>Narrow</td>
											</tr>
																						<tr>
												<th>Reversible :</th>
												<td>No</td>
											</tr>
																						<tr>
												<th>Brand Fit :</th>
												<td>Slim Fit</td>
											</tr>
																					</tbody>
									</table>
 			</div>
	 			</div>
	 		</div>
	 	</div>
	 </section>
	 
	 
	 <section class="section bg--first-color">
		<?php include(CONF_THEME_PATH.'products/recommended-products.php'); ?>
	 </section>
	 <?php } ?>
     <?php if($relatedProductsRs){ ?>
	 <section class="section bg--second-color">
		 <?php include(CONF_THEME_PATH.'products/related-products.php'); ?>
	 </section>
	 <?php } ?>
     <section class="section">
		<div class="container">
		<div class="section-head">
		<div class="section__heading">
			<h2>Reviews By</h2>
		</div>
	</div>
	 		
	 		
	 		<div class="tabs tabs--flat-js">
        <ul>
            <li class="is-active"><a href="javascript:void(0);" data-sort="most_helpful" onclick="getSortedReviews(this);return false;">Most Helpful</a></li>
            <li><a href="javascript:void(0);" data-sort="most_recent" onclick="getSortedReviews(this);return false;">Most Recent </a></li>
        </ul>
    </div>		  
		 <div class="row">
		 	<div class="col-md-8 mb-3 mb-md-0">    
    <div class="border rounded h-100">
        <div class="listing__all">
        <ul>
		<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/10/thumb/1" alt="Jenny"></div>
					<div class="profile__bio">
						<div class="title">By Jenny <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(1,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;1&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">4</span> </div>
					<div class="cms">
						<p><strong>Great!!</strong></p>
						<p>
							<span class="lessText">The toy was perfect - just what I was looking for. The item was very reasonably priced, they arrived in perfect condition, and earlier than promised. Importantly, the toy looked exactly like their onl</span>
														<span class="moreText" hidden="">
							The toy was perfect - just what I was looking for. The item was very reasonably priced, they arrived in perfect condition, and earlier than promised. Importantly, the toy looked exactly like their online photo and description. A hassle-free buying experience!							</span>
							<a class="readMore link--arrow" href="javascript:void(0);"> Show More </a>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
		<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/8/thumb/1" alt="مانبريت كور"></div>
					<div class="profile__bio">
						<div class="title">By مانبريت كور <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(10,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;10&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">5</span> </div>
					<div class="cms">
						<p><strong>Impressed!!</strong></p>
						<p>
							<span class="lessText">Shipping was late :(  but product was exactly the same as pictures.....fabric, color , everything was perfect.</span>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/8/thumb/1" alt="مانبريت كور"></div>
					<div class="profile__bio">
						<div class="title">By مانبريت كور <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(10,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;10&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">5</span> </div>
					<div class="cms">
						<p><strong>Impressed!!</strong></p>
						<p>
							<span class="lessText">Shipping was late :(  but product was exactly the same as pictures.....fabric, color , everything was perfect.</span>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
	</ul>
<div class="align--center"><a href="/yokartv8/reviews/product/122" class="link">Showing All 2 Reviews </a></div>
<div class="gap"></div>
	<form name="frmSearchReviewsPaging"><input type="hidden" name="selprod_id" value="122"><input type="hidden" name="page" value=""><input type="hidden" name="pageSize" value="5"><input type="hidden" name="orderBy" value="most_helpful"><input type="hidden" name="fOutMode" value="json"><input type="hidden" name="fIsAjax" value="1"></form>

</div>
        <div id="loadMoreReviewsBtnDiv" class="reviews-lisitng"></div>
    </div>	 		
		 	</div>
		 	<div class="col-md-4">  		 	
		 	<div class="border rounded h-100">
		 		<div class="shop-reviews-wrapper text-center p-4">
		<div class="shop-reviews">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#rating-star" href="/yokartv8/images/retina/sprite.svg#rating-star"></use>
			</svg>
			<div class="shop-reviews-points">4.5</div>
		</div>
		<div class="total-reviews">Based On 2 Ratings</div>
	</div>
		 	<div class="divider"></div>
		 	<div class="listing--progress-wrapper p-4">
		<ul class="listing--progress">
			<li>
				<span class="progress_count">5 Star</span>
				<div class="progress__bar">
					<div title="50% Number Of Reviews Have 5 Stars" style="width: 50%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">4 Star</span>
				<div class="progress__bar">
					<div title="50% Number Of Reviews Have 4 Stars" style="width: 50%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">3 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 3 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">2 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 2 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">1 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 1 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
		</ul>
	</div><div class="divider"></div>
	 	
	 	<div class="have-you p-4">
		<p><strong>Have You Used This Product?</strong></p>
		<div class="gap"></div>
		<a onclick="rateAndReviewProduct(47)" href="javascript:void(0)" class="btn btn--secondary ripplelink">Rate And Review Product</a>
	</div>
		 	</div>				
		 	</div>
		 </div>
	 
			 
            
             
                
            
			 <?php if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
			
            <div class="row">
            <?php foreach( $banners['Product_Detail_Page_Banner']['banners'] as $val ){
				$desktop_url = '';
				$tablet_url = '';
				$mobile_url = '';
				if( !AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId ) ){
					continue;
				}else{
					$slideArr = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId );
					foreach($slideArr as $slideScreen){
						switch($slideScreen['afile_screen']){
							case applicationConstants::SCREEN_MOBILE:
								$mobile_url = '<736:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)).",";
								break;
							case applicationConstants::SCREEN_IPAD:
								$tablet_url = ' >768:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)).",";
								break;
							case applicationConstants::SCREEN_DESKTOP:
								$desktop_url = ' >1025:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)).",";
								break;
						}
					}
				}
				?>
		 
			<?php } ?></div>
				 <?php } if(isset($val['banner_record_id']) && $val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC){
				Promotion::updateImpressionData($val['banner_record_id']);
			}
			?>
		</div>
	  </section>
	  <div id="recentlyViewedProductsDiv"></div>
</div>
<script type="text/javascript">
var mainSelprodId = <?php echo $product['selprod_id'];?>;
var layout = '<?php echo CommonHelper::getLayoutDirection();?>';

$("document").ready(function(){
	recentlyViewedProducts(<?php echo $product['selprod_id'];?>);
	zheight = $( window ).height() - 180;
	zwidth = $( window ).width()/2 - 50;

	if(layout == 'rtl'){
		$('.xzoom, .xzoom-gallery').xzoom({zoomWidth: zwidth, zoomHeight: zheight, title: true, tint: '#333',  position:'left'});
	}else{
		$('.xzoom, .xzoom-gallery').xzoom({zoomWidth: zwidth, zoomHeight: zheight, title: true, tint: '#333', Xoffset: 	2});
	}

	window.setInterval(function(){
		var scrollPos = $(window).scrollTop();
		if(scrollPos > 0){
		  setProductWeightage('<?php echo $product['selprod_code']; ?>');
		}
	}, 5000);
});

  <?php /* if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
$(function () {
	 if($(window).width()>1050){
            $(window).scroll(sticky_relocate);
				sticky_relocate();
			 }
        });
 <?php } */ ?>
</script>
<script>
	$(document).ready(function(){
		$("#btnAddToCart").addClass("quickView");
		$('#slider-for').slick( getSlickGallerySettings(false,'<?php echo CommonHelper::getLayoutDirection();?>') );
		$('#slider-nav').slick( getSlickGallerySettings(true,'<?php echo CommonHelper::getLayoutDirection();?>') );
		/* for toggling of tab/list view[ */
		$('.list-js').hide();
		$('.view--link-js').on('click',function(e) {
			$('.view--link-js').removeClass("btn--active");
			$(this).addClass("btn--active");
			if ($(this).hasClass('list')) {
				$('.tab-js').hide();
				$('.list-js').show();
			}
			else if($(this).hasClass('tab')) {
				$('.list-js').hide();
				$('.tab-js').show();
			}
		});
		/* ] */
		
		$('.social-toggle').on('click', function() {
		   setTimeout(function(){ $(this).next().toggleClass('open-menu'); }, 100);
		});
		
		


	});
</script>
<!--Here is the facebook OG for this product  -->
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
