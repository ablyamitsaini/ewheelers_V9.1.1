<?php
$forPage = !empty( $forPage ) ? $forPage : '';

$staticCollectionClass='';
if($controllerName='Products' && isset($action) && $action=='view'){
$staticCollectionClass='static--collection';
 } ?>
<?php if(!isset($showAddToFavorite)) { $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; }?>
<?php if($showAddToFavorite) { ?>
<div class="favourite-wrapper <?php echo $staticCollectionClass;?>">
<?php if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){ ?>
<div class="favourite heart-wrapper <?php echo($product['ufp_id'])?'is-active':'';?>" data-id="<?php echo $product['selprod_id']; ?>">
	<a href="javascript:void(0)" <?php echo($product['ufp_id'])? Labels::getLabel('LBL_Remove_product_from_favourite_list',$siteLangId) : Labels::getLabel('LBL_Add_Product_to_favourite_list',$siteLangId); ?>>
		<div class="ring"></div>
		<div class="circles"></div>
	</a>
</div>
<?php } else { ?>
<div class="favourite heart-wrapper wishListLink-Js <?php echo($product['is_in_any_wishlist'])?'is-active':'';?>"  id="listDisplayDiv_<?php echo $product['selprod_id']; ?>" data-id ="<?php echo $product['selprod_id']; ?>">
	<a href="javascript:void(0)" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);" title="<?php echo($product['is_in_any_wishlist'])? Labels::getLabel('LBL_Remove_product_from_your_wishlist',$siteLangId) : Labels::getLabel('LBL_Add_Product_to_your_wishlist',$siteLangId); ?>">
		<div class="ring"></div>
		<div class="circles"></div>
	</a>
</div>
<?php } ?>

 <?php if(isset($productView) && true == $productView){ ?>
<div class="share-button">
						  <a href="#" class="social-toggle"><i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#share" href="/yokartv8/images/retina/sprite.svg#share"></use>
			</svg>
		</i></a>
						<div class="social-networks">
						  <ul>
							<li class="social-twitter">
							  <a href="https://www.twitter.com">T</a>
							</li>
							<li class="social-facebook">
							<a href="https://www.facebook.com">F</a>
							</li>
							<li class="social-gplus">
							<a href="http://www.gplus.com">G+</a>
							</li>
						  </ul>
						</div>
						   </div>
<?php } ?>

</div>
<?php }?>
<?php if($controllerName='Products' && isset($action) && $action=='view'){?>


 <?php }?>
<?php /* if(!$staticCollectionClass && (!isset($quickDetailIcon))){ ?>
<div class="quickview hide--mobile">
	<a name="<?php echo $controllerName;?>" onClick='quickDetail(<?php echo $product['selprod_id']; ?>)' class="modaal-inline-content"><?php echo Labels::getLabel('LBL_Quick_View', $siteLangId);?>
	</a>
</div>
<?php } */ ?>
