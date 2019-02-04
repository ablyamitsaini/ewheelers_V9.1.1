<?php $i=0; foreach( $row['shops'] as $shop ){?>
	<div class="ftshops ftshops row <?php echo ($i%2!=0) ? 'ftshops-rtl' : ''; ?>">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 column">
			<div class="ftshops_item">
			  <div class="shop-detail-side">
				<div class="shop-detail-inner">
					<div class="ftshops_item_head_left">
						<div class="ftshops_logo"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','shopLogo', array($shop['shopData']['shop_id'], $siteLangId, "THUMB", 0, false),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $shop['shopData']['shop_name']; ?>"></div>
						<div class="ftshops_detail">
							<div class="ftshops_name"><a href="<?php echo (!isset($shop['shopData']['promotion_id'])?CommonHelper::generateUrl('shops','view', array($shop['shopData']['shop_id'])):CommonHelper::generateUrl('shops','track', array($shop['shopData']['promotion_record_id'],Promotion::REDIRECT_SHOP,$shop['shopData']['promotion_record_id'])));?>"><?php echo $shop['shopData']['shop_name'];?></a></div>
							<div class="ftshops_location"><?php echo $shop['shopData']['state_name'];?><?php echo ($shop['shopData']['country_name'] && $shop['shopData']['state_name'])?', ':'';?><?php echo $shop['shopData']['country_name'];?></div>
						</div>
					</div>
					<div class="ftshops_item_head_right">
						<?php if( round($row['rating'][$shop['shopData']['shop_id']])>0){?>
						<div class="products__rating"> <i class="icn"><svg class="svg">
									<use xlink:href="images/retina/sprite.svg#star-yellow" href="images/retina/sprite.svg#star-yellow"></use>
								</svg></i> <span class="rate"><?php echo  round($row['rating'][$shop['shopData']['shop_id']],1);?><span></span></span>
						</div>
						<?php }?>
						<a href="<?php echo (!isset($shop['shopData']['promotion_id'])?CommonHelper::generateUrl('shops','view', array($shop['shopData']['shop_id'])):CommonHelper::generateUrl('shops','track', array($shop['shopData']['promotion_record_id'],Promotion::REDIRECT_SHOP,$shop['shopData']['promotion_record_id']))); ?>" class="btn btn--primary btn--sm ripplelink" tabindex="0"><?php echo Labels::getLabel('LBL_View_Shop',$siteLangId);?></a>
					</div>
				</div>
			  </div>
			  <div class="product-wrapper">
				<div class="row">
				<?php foreach($shop['products'] as $product){?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 column">
						<?php include('product-layout-1-list.php'); ?>
					</div>
					<?php } ?>
				</div>
			  </div>
			</div>
		  </div>
	</div>
<?php $i++;

		isset($shop['shopData']['promotion_id'])?Promotion::updateImpressionData($shop['shopData']['promotion_id']):'';
		if($i==Collections::LIMIT_SHOP_LAYOUT1) break; } ?>