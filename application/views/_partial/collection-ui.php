<?php 
$staticCollectionClass='';
if($controllerName='Products' && isset($action) && $action=='view'){
$staticCollectionClass='static--collection';
 } ?>
<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; ?>
<?php if($showAddToFavorite) { ?>
<div class="collections-ui <?php echo $staticCollectionClass;?> "> 
 <?php if(!$staticCollectionClass){?>
 <span class="hamburger menu-toggle" >
   <div class="lines-wrapper"> 
     <div class="lines line1"></div>
     <div class="lines line2"></div>
     <div class="lines line3"></div>
     <div class="lines line4"></div>
   </div>
 </span>
  <?php } ?>
  <ul>
    <li class="menu-item menu-item1 heart-wrapper <?php echo($product['ufp_id'])?'is-active':'';?>" data-id="<?php echo $product['selprod_id']; ?>"> <span  title="<?php echo Labels::getLabel('LBL_Add_Product_to_favourite_list',$siteLangId); ?>"> <i class="svg "> <svg viewBox="0 0 15.996 13.711">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#heart-fav"></use>
      </svg>
      <div class="ring"></div>
      <div class="circles"></div>
      </i> </span> </li>
    <li class="menu-item menu-item2 collection-wrapper"><span  title="<?php echo Labels::getLabel('LBL_Add_Product_to_your_wishlist',$siteLangId); ?>" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);" class="ripplelink collection-toggle link--icon wishListLink-Js"><i class="svg"> <svg viewBox="0 0 64 64">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#collection-list"></use>
      </svg> </i> </span>
      <div class="collection__container" id="listDisplayDiv_<?php echo $product['selprod_id']; ?>" data-id ="<?php echo $product['selprod_id']; ?>"> </div>
    </li>
    <?php if($controllerName='Products' && isset($action) && $action=='view'){?>
    <li class="menu-item menu-item3"> <span  class="ripplelink social-toggle" title="<?php echo Labels::getLabel('LBL_Share_this_product',$siteLangId); ?>"><i class="svg"> <svg  viewBox="0 0 16 16">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#collection-share"></use>
      </svg> </i></span>
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
    </li>
    <?php  
	  }?>
  </ul>
</div>
<?php }?>
<?php if(!$staticCollectionClass && (!isset($quickDetailIcon))){ ?>
<div class="quickview">
	<a name="<?php echo $controllerName;?>" onClick='quickDetail(<?php echo $product['selprod_id']; ?>)' class="modaal-inline-content"><?php echo Labels::getLabel('LBL_Quick_View', $siteLangId);?>
	</a>
</div>
<?php } ?>
