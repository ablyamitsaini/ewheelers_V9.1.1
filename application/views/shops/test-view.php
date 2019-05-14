<div id="body" class="body template-10001" role="main">
	<section class="bg-shop">
		<div class="shop-banner" style="background-image: url(/yokartv8/images/shop-bg.jpg)" data-ratio="4:1"></div>
	</section>
	<section class="bg--second">
		<div class="container">
			<div class="shop-nav">

				<ul class="">
					<li class="is--active"><a href="/yokartv8/shops/view/1" class="ripplelink">Shop Store Home</a></li>
					<li class=""><a href="/yokartv8/shops/top-products/1" class="ripplelink">Shop Top Products</a></li>
					<li class=""><a href="/yokartv8/shops/collection/1" class="ripplelink">Shop Collection Eng</a></li>
					<li class=""><a href="/yokartv8/reviews/shop/1" class="ripplelink">Shop Review</a></li>
					<li class=""><a href="/yokartv8/shops/send-message/1" class="ripplelink">Shop Contact</a></li>
					<li class=""><a href="/yokartv8/shops/policy/1" class="ripplelink">Shop Policy</a></li>
				</ul>
			</div>
		</div>
	</section>
	<section class="pt-5 pb-3">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="breadcrumbs">
						<ul class="clearfix">
							<li><a href="/yokartv8">Home </a></li>
							<li>Test-view</li>
						</ul>
					</div>
					<div class="total-products">
						<span class="hide_on_no_product"><span id="total_records">2</span> Items Total</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div id="top-filters" class="page-sort hide_on_no_product">
						<ul>
							<li>
								<div class="save-search">
									<a href="javascript:void(0)" onclick="saveProductSearch()" class="btn btn--border"><i class="icn">
											<svg class="svg">
												<use xlink:href="/yokartv8/images/retina/sprite.svg#savesearch" href="/yokartv8/images/retina/sprite.svg#savesearch"></use>
											</svg>
										</i><span class="txt">Save Search</span></a></div>
							</li>
							<li>
								<select id="sortBy" title="" data-fatreq="{&quot;required&quot;:false}" name="sortBy">
									<option value="price_asc" selected="selected">Price (Low To High)</option>
									<option value="price_desc">Price (High To Low)</option>
									<option value="popularity_desc">Sort By Popularity</option>
									<option value="rating_desc">Sort By Rating</option>
								</select></li>
							<li>
								<select id="pageSize" title="" data-fatreq="{&quot;required&quot;:false}" name="pageSize">
									<option value="10" selected="selected">10 Items</option>
									<option value="25">25 Items</option>
									<option value="50">50 Items</option>
								</select></li>
							<li>
								<div class="list-grid-toggle switch--link-js  d-none d-md-block">
									<div class="icon">
										<div class="icon-bar"></div>
										<div class="icon-bar"></div>
										<div class="icon-bar"></div>
									</div>
								</div>
								<div class="d-lg-none">
									<a href="javascript:void(0)" class="link__filter btn btn--border"><i class="icn">
											<svg class="svg">
												<use xlink:href="/yokartv8/images/retina/sprite.svg#filter" href="/yokartv8/images/retina/sprite.svg#filter"></use>
											</svg>
										</i><span class="txt">Filter</span></a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="bg-gray rounded shop-information p-5 ">
						<div class="shop-logo"><img data-ratio="1:1 (150x150)" src="/yokartv8/image/shop-logo/1/1/SMALL" alt="Kanwar's Shop"></div>
						<div class="shop-info">
							<div class="shop-name">
								<h5>Kanwar's Shop <span class="blk-txt">Shop Opened On <strong> Jul 19, 2017 </strong></span></h5>
							</div>
							<div class="products__rating"> <i class="icn"><svg class="svg">
										<use xlink:href="/yokartv8/images/retina/sprite.svg#star-yellow" href="/yokartv8/images/retina/sprite.svg#star-yellow"></use>
									</svg></i> <span class="rate">2.7 Out Of 5 - <a href="/yokartv8/reviews/shop/1">1 Reviews</a> </span>
							</div>
							<div class="shop-btn-group">
								<a href="javascript:void(0)" onclick="toggleShopFavorite(1);" class="btn btn--primary btn--sm  " id="shop_1"><i class="icn"><svg class="svg">
											<use xlink:href="/yokartv8/images/retina/sprite.svg#heart" href="/yokartv8/images/retina/sprite.svg#heart"></use>
										</svg></i>Favorite Shop </a>
								<a href="/yokartv8/shops/report-spam/1" class="btn btn--primary btn--sm "><i class="icn"><svg class="svg">
											<use xlink:href="/yokartv8/images/retina/sprite.svg#report" href="/yokartv8/images/retina/sprite.svg#report"></use>
										</svg></i>Report Spam</a>

								<a href="/yokartv8/shops/send-message/1" class="btn btn--primary btn--sm "><i class="icn"><svg class="svg">
											<use xlink:href="/yokartv8/images/retina/sprite.svg#send-msg" href="/yokartv8/images/retina/sprite.svg#send-msg"></use>
										</svg></i>Send Message</a>
							</div>


						</div>
					</div>
					<div class="gap"></div>
					<div class="filters bg-gray rounded">
						<div class="filters__ele productFilters-js">
							<div class="product-search">

								<form name="frmSearch" method="post" id="frm_fat_id_frmSearch" onsubmit="searchProducts(this); return(false);"><input placeholder="Shop Search" class="input-field nofocus" title="Shop Search" data-fatreq="{&quot;required&quot;:false}" type="text" name="keyword" value=""><input name="btnSrchSubmit" value="" type="submit" class="input-submit"><input title="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="shop_id" value="1"><input title="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="join_price" value="0"></form>

							</div>
							<!--Filters[ -->
							<div class="widgets-head">
								<div class="widgets__heading filter-head-js">Filters <a class="reset-all" id="resetAll" style="display: none;"><i class="icn reset-all">
											<svg class="svg">
												<use xlink:href="/yokartv8/images/retina/sprite.svg#reset" href="/yokartv8/images/retina/sprite.svg#reset"></use>
											</svg>
										</i></a></div>
							</div>
							<div class="selected-filters" id="filters"> </div>
							<div class="divider--filters"></div>
							<!-- ] -->

							<!--Categories Filters[ resetAll-->


							<div class="widgets__heading filter-head-js">Categories </div>
							<div class="brands-list toggle-target scrollbar-filters" id="scrollbar-filters">
								<ul>
									<li>
										<label class="checkbox brand" id="prodcat_109"><input name="category" value="109" type="checkbox" data-title="Electronics"><i class="input-helper"></i>Electronics</label>
									</li>

									<li>
										<label class="checkbox brand" id="prodcat_112"><input name="category" value="112" type="checkbox" data-title="Men"><i class="input-helper"></i>Men</label>
									</li>

									<li>
										<label class="checkbox brand" id="prodcat_113"><input name="category" value="113" type="checkbox" data-title="Women"><i class="input-helper"></i>Women</label>
									</li>

									<li>
										<label class="checkbox brand" id="prodcat_156"><input name="category" value="156" type="checkbox" data-title="Baby &amp; Kids"><i class="input-helper"></i>Baby &amp; Kids</label>
									</li>

									<li>
										<label class="checkbox brand" id="prodcat_179"><input name="category" value="179" type="checkbox" data-title="Books"><i class="input-helper"></i>Books</label>
									</li>

								</ul>
								<!--<a onClick="alert('Pending')" class="btn btn--link ripplelink">View More </a> -->
							</div>

							<div class="divider--filters"></div>
							<!-- ] -->

							<!--Price Filters[ -->
							<div class="widgets__heading filter-head-js">Price (₹) </div>
							<div class="filter-content toggle-target">
								<div class="prices " id="perform_price">
									<span class="irs js-irs-0 irs-with-grid"><span class="irs"><span class="irs-line" tabindex="-1"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min" style="display: none;">0</span><span class="irs-max" style="display: none;">1</span><span class="irs-from" style="display: none; left: 0%;">0</span><span class="irs-to" style="display: none; left: 0%;">0</span><span class="irs-single" style="display: none; left: 0%;">0</span></span><span class="irs-grid" style="width: 92.6078%; left: 3.5961%;"><span class="irs-grid-pol" style="left: 0%"></span><span class="irs-grid-text js-grid-text-0" style="left: 0%; margin-left: -4.40452%;">843</span><span class="irs-grid-pol small" style="left: 20%"></span><span class="irs-grid-pol small" style="left: 15%"></span><span class="irs-grid-pol small" style="left: 10%"></span><span class="irs-grid-pol small" style="left: 5%"></span><span class="irs-grid-pol" style="left: 25%"></span><span class="irs-grid-text js-grid-text-1" style="left: 25%; visibility: visible; margin-left: -6.97125%;">33,400</span><span class="irs-grid-pol small" style="left: 45%"></span><span class="irs-grid-pol small" style="left: 40%"></span><span class="irs-grid-pol small" style="left: 35%"></span><span class="irs-grid-pol small" style="left: 30%"></span><span class="irs-grid-pol" style="left: 50%"></span><span class="irs-grid-text js-grid-text-2" style="left: 50%; visibility: visible; margin-left: -6.97125%;">65,958</span><span class="irs-grid-pol small" style="left: 70%"></span><span class="irs-grid-pol small" style="left: 65%"></span><span class="irs-grid-pol small" style="left: 60%"></span><span class="irs-grid-pol small" style="left: 55%"></span><span class="irs-grid-pol" style="left: 75%"></span><span class="irs-grid-text js-grid-text-3" style="left: 75%; visibility: visible; margin-left: -6.97125%;">98,515</span><span class="irs-grid-pol small" style="left: 95%"></span><span class="irs-grid-pol small" style="left: 90%"></span><span class="irs-grid-pol small" style="left: 85%"></span><span class="irs-grid-pol small" style="left: 80%"></span><span class="irs-grid-pol" style="left: 100%"></span><span class="irs-grid-text js-grid-text-4" style="left: 100%; margin-left: -8.02875%;">131,072</span></span><span class="irs-bar" style="left: 3.6961%; width: 92.6078%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-slider from" style="left: 0%;"></span><span class="irs-slider to" style="left: 92.6078%;"></span></span><input type="text" value="843-131073" name="price_range" id="price_range" class="irs-hidden-input" readonly="">
									<input type="hidden" value="843" name="filterDefaultMinValue" id="filterDefaultMinValue">
									<input type="hidden" value="131073" name="filterDefaultMaxValue" id="filterDefaultMaxValue">
								</div>
								<div class="clear"></div>
								<div class="slide__fields form">
									<div class="price-input">
										<div class="price-text-box">
											<input class="input-filter form-control " value="843" name="priceFilterMinValue" type="text">
											<span class="rsText">₹</span> </div>
									</div>
									<span class="dash"> - </span>
									<div class="price-input">
										<div class="price-text-box">
											<input value="131073" class="input-filter form-control " name="priceFilterMaxValue" type="text">
											<span class="rsText">₹</span> </div>
									</div>
								</div>
								<!--<input value="GO" class="btn " name="toVal" type="submit">-->
							</div>
							<div class="divider--filters"></div>
							<!-- ] -->


							<!--Brand Filters[ -->
							<div class="widgets__heading filter-head-js">Brand</div>
							<div class="scrollbar-filters" id="scrollbar-filters">
								<ul class="list-vertical">
									<li><label class="checkbox brand" id="brand_98"><input name="brands" value="98" type="checkbox"><i class="input-helper"></i>Allen Solly </label></li>
									<li><label class="checkbox brand" id="brand_95"><input name="brands" value="95" type="checkbox"><i class="input-helper"></i>Apple </label></li>
									<li><label class="checkbox brand" id="brand_111"><input name="brands" value="111" type="checkbox"><i class="input-helper"></i>Archies </label></li>
									<li><label class="checkbox brand" id="brand_99"><input name="brands" value="99" type="checkbox"><i class="input-helper"></i>Arrow </label></li>
									<li><label class="checkbox brand" id="brand_103"><input name="brands" value="103" type="checkbox"><i class="input-helper"></i>Asus </label></li>
									<li><label class="checkbox brand" id="brand_117"><input name="brands" value="117" type="checkbox"><i class="input-helper"></i>Avast </label></li>
									<li><label class="checkbox brand" id="brand_116"><input name="brands" value="116" type="checkbox"><i class="input-helper"></i>Candle </label></li>
									<li><label class="checkbox brand" id="brand_125"><input name="brands" value="125" type="checkbox"><i class="input-helper"></i>Consoles </label></li>
									<li><label class="checkbox brand" id="brand_115"><input name="brands" value="115" type="checkbox"><i class="input-helper"></i>Crayola </label></li>
									<li><label class="checkbox brand" id="brand_102"><input name="brands" value="102" type="checkbox"><i class="input-helper"></i>Dell </label></li>
									<li><label class="checkbox brand" id="brand_97"><input name="brands" value="97" type="checkbox"><i class="input-helper"></i>Diesel </label></li>
									<li><label class="checkbox brand" id="brand_114"><input name="brands" value="114" type="checkbox"><i class="input-helper"></i>Dream Dazzlers </label></li>
									<li><label class="checkbox brand" id="brand_108"><input name="brands" value="108" type="checkbox"><i class="input-helper"></i>Fab India </label></li>
									<li><label class="checkbox brand" id="brand_110"><input name="brands" value="110" type="checkbox"><i class="input-helper"></i>Faber Castell </label></li>
									<li><label class="checkbox brand" id="brand_113"><input name="brands" value="113" type="checkbox"><i class="input-helper"></i>Fast Lane </label></li>
									<li><label class="checkbox brand" id="brand_101"><input name="brands" value="101" type="checkbox"><i class="input-helper"></i>HP </label></li>
									<li><label class="checkbox brand" id="brand_94"><input name="brands" value="94" type="checkbox"><i class="input-helper"></i>Levi's </label></li>
									<li><label class="checkbox brand" id="brand_122"><input name="brands" value="122" type="checkbox"><i class="input-helper"></i>Louis Philippe </label></li>
									<li><label class="checkbox brand" id="brand_123"><input name="brands" value="123" type="checkbox"><i class="input-helper"></i>Microsoft </label></li>
									<li><label class="checkbox brand" id="brand_104"><input name="brands" value="104" type="checkbox"><i class="input-helper"></i>Nike </label></li>
									<li><label class="checkbox brand" id="brand_118"><input name="brands" value="118" type="checkbox"><i class="input-helper"></i>Norton </label></li>
									<li><label class="checkbox brand" id="brand_105"><input name="brands" value="105" type="checkbox"><i class="input-helper"></i>Ram Garments </label></li>
									<li><label class="checkbox brand" id="brand_121"><input name="brands" value="121" type="checkbox"><i class="input-helper"></i>Reebok </label></li>
									<li><label class="checkbox brand" id="brand_92"><input name="brands" value="92" type="checkbox"><i class="input-helper"></i>SONY </label></li>
									<li><label class="checkbox brand" id="brand_106"><input name="brands" value="106" type="checkbox"><i class="input-helper"></i>United colors of beneton </label></li>
									<li><label class="checkbox brand" id="brand_107"><input name="brands" value="107" type="checkbox"><i class="input-helper"></i>Vibes </label></li>
									<li><label class="checkbox brand" id="brand_120"><input name="brands" value="120" type="checkbox"><i class="input-helper"></i>Woodland </label></li>
									<li><label class="checkbox brand" id="brand_109"><input name="brands" value="109" type="checkbox"><i class="input-helper"></i>Xbox </label></li>
								</ul>
								<!--<a onClick="alert('Pending')" class="btn btn--link ripplelink">View More </a> -->
							</div>
							<div class="divider--filters"></div>
							<!-- ] -->

							<!-- Option Filters[ -->
							<!-- ]->

	<!--Condition Filters[ -->

							<div class="widgets__heading filter-head-js">Condition</div>
							<div>
								<ul class="list-vertical">
									<li><label class="checkbox condition" id="condition_1"><input value="1" name="conditions" type="checkbox"><i class="input-helper"></i>New </label></li>
								</ul>
							</div>
							<div class="divider--filters"></div>
							<!-- ] -->

							<!--Availability Filters[ -->
							<div class="widgets__heading filter-head-js">Availability</div>
							<div class="selected-filters toggle-target">
								<ul class="listing--vertical listing--vertical-chcek">
									<li><label class="checkbox availability" id="availability_1"><input name="out_of_stock" value="1" type="checkbox"><i class="input-helper"></i>Exclude Out Of Stock </label></li>
								</ul>
							</div>


						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="listing-products -listing-products ">
						<div id="productsList" role="main-listing" class="row product-listing">

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(135)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_135" data-id="135">
												<a href="javascript:void(0)" onclick="viewWishList(135,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Apple iPhone 7 (Gold, 32 GB)" href="/yokartv8/products/view/135">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/5/CLAYOUT3/135/0/1?1553535662" alt="Phones">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/170">Phones </a></div>
										<div class="products__title"><a title="Apple iPhone 7 (Gold, 32 GB)" href="/yokartv8/products/view/135">Apple iPhone 7 (Gold, 32 GB) </a></div>
										<div class="products__price"> ₹57,278.20 <span class="products__price_old"> ₹59,035.20</span>
											<div class="product_off">-3%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(115)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_115" data-id="115">
												<a href="javascript:void(0)" onclick="viewWishList(115,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Ico Blue Star Slim Women's Light Blue Jeans" href="/yokartv8/products/view/115">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/7/CLAYOUT3/115/0/1" alt="Clothing">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/123">Clothing </a></div>
										<div class="products__title"><a title="Ico Blue Star Slim Women's Light Blue Jeans" href="/yokartv8/products/view/115">Ico Blue Star Slim Women's Lig... </a></div>
										<div class="products__price"> ₹6,114.36 <span class="products__price_old"> ₹6,676.60</span>
											<div class="product_off">-8%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(47)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_47" data-id="47">
												<a href="javascript:void(0)" onclick="viewWishList(47,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Sony Playstation 4 500 GB" href="/yokartv8/products/view/47">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/11/CLAYOUT3/47/0/1" alt="Electronics">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/109">Electronics </a></div>
										<div class="products__title"><a title="Sony Playstation 4 500 GB" href="/yokartv8/products/view/47">Sony Playstation 4 500 GB </a></div>
										<div class="products__price"> ₹35,140.00 </div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(46)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_46" data-id="46">
												<a href="javascript:void(0)" onclick="viewWishList(46,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Macbook pro" href="/yokartv8/products/view/46">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/13/CLAYOUT3/46/0/1" alt="Electronics">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/109">Electronics </a></div>
										<div class="products__title"><a title="Macbook pro" href="/yokartv8/products/view/46">Macbook pro </a></div>
										<div class="products__price"> ₹131,072.20 </div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(43)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_43" data-id="43">
												<a href="javascript:void(0)" onclick="viewWishList(43,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Alienware laptop (Best in Gaming)" href="/yokartv8/products/view/43">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/17/CLAYOUT3/43/0/1" alt="Electronics">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/109">Electronics </a></div>
										<div class="products__title"><a title="Alienware laptop (Best in Gaming)" href="/yokartv8/products/view/43">Alienware laptop (Best in Gami... </a></div>
										<div class="products__price"> ₹130,018.00 <span class="products__price_old"> ₹140,560.00</span>
											<div class="product_off">-8%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(45)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_45" data-id="45">
												<a href="javascript:void(0)" onclick="viewWishList(45,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Asus ROG" href="/yokartv8/products/view/45">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/19/CLAYOUT3/45/0/1" alt="Electronics">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/109">Electronics </a></div>
										<div class="products__title"><a title="Asus ROG" href="/yokartv8/products/view/45">Asus ROG </a></div>
										<div class="products__price"> ₹124,044.20 </div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(82)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_82" data-id="82">
												<a href="javascript:void(0)" onclick="viewWishList(82,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Xbox One" href="/yokartv8/products/view/82">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/27/CLAYOUT3/82/0/1" alt="Electronics">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/109">Electronics </a></div>
										<div class="products__title"><a title="Xbox One" href="/yokartv8/products/view/82">Xbox One </a></div>
										<div class="products__price"> ₹35,140.00 </div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(109)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_109" data-id="109">
												<a href="javascript:void(0)" onclick="viewWishList(109,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Candle Gold Geniun Lace Up Shoes  (Black)" href="/yokartv8/products/view/109">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/32/CLAYOUT3/109/0/1" alt="Footwears">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/124">Footwears </a></div>
										<div class="products__title"><a title="Candle Gold Geniun Lace Up Shoes  (Black)" href="/yokartv8/products/view/109">Candle Gold Geniun Lace Up Sho... </a></div>
										<div class="products__price"> ₹5,060.16 <span class="products__price_old"> ₹5,973.80</span>
											<div class="product_off">-15%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(122)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_122" data-id="122">
												<a href="javascript:void(0)" onclick="viewWishList(122,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Micky Mouse Toy" href="/yokartv8/products/view/122">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/42/CLAYOUT3/122/0/1" alt="Baby &amp; Kids">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/150">Baby &amp; Kids </a></div>
										<div class="products__title"><a title="Micky Mouse Toy" href="/yokartv8/products/view/122">Micky Mouse Toy </a></div>
										<div class="products__price"> ₹6,676.60 <span class="products__price_old"> ₹7,028.00</span>
											<div class="product_off">-5%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>

							<div class="col-md-3 col-6 column">
								<!--product tile-->
								<div class="products">
									<div class="products__quickview"> <a onclick="quickDetail(83)" class="modaal-inline-content"></a> </div>
									<div class="products__body">
										<div class="favourite-wrapper ">
											<div class="favourite heart-wrapper wishListLink-Js " id="listDisplayDiv_83" data-id="83">
												<a href="javascript:void(0)" onclick="viewWishList(83,this,event);" title="Add Product To Your Wishlist">
													<div class="ring"></div>
													<div class="circles"></div>
												</a>
											</div>


										</div>
										<div class="products__img">
											<a title="Cot Hanging for Kids" href="/yokartv8/products/view/83">
												<img data-ratio="1:1 (500x500)" src="/yokartv8/image/product/43/CLAYOUT3/83/0/1" alt="Baby &amp; Kids">
											</a>
										</div>
									</div>
									<div class="products__footer">

										<div class="products__category"><a href="/yokartv8/category/view/150">Baby &amp; Kids </a></div>
										<div class="products__title"><a title="Cot Hanging for Kids" href="/yokartv8/products/view/83">Cot Hanging for Kids </a></div>
										<div class="products__price"> ₹8,433.60 <span class="products__price_old"> ₹10,050.04</span>
											<div class="product_off">-16%</div>
										</div>

									</div>
								</div>
								<!--/product tile-->
							</div>
							<form name="frmProductSearchPaging" id="frmProductSearchPaging"><input type="hidden" name="" value=""><input type="hidden" name="shop_id" value="1"><input type="hidden" name="page" value="1"></form>
							<div class="gap"></div>
							<ul class="pagination pagination--center">
								<li class="selected"><a href="javascript:void(0);">1</a></li>
								<li><a href="javascript:void(0);" onclick="goToProductListingSearchPage(2);">2</a></li>
								<li><a href="javascript:void(0);">...</a></li>
								<li class="next"><a href="javascript:void(0);" onclick="goToProductListingSearchPage(2);"><i class="fa fa-angle-right"></i></a></li>
								<li class="forward"><a href="javascript:void(0);" onclick="goToProductListingSearchPage(3);"><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
