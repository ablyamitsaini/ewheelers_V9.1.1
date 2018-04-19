<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if($wishLists) {
		foreach( $wishLists as $wishlist ){ 
			//if(count($wishlist['products'])>0){
			?>
				<div class="col-md-3 col-sm-4">
					<div class="items ">
						<div class="items__body">
							<?php if( $wishlist['products'] ){ ?>
							<div class="items__group clearfix">
								<div class="items__row">
									<?php foreach($wishlist['products'] as $product) { 
										$productUrl = CommonHelper::generateUrl('Products','View',array($product['selprod_id']));
										?>
										<div class="item <?php echo (!$product['in_stock']) ? 'item--sold' : '';?>">
											<span class="overlay--collection"></span>
											<div class="item__head">
												<?php if( !$product['in_stock'] ){ ?>
												<span class="tag--soldout"><?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></span>
												<?php } ?>
											
												<a href="<?php echo $productUrl; ?>" class="item__pic"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId ),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $product['product_name'];?>" alt="<?php echo $product['product_name']; ?>"></a>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php } 
							
							?>
							
							<span class="item__title"><?php echo $wishlist['uwlist_title']; ?></span>
							<ul class="links--inline">
							<?php if( !isset($wishlist['uwlist_type']) || (isset($wishlist['uwlist_type']) && $wishlist['uwlist_type']!=UserWishList::TYPE_FAVOURITE )){
									$functionName = 'viewWishListItems';
								}else{
									$functionName = 'viewFavouriteItems';
								} if($wishlist['totalProducts']>0){ ?>
								<li><a onClick="<?php echo $functionName;?>(<?php echo $wishlist['uwlist_id']; ?>);" href="javascript:void(0)" class="text--normal-primary"> <?php echo str_replace('{n}', $wishlist['totalProducts'], Labels::getLabel('LBL_View_{n}_items', $siteLangId)); ?> <i class="fa fa-eye"></i></a></li>
								<?php } if( !isset($wishlist['uwlist_type']) || (isset($wishlist['uwlist_type']) && $wishlist['uwlist_type']!=UserWishList::TYPE_FAVOURITE )) {?>
								<li><a onclick="deleteWishList(<?php echo $wishlist['uwlist_id']; ?>);" href="javascript:void(0)" class="text--normal-secondary"> <?php echo Labels::getLabel('LBL_Delete_List', $siteLangId); ?> <i class="fa fa-times"></i></a></li>
								<?php } ?>
							</ul>
							<?php //} ?>
						</div>
					</div>
				</div>
		<?php 	}	 
			
	}?>

<div class="col-md-3 col-sm-4">
	<div class="items">
		<div class="items__body">
			<div class="form form--creatlist">
				<h5><?php echo Labels::getLabel('LBL_Create_new_list', $siteLangId);?></h5>
				<?php 
				$frm->setFormTagAttribute('onsubmit','setupWishList2(this,event); return(false);');
				$titleFld = $frm->getField('uwlist_title');
				$titleFld->setFieldTagAttribute('placeholder',Labels::getLabel('LBL_Enter_List_Name', $siteLangId));
				$titleFld->setFieldTagAttribute('title',Labels::getLabel('LBL_List_Name', $siteLangId));
				
				$btnSubmitFld = $frm->getField('btn_submit');
				$btnSubmitFld->setFieldTagAttribute('class','btn--block');
				$btnSubmitFld->value = Labels::getLabel('LBL_Create', $siteLangId);
				
				echo $frm->getFormHtml(); ?>
			</div>    
		</div>
	</div>
</div>