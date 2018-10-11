<?php 
if(!empty($allShops)){
foreach($allShops as $val){ ?>
	<div class="rowrepeated">
		<div class="row">
			<div class="col-md-5 col-sm-5">
				<h5><a target='_blank' href="<?php echo CommonHelper::generateUrl('Shops','view' , array($val['shop_id'])); ?>" target='_new'><?php echo $val['shop_name'];?></a></h5>
				<p><?php echo $val['state_name'].','.$val['country_name'];?></p>
				<div class="item__ratings">
					<ul class="rating">
					<?php for($j=1;$j<=5;$j++){ ?>	
					<li class="<?php echo $j<=round($val["shopRating"])?"active":"in-active" ?>">
						<svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
						<g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="<?php echo $j<=round($val["shopRating"])?"#ff3a59":"#474747" ?>" /></g></svg>
					</li>
					<?php } ?>
					</ul>
				</div>
				<span class="text--normal"><?php echo round($val["shopRating"],1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5' ?> - <a target='_blank' href="<?php echo CommonHelper::generateUrl('Reviews','shop',array($val['shop_id'])) ?>"><?php echo ($val['shopTotalReviews']) ? $val['shopTotalReviews'] . ' ' . Labels::getLabel('Lbl_Reviews',$siteLangId) .' | ' : ''; ?></a>  </span>
				
				<?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; ?>
				<?php if($showAddToFavorite) { ?>	
					<?php if($val['is_favorite']){ ?>
					<a class="link--normal" href="javascript:void(0);" onClick="unFavoriteShopFavorite(<?php echo $val['shop_id']; ?>,this)"><?php echo Labels::getLabel('LBL_UnFavorite_to_Shop', $siteLangId); ?></a>
					<?php } else {
					?>
					<a class="link--normal" href="javascript:void(0);" onClick="markShopFavorite(<?php echo $val['shop_id']; ?>,this)"><?php echo Labels::getLabel('LBL_Favorite_Shop', $siteLangId); ?></a>
					<?php
				} } ?>
				
			</div>
			<div class="col-md-7 col-sm-7">
				<div class="scroller--items align--right">
					<ul class="listing--items">
						<?php if(!empty($val['products'])){
							foreach($val['products'] as $product){ ?>
							<li><a class="item__pic" target='_blank' href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id'])); ?>"><img alt="<?php echo $product['product_name'];?>" src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>"></a></li>								
						<?php }
						} ?>
						<li><a target='_blank' href="<?php echo CommonHelper::generateUrl('shops','view',array($val['shop_id']));?>" class="item__link"><span><?php echo str_replace('{n}', $val['totalProducts'], Labels::getLabel('LBL_View_{n}_Product(s)', $siteLangId)); ?></span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php }
} else {
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} 

$postedData['page'] = (isset($page))?$page:1;
echo FatUtility::createHiddenFormFromData ( $postedData, array (
		'name' => 'frmSearchShopsPaging'
) );