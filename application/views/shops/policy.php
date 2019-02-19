<?php defined('SYSTEM_INIT') or die('Invalid Usage');

	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input value="" type="submit" class="input-submit">';
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id)); 
 ?>

<div id="body" class="body bg--shop" <?php if($showBgImage){ echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; } ?>>
  <div class="shop-bar">
    <div class="container">
      <div class="row">
		<div class="col-lg-7 col-md-7 col-sm-7  col-xs-12">
          <div class="shops-detail">
            <div class="shops-detail-name"> <?php echo $shop['shop_name']; ?></div>
            <div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
              <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
	C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
	l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
	l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
	l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"></path>
              </svg> </i> <span class="rate"> <?php echo round($shopRating,1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5';  if($shopTotalReviews){ ?> - <a href="<?php echo CommonHelper::generateUrl('Reviews','shop',array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews , ' ' , Labels::getLabel('Lbl_Reviews',$siteLangId); ?></a>
              <?php } ?>
              </span> </div>
            <div class="shop-actions">
				<ul>
				<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer()) ) $showAddToFavorite = false; ?>
				<?php if($showAddToFavorite) { ?>
					<li><a href="javascript:void(0)" onclick="toggleShopFavorite(<?php echo $shop['shop_id']; ?>);" class="<?php echo ($shop['is_favorite']) ? 'is-active' : ''; ?>" id="shop_<?php echo $shop['shop_id']; ?>" tabindex="0">
						<i class="icn"> <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/loveshop.svg"></i>
					 <?php echo Labels::getLabel('LBL_Love', $siteLangId);  echo " ".$shop['shop_name']; ?> !</a>
					</li>
				<?php }?>
				<?php $showMoreButtons = true; if (UserAuthentication::isUserLogged() && UserAuthentication::getLoggedUserId(true) == $shop['shop_user_id']) $showMoreButtons = false; ?>
				<?php if($showMoreButtons){ ?>
					<li> <a href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'])); ?>" class="" tabindex="0"> <i class="icn"> <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/send-meg.svg"></i> <?php echo Labels::getLabel('LBL_Send_Message', $siteLangId); ?></a></li>
					<li> <a href="<?php echo CommonHelper::generateUrl('Shops','ReportSpam', array($shop['shop_id'])); ?>" class=""><i class="icn"> <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/spam.svg"></i> <?php echo Labels::getLabel('LBL_Report_Spam',$siteLangId); ?></a></li>
				<?php }?>
				</ul>
			  </div>
          </div>
        </div>
		<div class="col-lg-5 col-md-5 col-sm-5  col-xs-12">
          <div class="shop-opened text-right"> <?php echo Labels::getLabel('LBL_Shop_Opened_By', $siteLangId); ?> <strong> <?php echo $shop['user_name'];?> </strong></div>
        </div>
      </div>
    </div>
  </div>
  <?php 
	$variables= array('shop'=>$shop, 'siteLangId'=>$siteLangId,'frmProductSearch'=>$frmProductSearch,'searchFrm'=>$searchFrm,'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action);
	
	if(!isset($template_id) || ($template_id<0)){
		$template_id=10001;
	}
	
	$this->includeTemplate('shops/templates/'.$template_id.'.php',$variables,false);

	?>
	<?php if( $shop['shop_payment_policy'] != '' || $shop['shop_delivery_policy'] != '' || $shop['shop_refund_policy'] != '' || $shop['shop_additional_info'] != '' ||  $shop['shop_seller_info'] != ''){ ?>
	<section class="top-space">
		<div class="container">
		  <div class="white--bg padding20">
			<div class="row">
			  <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12">
				
				<?php if( $shop['shop_payment_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4><?php echo Labels::getLabel('LBL_PAYMENT_POLICY', $siteLangId); ?></h4>
				  <p><?php echo nl2br($shop['shop_payment_policy']); ?></p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_delivery_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4><?php echo Labels::getLabel('LBL_DELIVERY_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_delivery_policy']); ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_refund_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_REFUND_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_refund_policy']); ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_additional_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_ADDITIONAL_INFO', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_additional_info']); ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_seller_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_SELLER_INFO', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_seller_info']); ?> </p>
				</div>
				<?php } ?>
			  </div>
			</div>
		  </div>
		</div>
    </section>
	<?php } ?>
	<div class="gap"></div>
</div>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>