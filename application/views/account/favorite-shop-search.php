<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php 
if($shops){
foreach( $shops as $shop ){
	$shopUrl = CommonHelper::generateUrl( 'Shops', 'View', array($shop['shop_id']) );
?>
<div class="rowrepeated">
	<div class="row">
		<div class="col-md-5 col-sm-5">
			<h5><a href="<?php echo $shopUrl; ?>"><?php echo $shop['shop_name'];?></a></h5>
			<span class="text--small"><?php echo Labels::getLabel('LBL_Shop_created_by',$siteLangId); ?></span>
			<p><strong><?php echo $shop['shop_owner_name']; ?></strong></p>

			<a href="javascript:void(0);" onclick="toggleShopFavorite2(<?php echo $shop['shop_id']; ?>)" class="link--normal"><?php echo Labels::getLabel('LBL_Unfavorite_to_Shop', $siteLangId); ?> <i class="fa fa-heart"></i></a>
		</div>
		<div class="col-md-7 col-sm-7">
			<div class="scroller--items align--right">
				<ul class="listing--items">
					<?php if($shop['products']){
						foreach($shop['products'] as $product){
						$productUrl = CommonHelper::generateUrl('Products','View',array( $product['selprod_id'] ));
					?>
					<li><a href="<?php echo $productUrl; ?>" class="item__pic"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId ),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $product['product_name'];?>" alt="<?php echo $product['product_name']; ?>"></a></li>
					<?php } } ?>
					
					<?php if( $shop['totalProducts'] <= $totalProductsToShow ){ ?>
					<li><a href="javascript:void(0);" class="item__link"><span><?php echo Labels::getLabel('LBL_No_More_Products', $siteLangId); ?></span></a></li>
					<?php } else { ?>
					<li><a href="<?php echo $shopUrl; ?>" class="item__link"><span><?php echo str_replace('{n}', $shop['totalProducts'], Labels::getLabel('LBL_View_{n}_item(s)', $siteLangId)); ?></span></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php } 
} else {
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} ?>