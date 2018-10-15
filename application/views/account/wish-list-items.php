<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="section section--items dashboard--items">
	<div class="section__head">
		<h5><?php echo $wishListRow['uwlist_title']; ?><input type="hidden" name="uwlist_id" value="<?php echo $wishListRow['uwlist_id']; ?>" /></h5>
		<a class="btn btn--primary btn--sm btn--positioned" onClick="searchWishList();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Back', $siteLangId); ?></a>
	</div>
	
	<div id="wishListItems" class="row">
	</div>
</div>

<div id="loadMoreBtnDiv"></div>
<!--<a href="javascript:void(0)" onClick="goToWishListItemSearchPage(2);" class="loadmore loadmore--gray text--uppercase">Load More</a>-->

<script type="text/javascript">
$("document").ready( function(){
	searchWishListItems(<?php echo $wishListRow['uwlist_id']; ?>);
});
</script>
