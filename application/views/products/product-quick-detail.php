<div class="white--bg padding20">
  <div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12 clearfix">
	  <div id="img-static"  class="">
		<div class="product-gallery">
		  <?php $data['product'] = $product;
			$data['productImagesArr'] = $productImagesArr; 

			$this->includeTemplate('products/product-gallery.php',$data,false);
			//CommonHelper::printArray($product); die;
			?>
		</div>
	  </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
	  <div class="product-detail">
		<div class="item-yk detail_head ">
		  <?php $firstToReview=true; include(CONF_THEME_PATH.'_partial/product-listing-head-section.php'); ?>
		  <?php $quickDetailIcon=false; include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
		  <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>
			<?php if($product['special_price_found']){ ?>
			<span class="product_price_old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
			<div class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></div>
			<?php } ?>
		  </div>
		  <?php if( count($productSpecifications)>0 ){ ?>
		  <div class="gap"></div>
		  <div class="heading5"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?>:</div>
		  <div class="bullet-list">
			<ul>
			  <?php $count=1; 
					foreach($productSpecifications as $key => $specification){
						if($count>5) continue;
						?>
			  <li><?php echo $specification['prodspec_name']." : ".$specification['prodspec_value']; ?></li>
			  <?php $count++;  } ?>
			  <?php if(count($productSpecifications)>5) { ?>
			  <li class="link_li"><a href="<?php echo CommonHelper::generateUrl('Products','view',array($product['selprod_id'])); ?>"  ><?php echo Labels::getLabel('LBL_View_All_Details', $siteLangId); ?></a></li>
			  <?php } ?>
			</ul>
		  </div>
		  <?php } ?>
		  <div class="divider"></div>
		  <?php if( !empty($optionRows) ){
			
			$selectedOptionsArr = $product['selectedOptionValues'];	
			/* CommonHelper::printArray($selectedOptionsArr);die(); */
			foreach($optionRows as $option){ ?>
		  <div class="heading5"><?php echo $option['option_name']; ?>:</div>
		  <div class="<?php echo ($option['option_is_color']) ? 'select-color' : 'select-size'; ?>">
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
				<?php if(in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) {?>
			  <li class="is--active">
				<?php   if($option['option_is_color'] && $opVal['optionvalue_color_code'] != '' ){ ?>
				<a title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" href="javascript:void(0)"> <span style="background-color:#<?php echo $opVal['optionvalue_color_code']; ?>;"></span></a>
				<?php   } else{ ?>
				<a title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" href="javascript:void(0)"> <?php echo $opVal['optionvalue_name'];  ?> </a>
				<?php } ?>
			  </li>
			  <?php } ?>
			  <?php } ?>
			</ul>
			<?php } ?>
		  </div>
		  <?php } 
		}	 ?>
		</div>
		<div class="gap"></div>
		<div class="">
		  
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
  </div>
</div>
<script>
	$(document).ready(function(){
		$("#btnAddToCart").addClass("quickView");
		$('#quickView-slider-for').slick( getSlickGallerySettings(false) );
		$('#quickView-slider-nav').slick( getSlickGallerySettings(true) );
	});
</script>
