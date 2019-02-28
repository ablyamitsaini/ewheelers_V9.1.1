	<div class="products__title"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><?php echo $product['selprod_title'];?> </a>
	</div>
	<div class="detail-grouping">
		<div class="products__category"><a href="<?php echo CommonHelper::generateUrl('Category','View',array($product['prodcat_id']));?>"><?php echo $product['prodcat_name'];?> </a></div>
		<div class="products__rating">
		<?php if(round($product['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?>
		<i class="icn"><svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="images/retina/sprite.svg#star-yellow"></use>
				</svg></i> <span class="rate"><?php echo round($product['prod_rating'],1);?></span>
				<?php if(isset($firstToReview) && $firstToReview){ ?>
				  <?php if(round($product['prod_rating'])==0 ){  ?>
				  <span class="be-first"> <a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span>
				  <?php } ?>
			  <?php }?>
		<?php }?>
		</div>
	</div>