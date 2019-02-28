<a href="javascript:void(0)" id="close-quick-js" class="close-layer"></a>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12 quick-col-1">
	  <?php if( $productImagesArr ){ ?>
		<div class="js-product-gallery product-gallery" dir="<?php echo CommonHelper::getLayoutDirection();?>">
			<?php
				foreach( $productImagesArr as $afile_id => $image ){
				$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
				$thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
				?>
			<div class=""><?php if(isset($imageGallery) && $imageGallery){ ?>
			  <a href="<?php echo $mainImgUrl; ?>"  class="gallery" rel="gallery">
			  <?php } ?>
			  <img src="<?php echo $mainImgUrl;	 ?>">
			  <?php if(isset($imageGallery) && $imageGallery){ ?>
			  </a>
			  <?php }?></div>
			<?php }?>
		</div>
		<?php } else { 
				$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg'); ?>
			  <div class="item__main"><img src="<?php echo $mainImgUrl; ?>"></div>
			  <?php } ?>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12 quick-col-2">
	  <div class="product-detail product-description">
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
			<div class="products__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>  <?php if($product['special_price_found']){ ?>
			<span class="products__price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span> <span class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span><?php } ?>
			</div>
		</div>
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
	  
		<div class="gap"></div>
		  <!-- Add To Cart [ -->
		  <?php if( $product['in_stock'] ){
				echo $frmBuyProduct->getFormTag();
				$qtyField =  $frmBuyProduct->getField('quantity');
				/* $fld = $frmBuyProduct->getField('btnAddToCart');
				$fld->addFieldTagAttribute('class','quickView'); */
				$qtyFieldName =  $qtyField->getCaption(); ?>
		  <div class="form__group">
			<label><?php echo $qtyFieldName;?></label>
			<?php if(strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){ ?>
			<div class="qty"> <span class="decrease decrease-js">-</span>
			  <?php
			  echo $frmBuyProduct->getFieldHtml('quantity'); ?>
			  <span class="increase increase-js">+</span></div>
			<?php }?>
		  </div>
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
	</div>
</div>
<script>
	$(document).ready(function(){
		var layoutDirection = '<?php echo CommonHelper::getLayoutDirection();?>';
		if(layoutDirection == 'rtl'){
			$('.js-product-gallery').slick({
				dots: true,
				arrows: true,
				autoplay: false,
				pauseOnHover: false,
				slidesToShow: 1,
				rtl:true,
			});
		}else{
			$('.js-product-gallery').slick({
				dots: true,
				arrows: true,
				autoplay: false,
				pauseOnHover: false,
				slidesToShow: 1,
			});
		}
		
		$('#close-quick-js').click(function () {
			if ($('html').removeClass('quick-view--open')) {
				$('.quick-view').removeClass('quick-view--open');
			}
		});
		
		/* $('#close-quick-js').click(function () {
			if ($('html').removeClass('quick-view--open')) {
				$(document).trigger('close.facebox');
				$('.quick-view').removeClass('quick-view--open');
			}
		}); */
		/* $('#quickView-slider-for').slick( getSlickGallerySettings(false,'<?php echo CommonHelper::getLayoutDirection();?>') );
		$('#quickView-slider-nav').slick( getSlickGallerySettings(true,'<?php echo CommonHelper::getLayoutDirection();?>') ); */
	});
	
	

</script>
