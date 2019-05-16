
<div id="body" class="body detail-page" role="main">
<section class="">
	<div class="container">
		<div class="section">
		<div class="breadcrumbs breadcrumbs--center">
      <ul class="clearfix">
	<li><a href="/yokartv8">Home </a></li>
	<li><a href="/yokartv8">All Products</a></li>
  	<li>Cera Calista Wash Basin 655 x 500 mm</li>  			
		</ul>
    </div>
    </div>		
			<div class="detail-wrapper">			
			<div class="row">
			  <div class="col-lg-6"> 
          <div id="img-static" class="product-detail-gallery">
              <?php $data['product'] = $product;
				$data['productImagesArr'] = $productImagesArr;
				$data['imageGallery'] = true;
				/* $this->includeTemplate('products/product-gallery.php',$data,false); */
			   ?>
				<div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-for">
				<?php if( $productImagesArr ){ ?>
				  <?php
					foreach( $productImagesArr as $afile_id => $image ){
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
				  ?>
				  <img class="xzoom" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				<?php break; }?>
				<?php } else {
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'ORIGINAL', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');?>
				  <img class="xzoom" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				  <?php } ?>
				</div>
				<?php if( $productImagesArr ){ ?>
					<div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-nav">
						<?php foreach( $productImagesArr as $afile_id => $image ){
							$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							/* $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */
						?>
						<div class="thumb"><a href="<?php echo $originalImgUrl; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>"></a></div>
					  <?php } ?>
					</div>
				<?php } ?>				 
          </div>             
          <div class="favourite-wrapper ">
             <div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_118" data-id="118">
                    <a href="javascript:void(0)" onclick="viewWishList(118,this,event);" title="Add Product To Your Wishlist">
                        <div class="ring"></div>
                        <div class="circles"></div>
                    </a>
                </div>
            <div class="share-button">
            <a href="#" class="social-toggle"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#share" href="/yokartv8/images/retina/sprite.svg#share"></use>
                    </svg>
                </i></a>
            <div class="social-networks">
                <ul>
                    <li class="social-twitter">
                        <a href="https://www.twitter.com"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#tw" href="/yokartv8/images/retina/sprite.svg#tw"></use>
                    </svg>
                </i></a>
                    </li>
                    <li class="social-facebook">
                        <a href="https://www.facebook.com"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#fb" href="/yokartv8/images/retina/sprite.svg#fb"></use>
                    </svg>
                </i></a>
                    </li>
                    <li class="social-gplus">
                        <a href="http://www.gplus.com"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#gp" href="/yokartv8/images/retina/sprite.svg#gp"></use>
                    </svg>
                </i></a>
                    </li>
					<li class="social-pintrest">
                        <a href="http://www.gplus.com"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#pt" href="/yokartv8/images/retina/sprite.svg#pt"></use>
                    </svg>
                </i></a>
                    </li>
					
					<li class="social-email">
                        <a href="http://www.gplus.com"><i class="icn">
                    <svg class="svg">
                        <use xlink:href="/yokartv8/images/retina/sprite.svg#envelope" href="/yokartv8/images/retina/sprite.svg#envelope"></use>
                    </svg>
                </i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
        </div>
        
				<div class="col-lg-6">
						<div class="product-description">
				<div class="product-description-inner">
					<div class="products__title">
					<div class="section-head">
						<div class="section__heading"><h2>Apple iPhone 6s Plus Gold, 32 GB</h2></div>
					 
					 <div class="products-reviews">                                                         
                              <span class="rate"> <i class="icn"><svg class="svg">
                                <use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
                            </svg></i> 4.3 / 5</span><a href="/yokartv8/reviews/shop/1" class="totals-review link">20 Reviews</a>
                    </div>
					</div>
					</div>						
						<div class="brand-data">Brand: Apple</div>                     
                    <div class="divider"></div>
                    
                    
                    <div class="row">
										<div class="col-md-6 mb-2">
						<div class="h6">Select Size</div>
						
						<select>
							<option>39W x 39D cm</option>
							<option>39W x 39D cm</option>
							<option>39W x 39D cm</option>
							<option>39W x 39D cm</option>
						</select>
						
						 
					</div>
										<div class="col-md-6 mb-2">
						<div class="h6">Choose Color</div>						
						<select>
							<option>Brown</option>
							<option>Brown</option> 
							<option>Brown</option> 
							<option>Brown</option> 
							<option>Brown</option> 
						</select>					
						 
					</div>		</div>
                   
                   <div class="row">
                   <div class="col-auto form__group">
                       <div class="h6">SELECT QTY</div>		
                         <div class="qty-wrapper">
                        <div class="qty-input-wrapper" data-stock="9900">
                            <input maxlength="3" class="qty-input cartQtyTextBox productQty-js" title="Quantity" data-fatreq="{&quot;required&quot;:false,&quot;integer&quot;:true,&quot;range&quot;:{&quot;minval&quot;:0,&quot;maxval&quot;:9999999999,&quot;numeric&quot;:true}}" type="text" name="quantity" value="1">                        </div>
                        <div class="quantity" data-stock="9900">
                            <span class="increase increase-js"></span>
                            <span class="decrease decrease-js"></span>
                        </div>
                    </div></div>
                   	
                   	<div class="col products__price">$85.00  				<span class="products__price_old"> $120.00</span> <span class="product_off">-29%</span>				</div>
                   	
                   </div>
                   
                   <div class="buy-group">
                <button name="btnProductBuy" type="submit" id="btnProductBuy" class="btn btn--primary add-to-cart--js btnBuyNow"> Buy Now</button><button name="btnAddToCart" type="submit" id="btnAddToCart" class="btn btn--secondary   btn--primary-border add-to-cart--js">Add To Cart</button><input title="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="selprod_id" value="118">              </div>
                   
                   
                  
				<div class="h6"><?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)',$siteLangId);?>:</div>
				<ul class="js--discount-slider discount-slider acc-data" dir="<?php echo CommonHelper::getLayoutDirection();?>" >
                    <?php foreach($volumeDiscountRows as $volumeDiscountRow ){
							$volumeDiscount = $product['theprice'] * ( $volumeDiscountRow['voldiscount_percentage'] / 100 );
							$price = ($product['theprice'] - $volumeDiscount);
					?>
					<li>
					  <div class="qty__value"><?php echo ($volumeDiscountRow['voldiscount_min_qty']); ?> <?php echo Labels::getLabel('LBL_Or_more',$siteLangId);?> (<?php echo $volumeDiscountRow['voldiscount_percentage'].'%';?>) <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($price); ?> / <?php echo Labels::getLabel('LBL_Product',$siteLangId);?></span><span class="item__price--old"><?php echo CommonHelper::displayMoneyFormat($product['theprice']);?></span></div>
					</li>
                    <?php } ?>
                  </ul>
			
			<script type="text/javascript">
				$("document").ready(function(){
					$('.js--discount-slider').slick( getSlickSliderSettings(2,1,langLbl.layoutDirection) );
				});
			</script>
                   
                   
                   <div class="h6"><?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?></div>
                   <div class="addons-scrollbar" data-simplebar> <table class="table cart--full cart-tbl cart-tbl-addons">
                            <tbody>
                            <?php  foreach ($upsellProducts as $usproduct) {
                            $cancelClass ='';
                            $uncheckBoxClass='';
                            if($usproduct['selprod_stock']<=0){
                                $cancelClass ='cancelled--js';
                                $uncheckBoxClass ='remove-add-on';
                            }
                        ?>
                        <tr>
                          <td class="<?php echo $cancelClass;?>"><figure class="item__pic"><a title="<?php echo $usproduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('products','view',array($usproduct['selprod_id']))?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($usproduct['product_id'], 'MINI', $usproduct['selprod_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');?>" alt="<?php echo $usproduct['product_identifier']; ?>"> </a></figure></td>
                          <td class="<?php echo $cancelClass;?>"><div class="item__description">
                                            <div class="item__title"><a href="<?php echo CommonHelper::generateUrl('products', 'view', array($usproduct['selprod_id']) )?>" ><?php echo $usproduct['selprod_title']?></a></div></div>
                           <?php if($usproduct['selprod_stock']<=0){ ?>
                              <div class="addon--tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></div>
                              <?php  } ?></td>
                          <td class="<?php echo $cancelClass;?>"><div class="item__price"><?php echo CommonHelper::displayMoneyFormat($usproduct['theprice']); ?></div></td>
                          <td class="<?php echo $cancelClass;?>">
                            <div class="qty-wrapper">
                                <div class="qty-input-wrapper" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                    <input type="text" value="1" placeholder="Qty" class="qty-input cartQtyTextBox productQty-js" lang="addons[<?php echo $usproduct['selprod_id']?>]" name="addons[<?php echo $usproduct['selprod_id']?>]">
                                </div>
                                <div class="quantity" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                    <span class="increase increase-js"></span>
                                    <span class="decrease decrease-js"></span>
                                </div>
                            </div>
                          </td>
                          <td class="<?php echo $cancelClass;?>"><label class="checkbox">
                              <input <?php if($usproduct['selprod_stock']>0){ ?>checked="checked" <?php } ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass;?>" id="check_addons" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId);?>">
                              <i class="input-helper"></i> </label>
                            </td>
                        </tr>
                        <?php } ?>
                            </tbody>
                        </table></div> 
                   
                    
                    
                    
							</div>
					</div>					
				</div>				
			</div>
			
				 
	 <section class="section certified-bar">
	 	<div class="container">
	 		<div class="row justify-content-between">
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#freeshipping" href="/yokartv8/images/retina/sprite.svg#freeshipping"></use>
			</svg>
		</i><p>30 Days Warranty</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#easyreturns" href="/yokartv8/images/retina/sprite.svg#easyreturns"></use>
			</svg>
		</i>
	 					<p>No Returns</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#yearswarranty" href="/yokartv8/images/retina/sprite.svg#yearswarranty"></use>
			</svg>
		</i>
	 					<p>Free Shipping on this Order</p>
	 				</div>
	 			</div>
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#safepayments" href="/yokartv8/images/retina/sprite.svg#safepayments"></use>
			</svg>
		</i>
	 					<p>Shipping Policies</p>
	 				</div>
	 			</div>
	 			
	 			<div class="col-auto">
	 				<div class="certified-box">
	 					<i class="icn">
			<svg class="svg">
				<use xlink:href="/yokartv8/images/retina/sprite.svg#safepayments" href="/yokartv8/images/retina/sprite.svg#safepayments"></use>
			</svg>
		</i>
	 					<p>Cash On Delivery Is Available </p>
	 				</div>
	 			</div>
	 			
	 		</div>
	 	</div>	 	
	 </section>
	 
	 <div class="nav-detail">Description              Shipping & Policies               Video               Ratings & Reviews</div>
	 
	 <div class="section-head">
			<div class="section__heading">
			<h2>Description</h2>
			</div>
		</div>
	 				<div class="cms">
	 				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit </p>
 			</div>
 			
 			<h3>Specification</h3>
 			<table>
										<tbody>
																						<tr>
												<th>Neck Type :</th>
												<td>Round Neck</td>
											</tr>
																						<tr>
												<th>Ideal For :</th>
												<td>Women's</td>
											</tr>
																						<tr>
												<th>Pattern :</th>
												<td>Solid, Striped</td>
											</tr>
																						<tr>
												<th>Sleeve :</th>
												<td>Full Sleeve</td>
											</tr>
																						<tr>
												<th>Suitable For :</th>
												<td>Western Wear</td>
											</tr>
																						<tr>
												<th>Fabric :</th>
												<td>Cotton</td>
											</tr>
																						<tr>
												<th>Sleeve Type :</th>
												<td>Narrow</td>
											</tr>
																						<tr>
												<th>Reversible :</th>
												<td>No</td>
											</tr>
																						<tr>
												<th>Brand Fit :</th>
												<td>Slim Fit</td>
											</tr>
																					</tbody>
									</table>
									
									
								 <div class="section-head">
			<div class="section__heading">
			<h2>Shipping & Policies</h2>
			</div>
		</div>
		
		<div class="cms">
			<p>Payment</p>
			<p>We accept PayPal. You may use a credit card on PayPal without creating a PayPal account. Click the "Check out with PayPal" button. You'll be taken to a secure page on PayPal. Look for a link below the log-in form reading "Don't have a PayPal account?" You'll then be prompted to fill in your billing and credit card information.</p>
			<p>Shipping</p>
			<p>All Items shipped via International registered air mail within 1-3 work days (according to the Israeli calender). Once the item is shipped an email with a tracking number will be sent to you to enable you track the package status. Express shipping is available - you may contact us for specific information. Any additional costs that may be charged due to the customer's local duty or tax laws will be payed by the customer. We are shipping to the address you provided, please make sure it is correct.</p>
			<p>Refunds Exchanges</p>
			<p>We do not offer refunds - Exchange only. Please mark all returns for exchange as "Returned Goods" on the customs form and send items back via REGULAR post, otherwise there is a C.O.D. charge that will be charged to the customer.   The customer is responsible for shipping fees and customs costs if any. Once the order is received at our end, we will send you the exchange item.   Please ask any questions you have before purchasing!</p>
		</div>
		
		<div class="section-head">
			<div class="section__heading">
			<h2>Video</h2>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<h2>Ratings & Reviews</h2>
		<div class="products__rating"> <i class="icn"><svg class="svg">
                                 <use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
                             </svg></i> <span class="rate">2.7<span></span></span>
                     </div>
                     
                     <p>44 out of 4 (100%)
