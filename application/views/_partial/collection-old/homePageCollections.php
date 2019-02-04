<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset( $collections ) && count($collections) ){
	$counter = 1;
	foreach( $collections as $collection_id => $row ){ ?>
	<?php if( isset($row['products']) && count($row['products']) ) { ?>
	 <section class="padd40">
      <div class="container">
        <div class="section-head">
			<?php echo ($row['collection_name'] != '') ? ' <div class="section_heading">' . $row['collection_name'] .'</div>' : ''; ?>
			<?php echo ($row['collection_description'] != '') ? '<p>' . nl2br($row['collection_description']) . '</p>' : ''; ?>
			<?php if( $row['collection_link_caption'] != '' ){ ?>
					<div class="section_action"> <a href="<?php echo CommonHelper::processUrlString($row['collection_link_url']); ?>" class="btn btn--primary ripplelink"><?php echo $row['collection_link_caption']; ?></a> </div>
		  <?php }  ?>
        </div>
		
        <div class="shops">
          <div class="row">
		  
		  <?php foreach( $row['products'] as $product ){ ?>
		  
		  
			  <div class="col-lg-3 col-md-3 col-xs-6 ">
              <div class="item-yk <?php if($product['selprod_stock']<=0){?> item--sold  <?php }?>">
                <div class="item-yk-head">
                  <div class="item-yk-head-lable"><?php echo Product::getConditionArr($siteLangId)[$product['selprod_condition']];?></div>
                  <div class="item-yk-head-category"><a href="javascript:void(0)"><?php echo $product['selprod_title'];?> </a></div>
                  <div class="item-yk-head-title"><a title="<?php echo $product['product_name'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><?php echo $product['product_name']; ?></a></div>
                  <div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
                    <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
	C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
	l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
	l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
	l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"/>
                    </svg> </i><span class="rate"><?php echo round($product['prod_rating'],1);?></span> </div>
                </div>
                <div class="item-yk_body">
				  <?php if($product['selprod_stock']<=0){ ?>		
					<span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></span>
				  <?php  } ?>
                  <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><img src="<?php echo  FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg') ; ?>" alt="<?php echo $product['product_name']; ?>"> </a></div>
                  <?php $showAddToFavorite = true; if(UserAuthentication::isUserLogged() && (!User::isBuyer())) $showAddToFavorite = false; ?>
				  <?php if($showAddToFavorite) { ?>
					<div class="collections-ui">
						<ul>
						  <li class="heart-wrapper <?php echo($product['ufp_id'])?'is-active':'';?>" data-id="<?php echo $product['selprod_id']; ?>"> <a href="javascript:void(0)" title="<?php echo($product['ufp_id'])? Labels::getLabel('LBL_Remove_product_from_favourite_list',$siteLangId) : Labels::getLabel('LBL_Add_Product_to_favourite_list',$siteLangId); ?>"> <i class="svg "> <svg viewBox="0 0 15.996 13.711">
							<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#heart-fav"></use>
							</svg>
							<div class="ring"></div>
							<div class="circles"></div>
							</i> </a> </li>
						  <li class="collection-wrapper"><a href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_Add_Product_to_your_wishlist',$siteLangId); ?>" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this);" class="ripplelink collection-toggle link--icon wishListLink-Js"><span class="ink animate" style="height: 359px; width: 359px; top: -207.938px; left: 7.34375px;"></span> <i class="svg"> <svg viewBox="0 0 64 64">
							<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#collection-list"></use>
							</svg> </i> </a>
							<div class="collection__container" id="listDisplayDiv_<?php echo $product['selprod_id']; ?>" data-id ="<?php echo $product['selprod_id']; ?>">	
							</div>
						  </li>
						</ul>
					</div>
				  <?php }?>
                </div>
                <div class="item-yk_footer">
				<?php if($product['special_price_found']){ ?>
						 <div class="product_price"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?> <span class="product_price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span></div>
						<?php } ?>
                  <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']);?> </div>
                </div>
              </div>
            </div>
			<?php } ?>
          </div>
        </div>
      </div>
    </section>
		<?php } ?>
	
	
	

			
			
               
			
       
			
	
	<?php $counter++; } 
} ?>