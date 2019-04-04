<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset( $collections ) && count($collections) ){
	
	$counter = 1;
	
	foreach( $collections as $collection_id => $row ){ ?>
<?php if( isset($row['products']) && count($row['products']) ) { ?>
<?php echo ($row['collection_name'] != '') ? '  <div class="unique-heading">' . $row['collection_name'] .'</div>' : ''; ?>
<?php /* echo ($row['collection_description'] != '') ? '<p>' . nl2br($row['collection_description']) . '</p>' : '';  */?>

<div class="fetured-slider <?php echo (count($row['products'])!=1)?'featured-item-js':''; ?>" dir="<?php echo CommonHelper::getLayoutDirection();?>">
  <?php foreach( $row['products'] as $product ){ ?>
  <div class="fetured-item">
    <div class="item-yk <?php if($product['selprod_stock']<=0){ ?> item--sold  <?php } ?>">
      <div class="featured-product">
        <div class="item__body">
		  <?php if($product['selprod_stock']<=0){ ?>
          <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></span>
          <?php  } ?>
          <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "CLAYOUT2", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg') ?>" alt="<?php echo $product['selprod_title']; ?>"> </a></div>
          <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
        </div>
      </div>
      <div class="featured-desc">
        <?php include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
        <div class="item__footer">
          <?php include(CONF_THEME_PATH.'_partial/collection-product-price.php');?>
          <a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_SHOP_NOW',$siteLangId);?></a> </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php if( count($row['products']) > Collections::COLLECTION_LAYOUT2_LIMIT ){ ?>
<div class="section_action cta"> <a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--secondary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a> </div>
<?php }  ?>
<?php } ?>
<script>
	var singleFeaturedProduct = <?php echo count($row['products']); ?>;
</script>
<?php $counter++; } 
} ?>