Customers recommend this product.</p>
			</div>
			<div class="col-md-6">
			<div class="listing--progress-wrapper p-4">
		<ul class="listing--progress">
			<li>
				<span class="progress_count">5 Star</span>
				<div class="progress__bar">
					<div title="50% Number Of Reviews Have 5 Stars" style="width: 50%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">4 Star</span>
				<div class="progress__bar">
					<div title="50% Number Of Reviews Have 4 Stars" style="width: 50%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">3 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 3 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">2 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 2 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
			<li>
				<span class="progress_count">1 Star</span>
				<div class="progress__bar">
					<div title="0% Number Of Reviews Have 1 Stars" style="width: 0%; clip: rect(0px, 144px, 160px, 0px);" role="progressbar" class="progress__fill"></div>
				</div>
			</li>
		</ul>
	</div></div>
		</div>
		
		<div class="row">
		<div class="col"><a href="#" class="btn btn--primary">Add Review</a></div>
			<div class="col"><a href="#" class="btn btn--secondary add-to-cart--js btn--primary-border">Newest</a></div>
		</div>
		
		
		 <div class="listing__all">
        <ul>
		<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/10/thumb/1" alt="Jenny"></div>
					<div class="profile__bio">
						<div class="title">By Jenny <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(1,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;1&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">4</span> </div>
					<div class="cms">
						<p><strong>Great!!</strong></p>
						<p>
							<span class="lessText">The toy was perfect - just what I was looking for. The item was very reasonably priced, they arrived in perfect condition, and earlier than promised. Importantly, the toy looked exactly like their onl</span>
														<span class="moreText" hidden="">
							The toy was perfect - just what I was looking for. The item was very reasonably priced, they arrived in perfect condition, and earlier than promised. Importantly, the toy looked exactly like their online photo and description. A hassle-free buying experience!							</span>
							<a class="readMore link--arrow" href="javascript:void(0);"> Show More </a>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
		<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/8/thumb/1" alt="مانبريت كور"></div>
					<div class="profile__bio">
						<div class="title">By مانبريت كور <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(10,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;10&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">5</span> </div>
					<div class="cms">
						<p><strong>Impressed!!</strong></p>
						<p>
							<span class="lessText">Shipping was late :(  but product was exactly the same as pictures.....fabric, color , everything was perfect.</span>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
	<li>
		<div class="row">
			<div class="col-md-3">
				<div class="profile-avatar">
					<div class="profile__dp"><img src="/yokartv8/image/user/8/thumb/1" alt="مانبريت كور"></div>
					<div class="profile__bio">
						<div class="title">By مانبريت كور <span class="dated">On Date 25/07/2017</span></div>
						<div class="yes-no">
							<ul>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(10,1);return false;" class="yes"><img src="/yokartv8/images/thumb-up.png" alt="Helpful"> (0) </a></li>
								<li><a href="javascript:undefined;" onclick="markReviewHelpful(&quot;10&quot;,0);return false;" class="no"><img src="/yokartv8/images/thumb-down.png" alt="Not Helpful"> (0) </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="reviews-desc">
					<div class="products__rating"> <i class="icn"><svg class="svg">
								<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
							</svg></i> <span class="rate">5</span> </div>
					<div class="cms">
						<p><strong>Impressed!!</strong></p>
						<p>
							<span class="lessText">Shipping was late :(  but product was exactly the same as pictures.....fabric, color , everything was perfect.</span>
													</p>
					</div>
				</div>
			</div>
		</div>
	</li>
	</ul>
<div class="align--center"><a href="/yokartv8/reviews/product/122" class="link">Showing All 2 Reviews </a></div>
<div class="gap"></div>
	<form name="frmSearchReviewsPaging"><input type="hidden" name="selprod_id" value="122"><input type="hidden" name="page" value=""><input type="hidden" name="pageSize" value="5"><input type="hidden" name="orderBy" value="most_helpful"><input type="hidden" name="fOutMode" value="json"><input type="hidden" name="fIsAjax" value="1"></form>

</div>
        <div id="loadMoreReviewsBtnDiv" class="reviews-lisitng"></div>
		 		
	</div>		
	</div>
</section>



 
<section>
 
	 <?php if($recommendedProducts){ ?> 	 
	 <section class="section bg--first-color">
		<?php include(CONF_THEME_PATH.'products/recommended-products.php'); ?>
	 </section>
	 <?php } ?>
     <?php if($relatedProductsRs){ ?>
	 <section class="section bg--second-color">
		 <?php include(CONF_THEME_PATH.'products/related-products.php'); ?>
	 </section>
	 <?php } ?>
      
	  <div id="recentlyViewedProductsDiv"></div>
 
<script type="text/javascript">
var mainSelprodId = <?php echo $product['selprod_id'];?>;
var layout = '<?php echo CommonHelper::getLayoutDirection();?>';

$("document").ready(function(){
	recentlyViewedProducts(<?php echo $product['selprod_id'];?>);
	zheight = $( window ).height() - 180;
	zwidth = $( window ).width()/2 - 50;

	if(layout == 'rtl'){
		$('.xzoom, .xzoom-gallery').xzoom({zoomWidth: zwidth, zoomHeight: zheight, title: true, tint: '#333',  position:'left'});
	}else{
		$('.xzoom, .xzoom-gallery').xzoom({zoomWidth: zwidth, zoomHeight: zheight, title: true, tint: '#333', Xoffset: 	2});
	}

	window.setInterval(function(){
		var scrollPos = $(window).scrollTop();
		if(scrollPos > 0){
		  setProductWeightage('<?php echo $product['selprod_code']; ?>');
		}
	}, 5000);
});

  <?php /* if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
$(function () {
	 if($(window).width()>1050){
            $(window).scroll(sticky_relocate);
				sticky_relocate();
			 }
        });
 <?php } */ ?>
</script>
<script>
	$(document).ready(function(){
		$("#btnAddToCart").addClass("quickView");
		$('#slider-for').slick( getSlickGallerySettings(false,'<?php echo CommonHelper::getLayoutDirection();?>') );
		$('#slider-nav').slick( getSlickGallerySettings(true,'<?php echo CommonHelper::getLayoutDirection();?>') );
		/* for toggling of tab/list view[ */
		$('.list-js').hide();
		$('.view--link-js').on('click',function(e) {
			$('.view--link-js').removeClass("btn--active");
			$(this).addClass("btn--active");
			if ($(this).hasClass('list')) {
				$('.tab-js').hide();
				$('.list-js').show();
			}
			else if($(this).hasClass('tab')) {
				$('.list-js').hide();
				$('.tab-js').show();
			}
		});
		/* ] */
		
		$('.social-toggle').on('click', function() {
		   setTimeout(function(){ $(this).next().toggleClass('open-menu'); }, 100);
		});
		
		


	});
</script> 
