<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if($recentViewedProducts){ ?>
<section class="section bg--second-color">
	<div class="container">
		<div class="section-head section--white--head section--head--center">
			<div class="section__heading">
				<h2><?php echo Labels::getLabel('LBL_Recently_Viewed', $siteLangId); ?></h2>
			</div>
		</div>
		<div class="row slides--six-js collection-corner" dir="<?php echo CommonHelper::getLayoutDirection();?>">
			<?php foreach($recentViewedProducts as $rProduct){ 
				$productUrl = CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id']));
			?>
			<div class="<?php /* col-lg-2 col-md-2 col-sm-3 col-xs-6 */ ?>">
			<!--product tile-->
			<div class="products">
				<div class="products__body">
				<?php $this->includeTemplate('_partial/collection-ui.php',array('product'=>$rProduct,'siteLangId'=>$siteLangId),false);?>
					<div class="products__img">
						<a title="<?php echo $rProduct['selprod_title'];?>" href="<?php echo !isset($rProduct['promotion_id'])?CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id'])):CommonHelper::generateUrl('Products','track',array($rProduct['promotion_record_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($rProduct['product_id'], "CLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $rProduct['prodcat_name'];?>"> </a>
					</div>
					<div class="products__quickview"> <a name="<?php echo $controllerName;?>" onClick='quickDetail(<?php echo $rProduct['selprod_id']; ?>)' class="modaal-inline-content"></a> </div>
				</div>
				<div class="products__footer">
					<?php if(round($rProduct['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?>
					<div class="products__rating">
						<i class="icn"><svg class="svg">
							<use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
						</svg></i> <span class="rate"><?php echo round($rProduct['prod_rating'],1);?></span>
						<?php if(round($rProduct['prod_rating'])==0 ){  ?>
						  <span class="be-first"> <a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span>
						<?php } ?>
					</div>
					<?php }?>
					<?php $this->includeTemplate('_partial/collection-product-price.php',array('product'=>$rProduct,'siteLangId'=>$siteLangId),false);?>
					<div class="products__category"><a href="<?php echo CommonHelper::generateUrl('Category','View',array($rProduct['prodcat_id']));?>"><?php echo $rProduct['prodcat_name'];?> </a></div>
					<div class="products__title"><a title="<?php echo $rProduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id']));?>"><?php echo (mb_strlen($rProduct['selprod_title']) > 30) ? mb_substr($rProduct['selprod_title'],0,30)."..." : $rProduct['selprod_title'];?> </a></div>
					
				</div>
			</div>
			<!--/product tile-->
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php }?>
