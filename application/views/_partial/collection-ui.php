<?php 
$staticCollectionClass='';
if($controllerName='Products' && isset($action) && $action=='view'){
$staticCollectionClass='static--collection';
 } ?>
<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; ?>
<?php if($showAddToFavorite) { ?>
<div class="collections-ui <?php echo $staticCollectionClass;?> "> 
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
 <?php if($controllerName='Products' && isset($action) && $action=='view'){?>
	<div class="share-this">
		<a href="javascript:void(0)" class="ripplelink social-toggle" title="<?php echo Labels::getLabel('LBL_Share_this_product',$siteLangId); ?>"></a>
		<div class="social-networks">
			<ul class="list__socials">
			  <li><?php echo Labels::getLabel('LBL_Share_On',$siteLangId); ?></li>
			  <li class="social--fb"><a class='st_facebook_large' displayText='Facebook'></a></li>
			  <li class="social--tw"><a class='st_twitter_large' displayText='Tweet'></a></li>
			  <li class="social--pt"><a class='st_pinterest_large' displayText='Pinterest'></a></li>
			  <li class="social--mail"><a class='st_email_large' displayText='Email'></a></li>
			  <li class="social--wa"><a class='st_whatsapp_large' displayText='Whatsapp'></a></li>
			</ul>
		</div>
	</div>
  <?php }?>
</div>
<?php }?>
<?php if(!$staticCollectionClass && (!isset($quickDetailIcon))){ ?>
<div class="quickview hide--mobile">
	<a name="<?php echo $controllerName;?>" onClick='quickDetail(<?php echo $product['selprod_id']; ?>)' class="modaal-inline-content"><?php echo Labels::getLabel('LBL_Quick_View', $siteLangId);?>
	</a>
</div>
<?php } ?>
