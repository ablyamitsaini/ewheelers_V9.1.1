<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="cards-header pb-3">
    <h5><?php echo Labels::getLabel('LBL_Products_That_I_Love',$siteLangId);?></h5>
	<a class="btn btn--primary btn--sm btn--positioned" onClick="searchWishList();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Back', $siteLangId); ?></a>
</div>
<div id="favListItems" class="row"></div>
<div id="loadMoreBtnDiv"></div>

<script type="text/javascript">
$("document").ready( function(){
	searchFavouriteListItems();
});
</script>


<?php /* <div class="section section--items dashboard--items">
	<div class="section__head">
		<h5><?php echo $wishListRow['uwlist_title']; ?><input type="hidden" name="uwlist_id" value="<?php echo $wishListRow['uwlist_id']; ?>" /></h5>
		<a class="btn btn--primary btn--sm btn--positioned" onClick="searchWishList();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Back', $siteLangId); ?></a>
	</div>
	
	<?php if($wishListRow) {
	
	?>
		<div class="col-md-3 col-sm-4">
			<div class="items ">
				<div class="items__body">
					<?php if( $wishListRow['products'] ){ ?>
					<div class="items__group clearfix">
						<div class="items__row">
							<?php foreach($wishListRow['products'] as $product) { 
								$productUrl = CommonHelper::generateUrl('Products','View',array($product['selprod_id']));
								?>
								<div class="item <?php echo (!$product['in_stock']) ? 'item--sold' : '';?>">
									<span class="overlay--collection"></span>
									<div class="item__head">
										<?php if( !$product['in_stock'] ){ ?>
										<span class="tag--soldout"><?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></span>
										<?php } ?>
									
										<a href="<?php echo $productUrl; ?>" class="item__pic"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId ),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $product['product_name'];?>" alt="<?php echo $product['product_name']; ?>"></a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<span class="item__title"><?php echo $wishlist['uwlist_title']; ?></span>
					<ul class="links--inline">
					<?php if( !isset($wishlist['uwlist_type']) || (isset($wishlist['uwlist_type']) && $wishlist['uwlist_type']!="F" )){
							$functionName = 'viewWishListItems';
						}else{
							$functionName = 'viewFavouriteItems';
						} ?>
						<li><a onClick="<?php echo $functionName;?>(<?php echo $wishlist['uwlist_id']; ?>);" href="javascript:void(0)" class="text--normal-primary"> <?php echo str_replace('{n}', $wishlist['totalProducts'], Labels::getLabel('LBL_View_{n}_items', $siteLangId)); ?> <i class="fa fa-eye"></i></a></li>
						<?php if( !isset($wishlist['uwlist_type']) || (isset($wishlist['uwlist_type']) && $wishlist['uwlist_type']!="F" )) {?>
						<li><a onclick="deleteWishList(<?php echo $wishlist['uwlist_id']; ?>);" href="javascript:void(0)" class="text--normal-secondary"> <?php echo Labels::getLabel('LBL_Delete_List', $siteLangId); ?> <i class="fa fa-times"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
<?php } ?>
</div>

<div id="loadMoreBtnDiv"></div>
<!--<a href="javascript:void(0)" onClick="goToWishListItemSearchPage(2);" class="loadmore loadmore--gray text--uppercase">Load More</a>--> */
?>

