				<div class="ftshops row"> 
						<?php $i=0; foreach( $row['shops'] as $shop ){?>
							<div class="col-lg-6 col-md-6 col-sm-6 ">
								<div class="ftshops_item">
								  <div class="ftshops_item_head">
									<div class="row ">
									  <div class="col-lg-8">
										<div class="ftshops_item_head_left">
										  <div class="ftshops_logo"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','shopLogo', array($shop['shopData']['shop_id'], $siteLangId, "THUMB", 0, false),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $shop['shopData']['shop_name']; ?>"> </div>
										  <div  class="ftshops_detail">
											<div class="ftshops_name"><a href="<?php echo (!isset($shop['shopData']['promotion_id'])?CommonHelper::generateUrl('shops','view', array($shop['shopData']['shop_id'])):CommonHelper::generateUrl('shops','track', array($shop['shopData']['promotion_record_id'],Promotion::REDIRECT_SHOP,$shop['shopData']['promotion_record_id'])));?>"><?php echo $shop['shopData']['shop_name'];?></a></div>
											<div class="ftshops_location"><?php echo $shop['shopData']['state_name'];?><?php echo ($shop['shopData']['country_name'] && $shop['shopData']['state_name'])?', ':'';?><?php echo $shop['shopData']['country_name'];?></div>
											<?php if( round($row['rating'][$shop['shopData']['shop_id']])>0){?>
											<div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
											  <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
						C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
						l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
						l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
						l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"/>
											  </svg> </i><span class="rate"><?php echo  round($row['rating'][$shop['shopData']['shop_id']],1);?></span> </div>
											<?php }?>
										  </div>
										</div>
									  </div>
									  <div class="col-lg-4">
										<div class="ftshops_item_head_right"> <a href="<?php echo (!isset($shop['shopData']['promotion_id'])?CommonHelper::generateUrl('shops','view', array($shop['shopData']['shop_id'])):CommonHelper::generateUrl('shops','track', array($shop['shopData']['promotion_record_id'],Promotion::REDIRECT_SHOP,$shop['shopData']['promotion_record_id']))); ?>" class="btn btn--primary ripplelink" tabindex="0"><?php echo Labels::getLabel('LBL_SHOP_NOW',$siteLangId);?></a> </div>
									  </div>
									</div>
								  </div>
								  <div class="ftshops_body clearfix">
								  <?php foreach($shop['products'] as $product){?>
								  <div class="item-yk <?php if($product['selprod_stock']<=0){ ?> item--sold  <?php } ?>">
									  <?php include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
									  <div class="item-yk_body">
									   <?php if($product['selprod_stock']<=0){ ?>
										  <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></span>
										  <?php  } ?>
										<div class="product-img"><a title="<?php echo $product['selprod_title'];?>"  href="<?php echo (!isset($shop['shopData']['promotion_id'])?CommonHelper::generateUrl('Products','View',array($product['selprod_id'])):CommonHelper::generateUrl('shops','track', array($shop['shopData']['promotion_record_id'],Promotion::REDIRECT_PRODUCT,$product['selprod_id']))); ?>" tabindex="-1"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $product['selprod_title'];?>"> </a></div>
										 <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
									  </div>
									  <div class="item-yk_footer">
										 <?php include(CONF_THEME_PATH.'_partial/collection-product-price.php');?>
									  </div>
									</div>
									
								  <?php } ?>
								  </div>
								</div>
							  </div>
							<?php
							$i++;
							
							isset($shop['shopData']['promotion_id'])?Promotion::updateImpressionData($shop['shopData']['promotion_id']):'';	
							if($i==Collections::COLLECTION_LAYOUT4_LIMIT) break; 
						}
						?>
				</div>
		