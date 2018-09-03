<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
if( isset( $collections ) && count($collections) ){
	foreach( $collections as $collection_id => $row ){
		$haveBgImage = AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_BG_IMAGE, $collection_id );
		$bgImageUrl = ($haveBgImage) ? "background-image:url(" . CommonHelper::generateUrl( 'Image', 'CollectionBg', array($collection_id, $siteLangId) ) . ")" : '';
		$haveImage = AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_IMAGE, $collection_id );
		?>
		<section class="section section--bg" style=" <?php echo $bgImageUrl; ?>; background-color:#1689e5;">
			<div class="container container--fixed">
				<div class="row">
					<div class="col-md-2 col-sm-4">
						<div class="brandblock">
							<?php echo ($haveImage) ? '<figure class="brandblock__logo"><img src="'. CommonHelper::generateUrl( 'Image', 'Collection', array($collection_id, $siteLangId, 'home') ) .'"/></figure>' : '';?>
							<?php echo ($row['collection_name'] != '') ? '<h2>' . $row['collection_name'] .'</h2>' : ''; ?>
							<?php echo ($row['collection_description'] != '') ? '<p>' . nl2br($row['collection_description']) . '</p>' : ''; ?>
							<?php if( $row['collection_link_caption'] != '' ){ ?>
							<a href="<?php echo CommonHelper::processUrlString($row['collection_link_url']); ?>" class="btn btn--borderd-white"><?php echo $row['collection_link_caption']; ?></a>
							<?php } ?>
						</div>
					</div>
					<?php if( isset($row['products']) && count($row['products']) ){ ?>
					<div class="scroller scroller--horizontal col-md-10 col-sm-8">
						<?php
						$itrIndex = 0;
						foreach( $row['products'] as $product ){
							if($itrIndex == 5 ){
								break;
							}
						$productUrl = CommonHelper::generateUrl('Products','View',array($product['selprod_id']));
						?>
						<div class="scroller__grid">
						  <div class="item item--small item--hovered box box--white">
							<?php if($product['selprod_condition'] == PRODUCT::CONDITION_NEW){ ?>
									<span class="item__badge" title="<?php echo Product::getConditionArr($siteLangId)[$product['selprod_condition']]; ?>"><?php echo Product::getConditionArr($siteLangId)[$product['selprod_condition']]; ?></span>
							<?php } ?>
							<figure class="item__pic"><a href="<?php echo $productUrl; ?>" ><img src="<?php echo  FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL),CONF_IMG_CACHE_TIME, '.jpg'); ?>" title="<?php echo $product['selprod_title'];?>" alt="<?php echo $product['selprod_title']; ?>"></a></figure>


							  <span class="item__title"><a href="<?php echo $productUrl; ?>" title="<?php echo $product['selprod_title']; ?>" ><?php echo $product['selprod_title']; ?></a></span>

							  <?php if($product['special_price_found']){ ?>
								<span class="item__info"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
								<span class="item__price--old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
							  <?php } ?>

							  <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
						  </div>
						</div>
					<?php
					$itrIndex++;
					} ?>
					</div>
					<?php } ?>

				</div>
			</div>
		</section>
<?php } } ?>
