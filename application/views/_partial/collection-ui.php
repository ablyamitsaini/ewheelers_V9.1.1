<?php
$forPage = !empty( $forPage ) ? $forPage : '';

$staticCollectionClass='';
if($controllerName='Products' && isset($action) && $action=='view'){
    $staticCollectionClass='static--collection';
} ?>
<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; ?>
<?php if($showAddToFavorite) { ?>
    <div class="<?php echo $staticCollectionClass;?>">
    <?php if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){ ?>
        <?php if ( Labels::getLabel('LBL_Wishlist', $siteLangId) ==  $forPage ) { ?>
                <span class="float-left itemValue--js">
                    <label class="checkbox">
                        <input type="checkbox" name='selprod_id[]' class="selectItem--js" value="<?php echo $product['selprod_id']; ?>"/>
                        <i class="input-helper"></i>
                    </label>
                </span>
                <a class="btn btn--primary btn--sm" onClick="addToCart( $(this), event );" href="javascript:void(0)" data-id='<?php echo $product['selprod_id']; ?>'>
                    <i class="icn"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#add-cart" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#add-cart"></use></svg></i><?php echo Labels::getLabel('LBL_Cart', $siteLangId); ?>
                </a>
                <span class="float-right">
					<a title="Delete" onclick="removeFromWishlist(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event);" href="javascript:void(0)" class="text--normal-secondary">
						<i class="fa fa-times"></i>
					</a>
				</span>
        <?php }else{ ?>
            <div class="favourite heart-wrapper <?php echo($product['ufp_id'])?'is-active':'';?>" data-id="<?php echo $product['selprod_id']; ?>">
            	<a href="javascript:void(0)" title='<?php echo($product['ufp_id'])? Labels::getLabel('LBL_Remove_product_from_favourite_list',$siteLangId) : Labels::getLabel('LBL_Add_Product_to_favourite_list',$siteLangId); ?>'>
            		<div class="ring"></div>
            		<div class="circles"></div>
            	</a>
            </div>
        <?php } ?>
    <?php } else { ?>
                <?php if ( Labels::getLabel('LBL_Wishlist', $siteLangId) ==  $forPage ) { ?>
                        <span class="float-left itemValue--js">
                            <label class="checkbox">
                                <input type="checkbox" name='selprod_id[]' class="selectItem--js" value="<?php echo $product['selprod_id']; ?>"/>
                                <i class="input-helper"></i>
                            </label>
                        </span>
                        <a title='<?php echo Labels::getLabel('LBL_Add_to_cart', $siteLangId); ?>' class="btn btn--primary btn--sm" onClick="addToCart( $(this), event );" href="javascript:void(0)" data-id='<?php echo $product['selprod_id']; ?>'>
                            <i class="icn"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#add-cart" href="/images/retina/sprite.svg#add-cart"></use></svg></i>
                        </a>
                        <span class="float-right">
        					<a title="Delete" onclick="removeFromWishlist(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event);" href="javascript:void(0)" class="text--normal-secondary">
        						<i class="fa fa-times"></i>
        					</a>
        				</span>
                <?php }else{ ?>
                        <div class="favourite heart-wrapper wishListLink-Js <?php echo($product['is_in_any_wishlist'])?'is-active':'';?>"  id="listDisplayDiv_<?php echo $product['selprod_id']; ?>" data-id ="<?php echo $product['selprod_id']; ?>">
                        	<a href="javascript:void(0)" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);" title="<?php echo($product['is_in_any_wishlist'])? Labels::getLabel('LBL_Remove_product_from_your_wishlist',$siteLangId) : Labels::getLabel('LBL_Add_Product_to_your_wishlist',$siteLangId); ?>">
                        		<div class="ring"></div>
                        		<div class="circles"></div>
                        	</a>
                        </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>
<?php if($controllerName='Products' && isset($action) && $action=='view'){?>


 <?php }?>
<?php /* if(!$staticCollectionClass && (!isset($quickDetailIcon))){ ?>
<div class="quickview hide--mobile">
	<a name="<?php echo $controllerName;?>" onClick='quickDetail(<?php echo $product['selprod_id']; ?>)' class="modaal-inline-content"><?php echo Labels::getLabel('LBL_Quick_View', $siteLangId);?>
	</a>
</div>
<?php } */ ?>
