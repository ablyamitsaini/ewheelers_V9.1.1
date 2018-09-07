
<div class="col-lg-3 col-md-3 col-xs-6 ">
  <div class="item-yk <?php if($product['selprod_stock']<=0){ ?> item--sold  <?php } ?>">
	<?php $selprod_condition=true; include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
	<div class="item-yk_body">
	  <?php if($product['selprod_stock']<=0){ ?>
	  <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></span>
	  <?php  } ?>
	  <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo !isset($product['promotion_id'])?CommonHelper::generateUrl('Products','View',array($product['selprod_id'])):CommonHelper::generateUrl('Products','track',array($product['promotion_record_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $product['prodcat_name'];?>"> </a></div>
	  <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>

	</div>
	<div class="item-yk_footer">
	  <?php include(CONF_THEME_PATH.'_partial/collection-product-price.php');?>
	</div>
  </div>
</div>
