<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
if( isset( $collections ) && count($collections) ){
$counter = 1; ?>
<?php /* CommonHelper::printArray($collections); */ ?>
<?php foreach( $collections as $collection_id => $row ){ ?>
<?php if( isset($row['products']) && count($row['products']) ) { ?>
<?php echo ($row['collection_name'] != '') ? '  <div class="unique-heading">' . $row['collection_name'] .'</div>' : ''; ?>
<?php /* echo ($row['collection_description'] != '') ? '<p>' . nl2br($row['collection_description']) . '</p>' : ''; */ ?>
<?php /* CommonHelper::printArray($row['products']); */ ?>
<div id="fashion-corner" class="more-slider fashion-corner-js" dir="<?php echo CommonHelper::getLayoutDirection();?>">
  <?php foreach( $row['products'] as $product ){ ?>
  <div class="more_slider_item">
    <div class="item-yk <?php if($product['selprod_stock']<=0){ ?> item--sold  <?php } ?>">
       <?php include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
      <div class="item-yk_body">
		<?php if($product['selprod_stock']<=0){ ?>
		<span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></span>
		<?php  } ?>
        <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $product['selprod_title'];?>"> </a></div>
        <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
      </div>
      <div class="item-yk_footer">
        <?php include(CONF_THEME_PATH.'_partial/collection-product-price.php');?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php if( count($row['products']) > Collections::COLLECTION_LAYOUT3_LIMIT ){ ?>
<div class="section_action cta"> <a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--secondary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a> </div>
<?php }  ?>
<?php } ?>
<?php $counter++; }
} ?>
