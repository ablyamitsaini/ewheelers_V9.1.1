<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset($products) && count($products) ) { ?>
<section class="section">
	<div class="container">
		<div class="section-head">
			<div class="section__heading">
				<h2><?php echo FatApp::getConfig('CONF_PPC_PRODUCTS_HOME_PAGE_CAPTION_'.$siteLangId,FatUtility::VAR_STRING,Labels::getLabel('LBL_SPONSORED_PRODUCTS',$siteLangId)); ?></h2>
			</div>
		</div>
		<div class="row trending-corner" dir="<?php echo CommonHelper::getLayoutDirection();?>">
			<?php foreach( $products as $product ){ ?>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<?php include('product-layout-1-list.php'); Promotion::updateImpressionData($product['promotion_id']);?>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>
