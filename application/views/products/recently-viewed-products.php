<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if($recentViewedProducts){ ?>

<div id="recently-viewed" class="more-slider carousel carousel--onefourth slides--six-js" dir="<?php echo CommonHelper::getLayoutDirection();?>">
  <?php foreach($recentViewedProducts as $product){ 
		$productUrl = CommonHelper::generateUrl('Products','View',array($product['selprod_id']));
	?>
  <div class="more_slider_item">
    <div class="item-yk">
      <?php include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
      <div class="item-yk_body">
        <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $product['selprod_title'];?>"> </a></div>
        <?php $this->includeTemplate('_partial/collection-ui.php',array('product'=>$product,'siteLangId'=>$siteLangId),false);?>
      </div>
      <div class="item-yk_footer">
        <?php $this->includeTemplate('_partial/collection-product-price.php',array('product'=>$product,'siteLangId'=>$siteLangId),false);?>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php } ?>
</div>
