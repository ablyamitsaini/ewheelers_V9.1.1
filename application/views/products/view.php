<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class','qty productQty-js');
?>

<div id="body" class="body" role="main">
<section>
  <div class="container">
    <!-- <div class="breadcrumbs">
      <?php /* $this->includeTemplate('_partial/custom/header-breadcrumb.php'); */ ?>
    </div> -->
      <div class="row">
        <div class="col-lg-6">
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
				<div class="gap"></div>

          </div>
        </div>
        <div class="col-lg-6">
			<div class="product-description">
				<div class="product-description-inner">
					<div class="products__title"><?php echo $product['selprod_title'];?>
					</div>
					<div class="detail-grouping">
						<div class="products__category"><a href="<?php echo CommonHelper::generateUrl('Category','View',array($product['prodcat_id']));?>"><?php echo $product['prodcat_name'];?> </a></div>
						<div class="products__rating">
						<?php if(round($product['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?>
						<i class="icn"><svg class="svg">
									<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
								</svg></i> <span class="rate"><?php echo round($product['prod_rating'],1);?></span>
								<?php if(round($product['prod_rating'])==0 ){  ?>
								  <span class="be-first"> <a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span>
								<?php } ?>
						<?php }?>
						</div>
						<?php include(CONF_THEME_PATH.'_partial/collection-ui.php'); ?>
					</div>
                    <div class="share-this">
                            <span><i class="icn share"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"></use>
                                    </svg></i><?php echo Labels::getLabel('LBL_Share',$siteLangId); ?></span>
                            <a class="social-link st-custom-button" data-network="facebook">
                                <i class="icn"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"></use>
                                    </svg></i>
                            </a>
                            <a class="social-link st-custom-button" data-network="twitter">
                                <i class="icn"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"></use>
                                    </svg></i>
                            </a>
                            <a class="social-link st-custom-button" data-network="pinterest">
                                <i class="icn"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"></use>
                                    </svg></i>
                            </a>
                            <a class="social-link st-custom-button" data-network="email">
                                <i class="icn"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"></use>
                                    </svg></i>
                            </a>
                    </div>
					<?php /* include(CONF_THEME_PATH.'_partial/product-listing-head-section.php'); */ ?>
				</div>
				<div class="products__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>  <?php if($product['special_price_found']){ ?>
				<span class="products__price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span> <span class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span><?php } ?>
				</div>
        

			<?php  if($shop['shop_free_ship_upto'] > 0 && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']){ ?>
            <div class="gap"> </div>
					<?php $freeShipAmt = CommonHelper::displayMoneyFormat($shop['shop_free_ship_upto']);
				?>
				<div class="note-messages"><?php echo str_replace('{amount}',$freeShipAmt,Labels::getLabel('LBL_Free_shipping_up_to_{amount}_purchase',$siteLangId));?></div>
			<?php }?>
			<?php if( count($productSpecifications)>0 ){ ?>
			<div class="gap"></div>
			<div class="box box--gray box--radius box--space">
				<div class="h6"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?>:</div>
				<div class="list list--specification">
					<ul>
					  <?php $count=1;
						foreach($productSpecifications as $key => $specification){
							if($count>5) continue;
							?>
					  <li><?php echo '<span>'.$specification['prodspec_name']." :</span> ".$specification['prodspec_value']; ?></li>
					  <?php $count++;  } ?>
					  <?php if(count($productSpecifications)>5) { ?>
					  <li class="link_li"><a href="javascript:void()"  ><?php echo Labels::getLabel('LBL_View_All_Details', $siteLangId); ?></a></li>
					  <?php } ?>
					</ul>
				</div>
			</div>
			<?php }?>
			<?php if( !empty($optionRows) ){ ?>
			<div class="gap"></div>
			<div class="box box--gray box--radius box--space">
				<div class="row">

					<?php $selectedOptionsArr = $product['selectedOptionValues'];

					foreach($optionRows as $option){ ?>
					<div class="<?php echo ($option['option_is_color']) ? 'col-lg-12 col-md-5 column' : 'col-md-6 column'; ?>">
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

			<?php include(CONF_THEME_PATH.'_partial/product/shipping-rates.php');?>
              <?php if($codEnabled){?>
              <div class="condition-txt"><?php echo Labels::getLabel('LBL_Cash_on_delivery_is_available',$siteLangId);?> <i class="fa fa-question-circle-o tooltip tooltip--right"><span class="hovertxt"><?php echo Labels::getLabel('MSG_Cash_on_delivery_available._Choose_from_payment_options',$siteLangId);?> </span></i> </div>
              <?php }?>


			<!-- Upsell Products [ -->
            <?php if (count($upsellProducts)>0) { ?>
                <div class="gap"></div>
                <div class="box box--gray box--radius box--space">
                    <div class="h6 js-acc-triger acc-triger"><?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?></div>
                    <div class=" acc-data">
                        <table class="table cart--full cart-tbl cart-tbl-addons">
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
                          <td class="<?php echo $cancelClass;?>"><div class="qty qty--border qty--cart" data-stock="<?php echo $usproduct['selprod_stock']; ?>"> <span class="decrease decrease-js">-</span>
                              <input type="text" value="1" placeholder="Qty" class="no--focus cartQtyTextBox productQty-js" lang="addons[<?php echo $usproduct['selprod_id']?>]"   name="addons[<?php echo $usproduct['selprod_id']?>]">
                              <span class="increase increase-js">+</span> </div></td>
                          <td class="<?php echo $cancelClass;?>"><label class="checkbox">
                              <input <?php if($usproduct['selprod_stock']>0){ ?>checked="checked" <?php } ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass;?>" id="check_addons" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId);?>">
                              <i class="input-helper"></i> </label>
                            </td>
                        </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            <?php } ?>
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
              <div class="form__group">
                <label><?php echo $qtyFieldName;?></label>
                <div class="qty" data-stock="<?php echo $product['selprod_stock']; ?>"> <span class="decrease decrease-js">-</span>
                  <?php
				  echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                  <span class="increase increase-js">+</span></div>
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
              <?php echo $frmBuyProduct->getExternalJs();
					} else { ?>
              <div class="sold">
                <h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Sold_Out',$siteLangId); ?></h3>
                <p class="text--normal-secondary"><?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?></p>
              </div>
              <?php } ?>
			  <?php if(strtotime($product['selprod_available_from'])> strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){?>
				<div class="sold">
					<h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Not_Available',$siteLangId); ?></h3>
					<p class="text--normal-secondary"><?php echo str_replace('{available-date}',FatDate::Format($product['selprod_available_from']),Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?></p>
				  </div>
			  <?php }?>
              <!-- ] -->

            </div>

			<div class="gap"></div>
			<div class="shops-detail-wrapper">
				<div class="row align-items-center">
					<div class="col-md-8 col-sm-12 col-xs-12">
						<div class="shop-owner-detail">
							<div class="owner_logo"><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id']));?>" title="<?php echo $shop['shop_name'];?>" ><img src="<?php echo CommonHelper::generateUrl('image','shopLogo', array($shop['shop_id'], "SMALL",$siteLangId),CONF_WEBROOT_URL); ?>" alt="<?php echo $shop['shop_name'];?>"></a></div>
							<div class="owener_info">
								<div class="owener_info_mame"><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id']));?>" title="<?php echo $shop['shop_name'];?>" ><?php echo $shop['shop_name'];?></a></div>
								<div class="owener_info_location"><?php echo ( $shop['shop_city'])? $shop['shop_city'].',':'';?> <?php echo $shop['shop_state_name'];?>, <?php echo $shop['shop_country_name'];?></div>
								<?php if($shop_rating>0){ ?>
								<div class="products__rating"> <i class="icn"><svg class="svg">
											<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
										</svg></i> <span class="rate"><?php echo round($shop_rating,1); ?><span></span></span>
								</div>
								<?php }?>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					  <?php if(count($product['moreSellersArr'])>0){ ?>
					  <div class="more--seller"><a class="link"  href="<?php echo CommonHelper::generateUrl('products','sellers',array($product['selprod_id']));?>"><?php echo sprintf(Labels::getLabel('LBL_View_More_Sellers',$siteLangId),count($product['moreSellersArr']));?></a></div>
					  <?php } ?>
					  <div class="ftshops_item_head_right">
                          <!--<a href="<?php echo CommonHelper::generateUrl('shops','View',array($shop['shop_id'])); ?>" class="btn btn--primary ripplelink block-on-mobile" tabindex="0"><?php echo Labels::getLabel('LBL_View_Store',$siteLangId); ?></a>
                          <a onclick="return checkUserLoggedIn();" href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'],$product['selprod_id'])); ?>" class="btn btn--secondary ripplelink block-on-mobile" tabindex="0"><?php echo Labels::getLabel('LBL_Ask_Question',$siteLangId); ?></a>-->
                      </div>
					</div>
				</div>
			</div>
			<div class="gap"></div>
          </div>
          </div>
        </div>
      </div>
	 </section>
	 <?php if($recommendedProducts){ ?>
	 <section class="section bg--first-color">
		<?php include(CONF_THEME_PATH.'products/recommended-products.php'); ?>
	 </section>
	 <?php } ?>
     <?php if($relatedProductsRs){ ?>
	 <section class="section bg--second-color">
		 <?php include(CONF_THEME_PATH.'products/related-products.php'); ?>
	 </section>
	 <?php } ?>
     <section class="section section--gray">
		<div class="container">
			<div class="row justify-content-center product--specifications">
				<div class="col-md-12">
					<?php $youtube_embed_code=CommonHelper::parseYoutubeUrl($product["product_youtube_video"]); ?>
					<div class="row justify-content-between">
						<div class="col-md-7">
							<div id="" class="tabs tabs--flat-js tab-js">
								<ul>
									<?php if( count($productSpecifications)>0 ){?>
									<li class="is-active"><a href="#tb-1"><?php echo Labels::getLabel('LBL_Specification',$siteLangId); ?></a></li>
									<?php }?>
									<?php if( $youtube_embed_code || $product['product_description']!=''){ ?>
									<li class=""><a href="#tb-2"><?php echo Labels::getLabel('LBL_Description',$siteLangId); ?> </a></li>
									<?php }?>
									<?php if(!empty($product['selprod_warranty_policies']) || !empty($product['selprod_return_policies'])) { ?>
									<li class=""><a href="#tb-3"><?php echo Labels::getLabel('LBL_Policies',$siteLangId); ?> </a></li>
									<?php }?>
									<?php if(!empty($product['selprodComments'])) { ?>
									<li class=""><a href="#tb-4"><?php echo Labels::getLabel('LBL_Extra_comments',$siteLangId); ?> </a></li>
									<?php }?>
								</ul>
							</div>
						</div>
            <div class="col-md-5 mb-3 text-md-right d-none d-sm-none d-md-block">
							<div class="btn-group">
								<a href="javascript:void(0)" class="btn btn--sm tab btn--tab view--link-js btn--active"><i class="icn"><svg class="svg">
											<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tabs-view" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tabs-view"></use>
										</svg></i><?php echo Labels::getLabel('LBL_Tabs_View',$siteLangId); ?></a>
								<a href="javascript:void(0)" class="btn btn--sm list btn--tab view--link-js "><i class="icn"><svg class="svg">
											<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#listview" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#listview"></use>
										</svg></i><?php echo Labels::getLabel('LBL_List_View',$siteLangId); ?></a>
							</div>
						</div>
					</div>
					<div class="tab-js">
						<?php if( count($productSpecifications)>0 ){?>
						<div id="tb-1" class="tabs-content tabs-content-js" style="display: block;">
							<div class="box box--white box--radius box--space">
								<div class="cms">
									<h6><?php echo Labels::getLabel('LBL_Specification',$siteLangId); ?></h6>
									<table>
										<tbody>
											<?php foreach($productSpecifications as $key => $specification){ ?>
											<tr>
												<th><?php echo $specification['prodspec_name']." :" ;?></th>
												<td><?php echo html_entity_decode($specification['prodspec_value'],ENT_QUOTES,'utf-8') ; ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if( $youtube_embed_code || $product['product_description']!=''){ ?>
						<div id="tb-2" class="tabs-content tabs-content-js" style="display: none;">
							<div class="box box--white box--radius box--space">
								<div class="cms">
									<h6><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h6>
									<?php if($youtube_embed_code!=""):?>
									  <div class="videowrap">
										<iframe width="60%" height="300" src="//www.youtube.com/embed/<?php echo $youtube_embed_code?>" frameborder="0" allowfullscreen></iframe>
									  </div>
									  <span class="gap"></span>
									  <?php  endif;?>
									  <p><?php echo CommonHelper::renderHtml($product['product_description']);?></p>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if(!empty($product['selprod_warranty_policies']) || !empty($product['selprod_return_policies'])) { ?>
						<div id="tb-3" class="tabs-content tabs-content-js" style="display: none;">
							<div class="box box--white box--radius box--space">
								<div class="cms">
								<?php if(!empty($product['selprod_warranty_policies'])) { ?>
									<h6><?php echo Labels::getLabel('LBL_Warranty', $siteLangId); ?></h6>
									<ul class="listing--bullet">
									  <?php foreach($product['selprod_warranty_policies'] as $warranty) { ?>
									  <li><?php echo $warranty; ?></li>
									  <?php } ?>
									</ul>
								<?php }?>
								<?php if(!empty($product['selprod_return_policies'])) { ?>
									<h6><?php echo Labels::getLabel('LBL_Return_Policy', $siteLangId); ?></h6>
									<ul class="listing--bullet">
									  <?php foreach($product['selprod_return_policies'] as $policy) { ?>
									  <li><?php echo $policy; ?></li>
									  <?php } ?>
									</ul>
								<?php }?>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if(!empty($product['selprodComments'])) { ?>
						<div id="tb-4" class="tabs-content tabs-content-js" style="display: none;">
							<div class="box box--white box--radius box--space">
								<div class="cms">
									<h6><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h6>
									<p><?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?></p>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
					<div class="gap"></div>
					<div class="list-js">
					<?php if( count($productSpecifications)>0 || $youtube_embed_code || $product['product_description']!='' || !empty($product['selprod_warranty_policies']) || !empty($product['selprod_return_policies']) || !empty($product['selprodComments']) ){ ?>
						<div class="box box--white box--radius box--space">
							<div class="cms">
								<?php if( count($productSpecifications)>0 ){?>
								<h6><?php echo Labels::getLabel('LBL_Specification',$siteLangId); ?></h6>
								<table>
									<tbody>
										<?php foreach($productSpecifications as $key => $specification){ ?>
										<tr>
											<th><?php echo $specification['prodspec_name']." :" ;?></th>
											<td><?php echo html_entity_decode($specification['prodspec_value'],ENT_QUOTES,'utf-8') ; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<br>
								<?php }?>
								<?php if( $youtube_embed_code || $product['product_description']!=''){ ?>
								<h6><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h6>
								<?php if($youtube_embed_code!=""):?>
								  <div class="videowrap">
									<iframe width="60%" height="300" src="//www.youtube.com/embed/<?php echo $youtube_embed_code?>" frameborder="0" allowfullscreen></iframe>
								  </div>
								  <span class="gap"></span>
								  <?php  endif;?>
								<p><?php echo CommonHelper::renderHtml($product['product_description']);?></p>
								<br>
								<?php }?>

								<?php if(!empty($product['selprod_warranty_policies'])) { ?>
								<h6><?php echo Labels::getLabel('LBL_Warranty', $siteLangId); ?></h6>
								<ul class="listing--bullet">
								  <?php foreach($product['selprod_warranty_policies'] as $warranty) { ?>
								  <li><?php echo $warranty; ?></li>
								  <?php } ?>
								</ul>
								<br>
								<?php } ?>
								<?php if(!empty($product['selprod_return_policies'])) { ?>
								<h6><?php echo Labels::getLabel('LBL_Return_Policy', $siteLangId); ?></h6>
								<ul class="listing--bullet">
								  <?php foreach($product['selprod_return_policies'] as $policy) { ?>
								  <li><?php echo $policy; ?></li>
								  <?php } ?>
								</ul>
								<br>
								<?php }?>
								<?php if(!empty($product['selprodComments'])) { ?>
								<h6><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h6>
								<p><?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?></p>
								<?php } ?>
								<br>
							</div>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
            
            <div id="itemRatings">
                <?php if(FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)) { ?>
                <?php echo $frmReviewSearch->getFormHtml(); ?>
                <?php $this->includeTemplate('_partial/product-reviews.php',array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'product_id' => $product['product_id']),false); ?>
                <?php }?>
            </div>
                
            <div class="gap"></div>
			 <?php if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
			<div class="gap"></div>
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
			<div class="col-md-6"><div class="banner-ppc"><a href="<?php echo CommonHelper::generateUrl('Banner','url',array($val['banner_id']));?>" target="<?php echo $val['banner_target'];?>" title="<?php echo $val['banner_title'];?>" class="advertise__block"><img data-ratio="16:9 (600x338)" data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url  . $tablet_url  . $desktop_url; ?>" src="<?php echo CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'],$siteLangId,applicationConstants::SCREEN_DESKTOP));?>" alt="<?php echo $val['banner_title'];?>" class="img-responsive"></a></div></div>
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
	});
</script>
<!--Here is the facebook OG for this product  -->
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
