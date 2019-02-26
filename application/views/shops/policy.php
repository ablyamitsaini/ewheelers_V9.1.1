<?php defined('SYSTEM_INIT') or die('Invalid Usage');

	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input value="" type="submit" class="input-submit">';
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id)); 
	$haveBannerImage = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '' , $siteLangId );
 ?>

<div id="body" class="body" role="main" <?php if($showBgImage){ /* echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; */ } ?> >
	<section class="bg-shop">
		<div class="shop-col column--md">
			<div class="shop-logo-wrapper">
				<?php if( $haveBannerImage ){ ?>
			  <div class="shops-sliders" dir="<?php echo CommonHelper::getLayoutDirection();?>">
				<?php foreach($haveBannerImage as $banner){ ?>
				<div class="item"><img src="<?php echo CommonHelper::generateUrl('image','shopBanner',array($banner['afile_record_id'],$siteLangId,'TEMP2',$banner['afile_id'])); ?>" alt="<?php echo Labels::getLabel('LBL_Shop_Banner', $siteLangId); ?>"></div>
				<?php } ?>
			  </div>
			  <?php } ?>
			  <div class="shop-logo"><img src="<?php echo CommonHelper::generateUrl('image','shopLogo',array($shop['shop_id'],$siteLangId,'SMALL')); ?>" alt="<?php echo $shop['shop_name']; ?>"></div>
			</div>
		</div>
		<div class="shop-col column--md">
			<div class="shop-info">
				<div class="row">
					<div class="col-md-8">
						<div class="shop-name">
							<h5><?php echo $shop['shop_name']; ?> <span class="blk-txt"><?php echo Labels::getLabel('LBL_Shop_Opened_By', $siteLangId); ?> <strong> <?php echo $shop['user_name'];?> </strong></span></h5>

						</div>
						<div class="products__rating"> <i class="icn"><svg class="svg">
									<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
								</svg></i> <span class="rate"><?php echo round($shopRating,1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5';  if($shopTotalReviews){ ?> - <a href="<?php echo CommonHelper::generateUrl('Reviews','shop',array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews , ' ' , Labels::getLabel('Lbl_Reviews',$siteLangId); ?></a><?php } ?> </span>
						</div>
						<div class="share-this">
							<span><i class="icn share"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"></use>
									</svg></i><?php echo Labels::getLabel('LBL_Share',$siteLangId); ?></span>
							<a class="social-link st-custom-button" data-network="facebook">
								<i class="icn"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"></use>
									</svg></i>
							</a>
							<a class="social-link st-custom-button" data-network="twitter">
								<i class="icn"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"></use>
									</svg></i>
							</a>
							<a class="social-link st-custom-button" data-network="pinterest">
								<i class="icn"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"></use>
									</svg></i>
							</a>
							<a class="social-link st-custom-button" data-network="email">
								<i class="icn"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"></use>
									</svg></i>
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="shop-btn-group">
							<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer()) ) $showAddToFavorite = false; ?>
							<?php if($showAddToFavorite) { ?>
								<a href="javascript:void(0)" onclick="toggleShopFavorite(<?php echo $shop['shop_id']; ?>);" class="btn btn--primary btn--sm <?php echo ($shop['is_favorite']) ? 'is-active' : ''; ?>" id="shop_<?php echo $shop['shop_id']; ?>"><i class="icn"><svg class="svg">
										<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart"></use>
									</svg></i><?php echo Labels::getLabel('LBL_Love', $siteLangId);  echo " ".$shop['shop_name']; ?> !</a>
							<?php }?>
							<?php $showMoreButtons = true; if (UserAuthentication::isUserLogged() && UserAuthentication::getLoggedUserId(true) == $shop['shop_user_id']) $showMoreButtons = false; ?>
							<?php if($showMoreButtons){ ?>
								<a href="<?php echo CommonHelper::generateUrl('Shops','ReportSpam', array($shop['shop_id'])); ?>" class="btn btn--primary btn--sm"><i class="icn"><svg class="svg">
											<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report"></use>
										</svg></i><?php echo Labels::getLabel('LBL_Report_Spam',$siteLangId); ?></a>

								<a href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'])); ?>" class="btn btn--primary btn--sm"><i class="icn"><svg class="svg">
											<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg"></use>
										</svg></i><?php echo Labels::getLabel('LBL_Send_Message', $siteLangId); ?></a>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="gap"></div>
				<div class="shop-profile">
					<div class="row">
						<div class="col-md-12">
							<div class="box box--space shop-avatar">
								<div class="shoper__dp"><img src="<?php echo CommonHelper::generateUrl('image','User',array($shop['shop_user_id'])); ?>"></div>
								<div class="profile__bio">
									<div class="title">
										<h6><?php echo $shop['user_name'];?> <span class="deg blk-txt"> <?php echo Labels::getLabel('LBL_Shop_Owner', $siteLangId); ?></span></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if($shop['shop_description']){?>
					<div class="divider divider--single"></div>
					<div class="box box--space shop-information">
						<p><strong><?php echo Labels::getLabel('LBL_Information', $siteLangId); ?></strong></p>
						<p><?php echo nl2br($shop['shop_description']);?></p>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
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
				  <p><?php echo $shop['shop_payment_policy']; ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_delivery_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4><?php echo Labels::getLabel('LBL_DELIVERY_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo $shop['shop_delivery_policy']; ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_refund_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_REFUND_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo $shop['shop_refund_policy']; ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_additional_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_ADDITIONAL_INFO', $siteLangId); ?></h4>
				  <p> <?php echo $shop['shop_additional_info']; ?> </p>
				</div>
				<?php } ?>
				
				<?php if( $shop['shop_seller_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_SELLER_INFO', $siteLangId); ?></h4>
				  <p> <?php echo $shop['shop_seller_info']; ?> 
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
<script>
(function($){
	if(langLbl.layoutDirection == 'rtl'){
		$('.shops-sliders').slick({
			dots: false,
			arrows:true,
			autoplay:true,
			rtl:true,
			pauseOnHover:false,
		});
	}
	else
	{
		$('.shops-sliders').slick({
		dots: false,
		arrows:true,
		autoplay:true,
		pauseOnHover:false,
		});
	}
})(jQuery);
</script>