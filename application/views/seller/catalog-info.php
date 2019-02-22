<div class="white--bg padding20">
  <div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12 clearfix">
	  <div id="img-static" class="product-gallery">
			<img src="<?php echo CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, 0, $siteLangId ) ) ?>">
	  </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
	  <div class="product-detail">
		<div class="item-yk detail_head">
			<div class="item-yk-head">
				<div class="item-yk-head-category"><?php echo $product['prodcat_name']; ?></div>
				<div class="item-yk-head-title">
					<?php echo $product['product_name']; ?>
				</div>
				<div class="heading5"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?>: <?php echo ($product['brand_name']) ? $product['brand_name'] : Labels::getLabel('LBL_NA', $siteLangId); ?></div>
				<div class="heading5"><?php echo Labels::getLabel('LBL_Product_Model', $siteLangId); ?>: <?php echo $product['product_model']; ?></div>
				<!-- <div class="product_price"> $5.00 </div> -->
			</div>
			<div class="gap"></div>
			<div class="divider"></div>
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
			</ul>
		  </div>
		  <?php } ?>
		</div>
	</div>
  </div>
 </div>
</div>
