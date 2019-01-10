<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset($products) && count($products) ) { ?>
<section class="padd40">
  <div class="container">
    <div class="section-head"> <div class="section_heading"><?php echo FatApp::getConfig('CONF_PPC_PRODUCTS_HOME_PAGE_CAPTION_'.$siteLangId,FatUtility::VAR_STRING,Labels::getLabel('LBL_SPONSORED_PRODUCTS',$siteLangId)); ?></div>

    </div>
    <div class="shops">
      <div class="trending-corner" dir="<?php echo CommonHelper::getLayoutDirection();?>">
        <?php foreach( $products as $product ){
			include('collection-1-products-list.php');

			Promotion::updateImpressionData($product['promotion_id']);
		} ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>
