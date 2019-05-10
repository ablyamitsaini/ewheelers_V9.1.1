<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="cards-header pb-3">
    <h5 class="cards-title">
        <?php echo $wishListRow['uwlist_title']; ?>
        <input type="hidden" name="uwlist_id" value="<?php echo $wishListRow['uwlist_id']; ?>" />
    </h5>
    <div class="action">
        <label class="checkbox">
            <input type="checkbox" class='selectAll-js' onclick="selectAll($(this));"><i class="input-helper"></i>Select all
        </label>
        <a class="btn btn--primary btn--sm" onclick="viewWishList(0,this,event);" href="javascript:void(0)">
            <i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-wishlist-favorite" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-wishlist-favorite"></use></svg>
            </i><?php echo Labels::getLabel('LBL_Move', $siteLangId); ?>
        </a>
        <a class="btn btn--primary btn--sm" onClick="addSelectedToCart(event);" href="javascript:void(0)">
            <i class="icn"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#add-cart" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#add-cart"></use></svg></i><?php echo Labels::getLabel('LBL_Cart', $siteLangId); ?>
        </a>
        <a class="btn btn--primary btn--sm" onClick="removeSelectedFromWishlist( <?php echo $wishListRow['uwlist_id']; ?>, event );" href="javascript:void(0)">
            <i class="fa fa-times"></i>&nbsp;&nbsp;<?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>
        </a>
        <a class="btn btn--primary btn--sm" onClick="searchWishList();" href="javascript:void(0)">
            <?php echo Labels::getLabel('LBL_Back', $siteLangId); ?>
        </a>
    </div>
</div>
<form method="post" name="wishlistForm" id="wishlistForm" >
    <input type="hidden" name="uwlist_id" value="<?php echo $wishListRow['uwlist_id']; ?>" />
    <div id="wishListItems" class="row"></div>
</form>

<div id="loadMoreBtnDiv"></div>
<!--<a href="javascript:void(0)" onClick="goToWishListItemSearchPage(2);" class="loadmore loadmore--gray text--uppercase">Load More</a>-->

<script type="text/javascript">
$("document").ready( function(){
	searchWishListItems(<?php echo $wishListRow['uwlist_id']; ?>);
});
</script>
