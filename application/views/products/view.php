<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class', 'qty-input cartQtyTextBox productQty-js');
$buyQuantity->addFieldTagAttribute('data-page', 'product-view');

$rentalAvailableDate = date('Y-m-d');
if(!empty($extendedOrderData)) {
	$rentalAvailableDate = $extendedOrderData['opd_rental_end_date'];
	//$rentalAvailableDate = date('Y-m-d H:i:s', strtotime('+1 '));
}

?>
<div id="body" class="body detail-page" role="main">
    <section class="">
        <div class="container">
            <div class="section">
                <div class="breadcrumbs breadcrumbs--center">
                    <?php  $this->includeTemplate('_partial/custom/header-breadcrumb.php');  ?>
                </div>
            </div>
            <div class="detail-wrapper">
                <div class="detail-first-fold ">
                    <div class="row justify-content-between">
                        <div class="col-lg-7 relative">
                            <div id="img-static" class="product-detail-gallery">
                                <?php $data['product'] = $product;
                                    $data['productImagesArr'] = $productImagesArr;
                                    $data['imageGallery'] = true;
                                    /* $this->includeTemplate('products/product-gallery.php',$data,false); */ ?>
                                <div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-for">
                                    <?php if ($productImagesArr) { ?>
                                    <?php foreach ($productImagesArr as $afile_id => $image) {
                                        $originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
                                        $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
                                        $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                                    <img class="xzoom active" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
                                    <?php break;
                                    } ?>
                                    <?php } else {
                                        $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 )), CONF_IMG_CACHE_TIME, '.jpg');
                                        $originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'ORIGINAL', 0 )), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                                    <img class="xzoom" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
                                    <?php
                                    } ?>
                                </div>
                                <?php if ($productImagesArr) { ?>
                                <div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-nav">
                                    <?php foreach ($productImagesArr as $afile_id => $image) {
                                        $originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
                                        $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
                                        /* $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */ ?>
                                    <div class="thumb"><a href="<?php echo $originalImgUrl; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>"></a></div>
                                    <?php
                                    } ?>
                                </div>
                                <?php } ?>


                        </div>
						</div>
                        <div class="col-lg-5 col-details-right">
                            <div class="product-description">
                                <div class="product-description-inner">
                                    <div class="">
                                        <div class="products__title">
                                            <div clss="">
											<h2><?php echo $product['selprod_title'];?></h2>
											 <div class="favourite-wrapper favourite-wrapper-detail ">
                                <?php include(CONF_THEME_PATH.'_partial/collection-ui.php'); ?>
                                <div class="share-button">
                                    <a href="javascript:void(0)" class="social-toggle"><i class="icn">
                                            <svg class="svg">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"></use>
                                            </svg>
                                        </i></a>
                                    <div class="social-networks">
                                        <ul>
                                            <li class="social-facebook">
                                                <a class="st-custom-button" data-network="facebook" data-url="<?php echo CommonHelper::generateFullUrl('Products', 'view', array($product['selprod_id'])); ?>/">
                                                    <i class="icn"><svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"></use>
                                                        </svg></i>
                                                </a>
                                            </li>
                                            <li class="social-twitter">
                                                <a class="st-custom-button" data-network="twitter">
                                                    <i class="icn"><svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"></use>
                                                        </svg></i>
                                                </a>
                                            </li>
                                            <li class="social-pintrest">
                                                <a class="st-custom-button" data-network="pinterest">
                                                    <i class="icn"><svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"></use>
                                                        </svg></i>
                                                </a>
                                            </li>
                                            <li class="social-email">
                                                <a class="st-custom-button" data-network="email">
                                                    <i class="icn"><svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"></use>
                                                        </svg></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
											</div>
                                            <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                                            <?php /*if (round($product['prod_rating']) > 0) {*/ ?>
                                            <?php $label = (round($product['prod_rating']) > 0) ? round($product['totReviews'], 1).' '.Labels::getLabel('LBL_Reviews', $siteLangId) : Labels::getLabel('LBL_No_Reviews', $siteLangId); ?>
                                            <div class="products-reviews">
											<div class="products__rating">
											<i class="icn"><svg class="svg">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                                            </svg>
											</i>
                                            <span class="rate"><?php echo round($product['prod_rating'], 1);?></span>
											</div>
                                            <a href="#itemRatings" class="totals-review link nav-scroll-js"><?php echo $label; ?></a>
                                            </div>
                                            <?php /*}*/ ?>
                                            <?php /* if (round($product['prod_rating']) == 0) {  ?>
                                            <span class="be-first"> <a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span>
                                            <?php } */ ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="brand-data"><span class="txt-gray-light"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?>:</span> <?php echo $product['brand_name'];?></div>
									<!-- [ REntal Functionality -->
									<div class="row product-type-tabs-container mb-4">
										<?php if (ALLOW_RENT > 0 && $product['is_rent'] > 0) { ?>
										<div class="col-sm-6">
											<a href="javascript:void(0);" class="product-type-tabs active product-type-tabs--js" data-productfor="<?php echo applicationConstants::PRODUCT_FOR_RENT; ?>" >
												<span class="sticky-title"><?php echo Labels::getLabel('LBL_For_Rental', $siteLangId);?></span>
												<span class="sticky-price">
                                                <span>
													<?php echo CommonHelper::displayMoneyFormat($product['rent_price']); ?>
												</span>
                                                <span class="sticky-sub-price"> 
													<?php echo $rentalTypeArr[$product['rental_type']];?> </span>
												</span>
											</a>
										</div>
										<?php } ?>
										<?php if (ALLOW_SALE > 0 && $product['is_sell'] > 0 && $orderProdId < 1) { ?>
										<div class="col-sm-6">
											<a href="javascript:void(0);" class="product-type-tabs product-type-tabs--js <?php echo ( $product['is_rent'] < 1) ? 'active' : '';?>" data-productfor="<?php echo applicationConstants::PRODUCT_FOR_SALE; ?>">
												<span class="sticky-title"><?php echo Labels::getLabel('LBL_For_Sale', $siteLangId);?></span>
												<span class="sticky-price">
                                                <span>
													<?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>
													<?php if($product['special_price_found']){ ?>
													<span class="products__price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
													<span class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
													<?php }?>
												</span>
                                                <span class="sticky-sub-price"> 
													<?php echo Labels::getLabel('LBL_Retail', $siteLangId);?> 
												</span>
												</span>
											</a>
										</div>
										
										<?php 
										} ?>
									</div>
									<?php if ($product['is_rent'] > 0 && ALLOW_RENT > 0) { ?>
									<div class="row align-items-end rental-fields--js mb-4">
										<div class="col-sm-12 cms">
											<table>
												<tr>
													<th><?php echo Labels::getLabel('LBL_Retail_Security', $siteLangId);?></th>
													<td><?php echo CommonHelper::displayMoneyFormat($product['sprodata_rental_security']); ?>
													</td>
												</tr>	
												<tr>	
													<th><?php echo Labels::getLabel('LBL_Minimum_Rental_Duration', $siteLangId);?></th>
													<td><?php echo $product['sprodata_minimum_rental_duration'];?></td>
												</tr>
											</table>
										</div>
									</div>
									<?php } ?>
									
									
									<?php if (ALLOW_SALE > 0 && $product['is_sell'] > 0) { ?>
										<?php if($is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1 && ($product['selprod_book_now_enable'] == applicationConstants::BOTH || $product['selprod_book_now_enable'] == applicationConstants::BOOK_NOW)){				
										$bookPrice = ($booking_percentage / 100) * $product['theprice'];
										?>	
											<div class="row align-items-end mb-4 sale-products--js <?php echo (ALLOW_RENT > 0 && $product['is_rent'] > 0) ? 'hide-sell-section' : '';?> ">
												<div class="col-sm-12 cms">
													<table>
														<tr>
															<th><?php echo Labels::getLabel('LBL_Booking_Price', $siteLangId);?></th>
															<td><?php echo CommonHelper::displayMoneyFormat($bookPrice); ?>
															</td>
														</tr>	
													</table>
												</div>
											</div>
										<?php } 
									 } ?>
									<!-- REntal Functionality ]-->
									
									<!--<div class="detail-grouping">
                                        <div class="products__category"><a href="<?php echo CommonHelper::generateUrl('Category', 'View', array($product['prodcat_id']));?>"><?php echo $product['prodcat_name'];?> </a></div>
                                    </div>-->

                                    <?php /* include(CONF_THEME_PATH.'_partial/product-listing-head-section.php'); */ ?>

                                    <?php  if ($shop['shop_free_ship_upto'] > 0 && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
                                    <?php $freeShipAmt = CommonHelper::displayMoneyFormat($shop['shop_free_ship_upto']); ?>
                                    <div class="note-messages"><?php echo str_replace('{amount}', $freeShipAmt, Labels::getLabel('LBL_Free_shipping_up_to_{amount}_purchase', $siteLangId));?></div>
                                    <?php }?>
                                    <div class="divider"></div>
                                    <?php if (!empty($optionRows)) { ?>
                                    <div class="gap"> </div>
                                    <div class="row">
                                        <?php $selectedOptionsArr = $product['selectedOptionValues'];
                                /*CommonHelper::printArray($selectedOptionsArr);
                                CommonHelper::printArray($optionRows);*/
                                $count = 0;
                                foreach ($optionRows as $key => $option) {
                                    $selectedOptionValue = $option['values'][$selectedOptionsArr[$key]]['optionvalue_name'];
                                    $selectedOptionColor = $option['values'][$selectedOptionsArr[$key]]['optionvalue_color_code']; ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="h6"><?php echo $option['option_name']; ?></div>
                                            <div class="js-wrap-drop wrap-drop" id="js-wrap-drop<?php echo $count; ?>">
                                                <span>
                                                    <?php if ($option['option_is_color']) { ?>
                                                    <span class="colors" style="background-color:#<?php echo $selectedOptionColor; ?>; ?>;"></span>
                                                    <?php } ?>
                                                    <?php echo $selectedOptionValue; ?></span>
                                                <?php if ($option['values']) { ?>
                                                <ul class="drop">
                                                    <?php foreach ($option['values'] as $opVal) {
                                                $isAvailable = true;
                                                if (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) {
                                                    $optionUrl = CommonHelper::generateUrl('Products', 'view', array($product['selprod_id']));
                                                } else {
                                                    $optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
                                                    $optionUrlArr = explode("::", $optionUrl);
                                                    if (is_array($optionUrlArr) && count($optionUrlArr) == 2) {
                                                        $optionUrl = $optionUrlArr[0];
                                                        $isAvailable = false;
                                                    }
                                                } ?>
                                                    <li class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' selected' : ' ';
                                            echo (!$optionUrl) ? ' is-disabled' : '';
                                            echo (!$isAvailable) ? 'not--available':''; ?>">
                                                        <?php if ($option['option_is_color'] && $opVal['optionvalue_color_code'] != '') { ?>
                                                        <a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name'];
                                                    echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>" class="<?php echo (!$option['option_is_color']) ? 'selector__link' : '';
                                                    echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' ' : ' ';
													echo (!$optionUrl) ? ' is-disabled' : '';  ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>"> <span class="colors"
                                                                style="background-color:#<?php echo $opVal['optionvalue_color_code']; ?>;"></span><?php echo $opVal['optionvalue_name'];?></a>
                                                        <?php } else { ?>
                                                        <a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name'];
														echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>"
                                                            class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? '' : ' '; echo (!$optionUrl) ? ' is-disabled' : '' ?>"
                                                            href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>">
                                                            <?php echo $opVal['optionvalue_name'];  ?> </a>
                                                        <?php } ?>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php $count++;
                                }?>
                                    </div>
                                    <?php }?>

                                    <?php /*if (count($productSpecifications) > 0) { ?>
                                    <div class="gap"></div>
                                    <div class="box box--gray box--radius box--space">
                                        <div class="h6"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?>:</div>
                                        <div class="list list--specification">
                                            <ul>
                                                <?php $count=1;
                                    foreach ($productSpecifications as $key => $specification) {
                                        if ($count > 5) {
                                            continue;
                                        } ?>
                                                <li><?php echo '<span>'.$specification['prodspec_name']." :</span> ".$specification['prodspec_value']; ?></li>
                                                <?php $count++;
                                    } ?>
                                                <?php if (count($productSpecifications)>5) { ?>
                                                <li class="link_li"><a href="javascript:void()"><?php echo Labels::getLabel('LBL_View_All_Details', $siteLangId); ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php }*/?>

                                    <!-- Add To Cart [ -->
								<?php if ($product['in_stock'] ||  $product['sprodata_rental_stock'] > 0) {
                                echo $frmBuyProduct->getFormTag();
                                $qtyField =  $frmBuyProduct->getField('quantity');
                                $qtyFieldName =  $qtyField->getCaption();
								$extendOrderId = 0;
								
								if($frmBuyProduct->getField('extend_order')) {
									$extOrderFld = $frmBuyProduct->getField('extend_order');
									$extendOrderId = $extOrderFld->value;
								}
									
								if (strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) {
								if ($product['is_rent'] > 0 && ALLOW_RENT > 0) {
									$rentalStartDateFld = $frmBuyProduct->getField('rental_start_date');
									$rentalEndDateFld = $frmBuyProduct->getField('rental_end_date');
									$rentalStartDateName = $rentalStartDateFld->getCaption();
									$rentalEndDateName = $rentalEndDateFld->getCaption();
									if ($product['rental_type'] == applicationConstants::RENT_TYPE_HOUR) {
										$rentalStartDateFld->addFieldTagAttribute('class', 'rental_start_datetime');
										$rentalEndDateFld->addFieldTagAttribute('class', 'rental_end_datetime');
									} else {
										$rentalStartDateFld->addFieldTagAttribute('class', 'rental_start_date');
										$rentalEndDateFld->addFieldTagAttribute('class', 'rental_end_date');
									}
									if ($extendOrderId > 0) {
										$rentalStartDateFld->addFieldTagAttribute('disabled', 'true');
										$qtyField->addFieldTagAttribute('disabled', 'true');
									}
									$rentalStartDateFld->addFieldTagAttribute('onChange', 'getRentalDetails()');
									$rentalEndDateFld->addFieldTagAttribute('onChange', 'getRentalDetails()');

									
								?>
								<div class="row align-items-end rental-fields--js mb-3">
									<div class="col-sm-6">
                                        <div class="form__group form__group-select">
                                            <label class="h6"><?php echo $rentalStartDateName; ?></label>
                                            <?php echo $frmBuyProduct->getFieldHtml('rental_start_date'); ?>
                                        </div>
                                    </div>
								
									<div class="col-sm-6">
                                        <div class="form__group form__group-select">
                                            <label class="h6"><?php echo $rentalEndDateName; ?></label>
                                            <?php echo $frmBuyProduct->getFieldHtml('rental_end_date'); ?>
                                        </div>
                                    </div>
								</div>
								<?php }
								if ($product['is_rent'] > 0 && ALLOW_RENT > 0) { ?>
								<div class="row align-items-end mb-3 rental-fields--js ">
                                    <div class="col-xl-4 col-lg-5 col-md-5 mb-2">
                                        <div class="form__group form__group-select">
                                            <label class="h6"><?php echo $qtyFieldName; ?></label>
                                            <div class="qty-wrapper">
                                                <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                                                    <span class="decrease <?php echo ($extendOrderId < 1)? 'decrease-js' :'';?> ">-</span>
                                                    <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                                        <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                                                    </div>
                                                    <span class="increase <?php echo ($extendOrderId < 1)? 'increase-js' :'';?> ">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 mb-2">
                                        <label class="h6">&nbsp;</label>
                                        <div class="buy-group">
                                        <?php if (strtotime($product['selprod_available_from']) <= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) {
                                            echo $frmBuyProduct->getFieldHtml('btnProductBuy');
                                            echo $frmBuyProduct->getFieldHtml('btnAddToCart');
                                        }
                                       
                                        echo $frmBuyProduct->getFieldHtml('selprod_id');
										echo $frmBuyProduct->getFieldHtml('product_for');
										echo $frmBuyProduct->getFieldHtml('extend_order');
										?>
                                        </div>
                                    </div>
                                </div>
								<?php 
								}
								
								if ($product['is_sell'] > 0 && ALLOW_SALE > 0) {
									
									if($product['selprod_book_now_enable'] == applicationConstants::BOTH && $is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1 && $product['selprod_test_drive_enable'] == 1){
											$button_class = 'row-flexible4';
										}elseif($product['selprod_book_now_enable'] == applicationConstants::BUY_NOW && $product['selprod_test_drive_enable'] == 1){
											$button_class = 'row-flexible';
										}elseif($product['selprod_book_now_enable'] == applicationConstants::BOTH && $is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1 ){
											$button_class = 'row-flexible';			
										}elseif($product['selprod_test_drive_enable'] == 1 && $product['selprod_book_now_enable'] == applicationConstants::BOOK_NOW && $is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1){
											$button_class = '';
										}elseif($product['selprod_test_drive_enable'] == 1){
											$button_class = 'row-flexible';
										}else{
											$button_class = '';
										}
								?>
								<div class="row align-items-end mb-3 <?php echo $button_class;?> sale-products--js <?php echo (ALLOW_RENT > 0 && $product['is_rent'] > 0) ? 'hide-sell-section' : '';?> ">
                                    <div class="col-xl-4 col-lg-5 col-md-5 mb-2">
                                        <div class="form__group form__group-select">
                                            <label class="h6"><?php echo $qtyFieldName; ?></label>
                                            <div class="qty-wrapper">
                                                <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                                                    <span class="decrease <?php echo ($extendOrderId < 1)? 'decrease-js' :'';?> ">-</span>
                                                    <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                                        <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                                                    </div>
                                                    <span class="increase <?php echo ($extendOrderId < 1)? 'increase-js' :'';?> ">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 mb-2">
                                        <label class="h6">&nbsp;</label>
                                        <div class="buy-group">
                                        <?php if (strtotime($product['selprod_available_from']) <= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) {
                                            if($product['selprod_book_now_enable'] == applicationConstants::BOTH && $is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1){
													echo $frmBuyProduct->getFieldHtml('btnAddToCart');
													echo $frmBuyProduct->getFieldHtml('btnProductBuy');
													echo $frmBuyProduct->getFieldHtml('btnBookNow');
													
												}elseif($product['selprod_book_now_enable'] == applicationConstants::BUY_NOW){
													echo $frmBuyProduct->getFieldHtml('btnAddToCart');
													echo $frmBuyProduct->getFieldHtml('btnProductBuy');
												}elseif($product['selprod_book_now_enable'] == applicationConstants::BOOK_NOW && $is_booking == 1 && FatApp::getConfig('CONF_ENABLE_BOOK_NOW_MODULE') == 1){
													echo $frmBuyProduct->getFieldHtml('btnBookNow');
												}else{
													echo $frmBuyProduct->getFieldHtml('btnAddToCart');
													echo $frmBuyProduct->getFieldHtml('btnProductBuy');
												}
												
												if($product['selprod_test_drive_enable']){
													echo $frmBuyProduct->getFieldHtml('btnTestDrive');
											}
                                        }
                                       
                                        echo $frmBuyProduct->getFieldHtml('selprod_id');
										echo $frmBuyProduct->getFieldHtml('product_for');
										echo $frmBuyProduct->getFieldHtml('extend_order');
										?>
                                        </div>
                                    </div>
                                </div>
                                <?php }
								} ?>
								<?php if ($product['is_rent'] > 0 && ALLOW_RENT > 0) { ?>
								<div class="row align-items-end rental-fields--js mb-3">
									<div class="col-sm-12 mb-3">
										<p>
											<span><?php echo Labels::getLabel('LBL_Available_Quanity:', $siteLangId); ?></span> 
											<span class="rental-stock--js"><?php echo $product['sprodata_rental_stock']; ?></span>
										</p>
										<p>
											<small class="text-danger"><?php echo Labels::getLabel('LBL_Note:', $siteLangId); ?></small>
											<small><?php echo Labels::getLabel('LBL_Available_Quantity_May_Vary_According_to_The_Selected_Dates', $siteLangId); ?></small>
										</p>
									</div>
									<div class="col-sm-12">
									<div class="sold-by bg-gray p-4 rounded">
										<div class="row align-items-center justify-content-between">
											<div class="col-xl-12 col-lg-12 col-md-12">
												<h6 class="m-0 -color-light"> <strong><?php echo Labels::getLabel('LBL_Enter_Start_Date_And_End_Date_to_Calculate_Rental_Price', $siteLangId); ?> </strong>
												</h6>
												<p class="mt-2">
													<small><?php echo Labels::getLabel('LBL_Rental_Price', $siteLangId); ?>:</small>  
													<small class="rental-price--js"><?php 
													echo CommonHelper::displayMoneyFormat($product['rent_price']);
													?></small> + 
													<small><?php echo Labels::getLabel('LBL_Rental_Security', $siteLangId); ?>:</small>  
													<small class="rental-security--js"><?php
													echo CommonHelper::displayMoneyFormat($product['sprodata_rental_security']);
													?></small>
												</p>
												<h6 class="mt-2 -color-light"><strong><?php echo Labels::getLabel('LBL_Total_Payment', $siteLangId); ?> : <span class="total-amount--js"><?php $total = $product['rent_price'] + $product['sprodata_rental_security']; 
												echo CommonHelper::displayMoneyFormat($total);
												?></span></strong>
												</h6>
											</div>
										</div>
									</div>
									</div>
								</div>
								<?php } ?>
                                <div class="gap"></div>

                                </form>
                                <?php echo $frmBuyProduct->getExternalJs();?>
								<div id="testDrivefrm"></div>
								<?php
								
                                } else { ?>
                                    <div class="sold">
                                        <h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></h3>
                                        <p class="text--normal-secondary"><?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?></p>
                                    </div>
                                <?php } ?>
                                <?php if (strtotime($product['selprod_available_from'])> strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) { ?>
                                    <div class="sold">
                                        <h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Not_Available', $siteLangId); ?></h3>
                                        <p class="text--normal-secondary">
                                            <?php echo str_replace('{available-date}', FatDate::Format($product['selprod_available_from']), Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?>
                                        </p>
                                    </div>
                                <?php }?>
                                    <!-- ] -->
								<?php /* if ($product['product_upc']!='') { ?>
                                <div class="gap"></div>
                                <div><?php echo Labels::getLabel('LBL_EAN/UPC_code', $siteLangId).' : '.$product['product_upc'];?></div>
                                <?php } */ ?>

                            <?php /* Volume Discounts[ */
                            if (isset($volumeDiscountRows) && !empty($volumeDiscountRows) && $product['in_stock'] && (ALLOW_SALE > 0 && $product['is_sell'] > 0)) { ?>
							
							<div class="sale-products--js <?php echo (ALLOW_RENT > 0 && $product['is_rent'] > 0) ? 'hide-sell-section' : '';?>" >
                                <div class="gap"></div>
                                <div class="h6">
									<?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)', $siteLangId); ?>:
								</div>
                                <ul class="<?php echo (count($volumeDiscountRows) > 1) ? 'js--discount-slider' : ''; ?> discount-slider" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                                <?php foreach ($volumeDiscountRows as $volumeDiscountRow) {
									$volumeDiscount = $product['theprice'] * ($volumeDiscountRow['voldiscount_percentage'] / 100);
									$price = ($product['theprice'] - $volumeDiscount); ?>
                                    <li>
										<div class="qty__value">
											<?php echo($volumeDiscountRow['voldiscount_min_qty']); ?> 
											<?php echo Labels::getLabel('LBL_Or_more', $siteLangId); ?> 
											(<?php echo $volumeDiscountRow['voldiscount_percentage'].'%'; ?>) <span class="item__price">
											<?php echo CommonHelper::displayMoneyFormat($price); ?> / 
											<?php echo Labels::getLabel('LBL_Product', $siteLangId); ?>
											</span>
										</div>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
							<script type="text/javascript">
                                $("document").ready(function() {
                                    $('.js--discount-slider').slick(getSlickSliderSettings(2, 1, langLbl.layoutDirection, false, {1199: 2,1023: 2,767: 1,480: 1}));
								});
							</script>								
                            <?php } /* ] */ ?>
							
							<?php /* Duration Discounts[ */
                            if (isset($durationDiscountRows) && !empty($durationDiscountRows) && $product['in_stock'] && (ALLOW_RENT > 0 && $product['is_rent'] > 0)) { ?>
							<div class="rental-fields--js" >
                                <div class="gap"></div>
                                <div class="h6">
									<?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)', $siteLangId); ?>:
								</div>
                                <ul class="<?php echo (count($durationDiscountRows) > 1) ? 'js--duration-discount-slider' : ''; ?> discount-slider" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                                <?php foreach ($durationDiscountRows as $discountRow) {
									$durationDiscount = $product['rent_price'] * ($discountRow['produr_discount_percent'] / 100);
									$price = ($product['rent_price'] - $durationDiscount); ?>
                                    <li>
										<div class="qty__value">
											<?php echo($discountRow['produr_rental_duration']); ?> 
											<?php echo Labels::getLabel('LBL_Or_more', $siteLangId); ?> 
											(<?php echo $discountRow['produr_discount_percent'].'%'; ?>) <span class="item__price">
											<?php echo CommonHelper::displayMoneyFormat($price); ?> / 
											<?php echo Labels::getLabel('LBL_Product', $siteLangId); ?>
											</span>
										</div>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
							<script type="text/javascript">
                                $("document").ready(function() {
                                    $('.js--duration-discount-slider').slick(getSlickSliderSettings(2, 1, langLbl.layoutDirection, false, {1199: 2,1023: 2,767: 1,480: 1}));
								});
							</script>								
                            <?php } /* ] */ ?>
							<!-- Upsell Products [ -->
                            <?php if (count($upsellProducts)>0 && ALLOW_SALE > 0 && $product['is_sell'] > 0) { ?>

							<div class="sale-products--js <?php echo (ALLOW_RENT > 0 && $product['is_rent'] > 0) ? 'hide-sell-section' : '';?>">

                                <div class="gap"></div>
                                <div class="h6"><?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?></div>
                                    <div class="addons-scrollbar" data-simplebar>
                                        <table class="table cart--full cart-tbl cart-tbl-addons">
                                            <tbody>
                                                <?php  foreach ($upsellProducts as $usproduct) {
												$cancelClass ='';
												$uncheckBoxClass='';
												if ($usproduct['selprod_stock'] <= 0) {
													$cancelClass ='cancelled--js';
													$uncheckBoxClass ='remove-add-on';
												} ?>
                                                <tr>
                                                    <td class="<?php echo $cancelClass; ?>">
                                                        <figure class="item__pic">
														<a title="<?php echo $usproduct['selprod_title']; ?>" href="<?php echo CommonHelper::generateUrl('products', 'view', array($usproduct['selprod_id']))?>">
															<img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($usproduct['product_id'], 'MINI', $usproduct['selprod_id'] )), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $usproduct['product_identifier']; ?>"> 
														</a>
														</figure>
                                                    </td>
                                                    <td class="<?php echo $cancelClass; ?>">
                                                        <div class="item__description">
                                                            <div class="item__title">
															<a href="<?php echo CommonHelper::generateUrl('products', 'view', array($usproduct['selprod_id']))?>">
															<?php echo $usproduct['selprod_title']?>
															</a>
															</div>
                                                        </div>
                                                        <?php if ($usproduct['selprod_stock'] <= 0) { ?>
														<div class="addon--tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></div>
														<?php  } ?>
														<div class="item__price"><?php echo CommonHelper::displayMoneyFormat($usproduct['theprice']); ?></div>
                                                    </td>

                                                    <td class="<?php echo $cancelClass; ?>">
                                                        <div class="qty-wrapper">
                                                            <div class="quantity" data-stock="<?php echo $usproduct['selprod_stock']; ?>"><span class="decrease decrease-js">-</span>
                                                                <div class="qty-input-wrapper" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                                                    <input type="text" value="1" data-page="product-view" placeholder="Qty" class="qty-input cartQtyTextBox productQty-js" lang="addons[<?php echo $usproduct['selprod_id']?>]"
                                                                        name="addons[<?php echo $usproduct['selprod_id']?>]">
                                                                </div>
                                                                <span class="increase increase-js">+</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="<?php echo $cancelClass; ?>">
														<label class="checkbox">
                                                            <input <?php if ($usproduct['selprod_stock'] > 0) { ?> checked="checked" <?php } ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass; ?>" id="check_addons" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                                                            <i class="input-helper"></i> 
														</label>
                                                    </td>
                                                </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    </div>
								</div>
                                    <?php } ?>
                                    <!-- ] -->
								</div>
                                <div class="gap"></div>
                                <div class="sold-by bg-gray p-4 rounded">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-xl-6 col-lg-6 col-md-5">
                                            <div class="h6 m-0 -color-light"><?php echo Labels::getLabel('LBL_Seller', $siteLangId);?></div>
                                            <h6 class="m-0">
                                                <a href="<?php echo CommonHelper::generateUrl('shops', 'View', array($shop['shop_id'])); ?>"><?php echo $shop['shop_name'];?></a>
                                                <div class="products__rating -display-inline m-0">
                                                    <?php if (0 < FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                                                        - <i class="icn">
                                                            <svg class="svg">
                                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                                                            </svg>
                                                        </i> 
                                                        <span class="rate"><?php echo round($shop_rating,1),'','', '';  if($shopTotalReviews){ ?><?php } ?> </span>
                                                    <?php } ?>
                                                </div>
											</h6>
											<?php /*if ($shop_rating>0) { ?>
                                            <div class="products__rating"> <i class="icn"><svg class="svg">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                                                    </svg></i> <span class="rate"><?php echo round($shop_rating, 1); ?><span></span></span>
                                            </div><br>
                                            <?php }*/?>

                                        </div>
                                        <div class="col-auto">
                                            <?php if (!UserAuthentication::isUserLogged() || (UserAuthentication::isUserLogged() && ((User::isBuyer()) || (User::isSeller() )) && (UserAuthentication::getLoggedUserId()!=$shop['shop_user_id']))) { ?>
                                            <a href="<?php echo CommonHelper::generateUrl('shops', 'sendMessage', array($shop['shop_id'],$product['selprod_id'])); ?>"
                                                class="btn btn--primary btn--secondary btn--primary-border  btn--sm"><?php echo Labels::getLabel('LBL_Ask_Question', $siteLangId); ?></a>
                                            <?php }?>
                                            <?php if (count($product['moreSellersArr'])>0) { ?>
                                            <a href="<?php echo CommonHelper::generateUrl('products', 'sellers', array($product['selprod_id']));?>" class="btn btn--primary btn--sm "><?php echo Labels::getLabel('LBL_All_Sellers', $siteLangId);?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php include(CONF_THEME_PATH.'_partial/product/shipping-rates.php');?>

                <?php $youtube_embed_code = CommonHelper::parseYoutubeUrl($product["product_youtube_video"]); ?>
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="nav-detail nav-detail-js">
                            <ul>
                                <?php if (count($productSpecifications)>0) {?>
                                <li><a class="nav-scroll-js is-active" href="#specifications"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></a></li>
                                <?php }?>
                                <?php if ($product['product_description']!='') { ?>
                                <li class=""><a class="nav-scroll-js" href="#description"><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?> </a></li>
                                <?php }?>
                                <?php if ($youtube_embed_code) { ?>
                                <li class=""><a class="nav-scroll-js" href="#video"><?php echo Labels::getLabel('LBL_Video', $siteLangId); ?> </a></li>
                                <?php }?>
                                <?php if ($shop['shop_payment_policy'] != '' || !empty($shop["shop_delivery_policy"] != "") || !empty($shop["shop_delivery_policy"] != "")) { ?>
                                <li class=""><a class="nav-scroll-js" href="#shop-policies"><?php echo Labels::getLabel('LBL_Shop_Policies', $siteLangId); ?> </a></li>
                                <?php }?>
                                <?php if (!empty($product['selprodComments'])) { ?>
                                <li class=""><a class="nav-scroll-js" href="#extra-comments"><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?> </a></li>
                                <?php }?>
                                <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                                <li class=""><a class="nav-scroll-js" href="#itemRatings"><?php echo Labels::getLabel('LBL_Ratings_and_Reviews', $siteLangId); ?> </a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
            <section class="section">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <?php if (count($productSpecifications)>0) {?>
                        <div class="section-head">
                            <div class="section__heading" id="specifications">
                                <h2><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></h2>
                            </div>
                        </div>
                        <div class="cms bg-gray p-4 mb-4">
                            <table>
                                <tbody>
                                    <?php foreach ($productSpecifications as $key => $specification) { ?>
                                    <tr>
                                        <th><?php echo $specification['prodspec_name']." :" ;?></th>
                                        <td><?php echo html_entity_decode($specification['prodspec_value'], ENT_QUOTES, 'utf-8') ; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php }?>
                        <?php if ($product['product_description']!='') { ?>
                        <div class="section-head">
                            <div class="section__heading" id="description">
                                <h2><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h2>
                            </div>
                        </div>
                        <div class="cms bg-gray p-4 mb-4">
                            <p><?php echo CommonHelper::renderHtml($product['product_description']);?></p>
                        </div>
                        <?php } ?>
                        <?php if ($youtube_embed_code) { ?>
                        <div class="section-head">
                            <div class="section__heading" id="video">
                                <h2><?php echo Labels::getLabel('LBL_Video', $siteLangId); ?></h2>
                            </div>
                        </div>
                        <?php if ($youtube_embed_code!="") : ?>
                        <div class="mb-4 video-wrapper">
                            <iframe width="100%" height="315" src="//www.youtube.com/embed/<?php echo $youtube_embed_code?>" allowfullscreen></iframe>
                        </div>
                        <span class="gap"></span>
                        <?php  endif;?>
                        <?php } ?>
                        <?php if ($shop['shop_payment_policy'] != '' || !empty($shop["shop_delivery_policy"] != "") || !empty($shop["shop_delivery_policy"] != "")) { ?>
                        <div class="section-head">
                            <div class="section__heading" id="shop-policies">
                                <h2><?php echo Labels::getLabel('LBL_Shop_Policies', $siteLangId); ?></h2>
                            </div>
                        </div>
                        <div class="cms bg-gray p-4 mb-4">
                            <?php if ($shop['shop_payment_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Payment', $siteLangId)?></h6>
                            <p><?php echo nl2br($shop['shop_payment_policy']); ?></p>
                            <br>
                            <?php } ?>
                            <?php if ($shop['shop_delivery_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Shipping', $siteLangId)?></h6>
                            <p><?php echo nl2br($shop['shop_delivery_policy']); ?></p>
                            <br>
                            <?php }?>
                            <?php if ($shop['shop_refund_policy'] != '') { ?>
                            <h6><?php echo Labels::getLabel('LBL_Shipping', $siteLangId)?></h6>
                            <p><?php echo nl2br($shop['shop_refund_policy']); ?></p>
                            <?php }?>
                        </div>
                        <?php } ?>
                        <?php if (!empty($product['selprodComments'])) { ?>
                        <div class="section-head">
                            <div class="section__heading" id="extra-comments">
                                <h2><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h2>
                            </div>
                        </div>
                        <div class="cms bg-gray p-4 mb-4">
                            <p><?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?></p>
                        </div>
                        <?php } ?>

                        <div id="itemRatings">
                            <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                            <?php echo $frmReviewSearch->getFormHtml(); ?>
                            <?php $this->includeTemplate('_partial/product-reviews.php', array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'product_id' => $product['product_id'],'canSubmitFeedback' => $canSubmitFeedback), false); ?>
                            <?php }?>
                        </div>

                    </div>
                </div>
            </section>
            <section class="">
                <?php if (isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners'])) { ?>
                <div class="gap"></div>
                <div class="row">
                    <?php foreach ($banners['Product_Detail_Page_Banner']['banners'] as $val) {
                         $desktop_url = '';
                         $tablet_url = '';
                         $mobile_url = '';
                        if (!AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId)) {
                             continue;
                        } else {
                            $slideArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId);
                            foreach ($slideArr as $slideScreen) {
                                switch ($slideScreen['afile_screen']) {
                                    case applicationConstants::SCREEN_MOBILE:
                                        $mobile_url = '<736:' .CommonHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)).",";
                                        break;
                                    case applicationConstants::SCREEN_IPAD:
                                        $tablet_url = ' >768:' .CommonHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)).",";
                                        break;
                                    case applicationConstants::SCREEN_DESKTOP:
                                        $desktop_url = ' >1025:' .CommonHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)).",";
                                        break;
                                }
                            }
                        } ?>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="banner-ppc"><a href="<?php echo CommonHelper::generateUrl('Banner', 'url', array($val['banner_id'])); ?>" target="<?php echo $val['banner_target']; ?>" title="<?php echo $val['banner_title']; ?>"
                                class="advertise__block"><img data-ratio="10:3" data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url  . $tablet_url  . $desktop_url; ?>"
                                    src="<?php echo CommonHelper::generateUrl('Banner', 'productDetailPageBanner', array($val['banner_id'],$siteLangId,applicationConstants::SCREEN_DESKTOP)); ?>" alt="<?php echo $val['banner_title']; ?>"
                                    class="img-responsive"></a></div>
                    </div>
                    <?php } ?>
                    </div>
                <?php } if (isset($val['banner_record_id']) && $val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC) {
                         Promotion::updateImpressionData($val['banner_record_id']);
                } ?>
            </section>
        </div>
    </section>
    <?php if ($recommendedProducts) { ?>
    <section class="section bg--second-color">
        <?php include(CONF_THEME_PATH.'products/recommended-products.php'); ?>
    </section>
    <?php } ?>
    <?php if ($relatedProductsRs) { ?>
    <section class="section">
        <?php include(CONF_THEME_PATH.'products/related-products.php'); ?>
    </section>
    <?php } ?>
    <div id="recentlyViewedProductsDiv"></div>
</div>
<script>
	var disableDates = <?php echo json_encode($unavailableDates);?>;
	//console.log(disableDates);
	
	var availableDate = new Date('<?php echo $rentalAvailableDate; ?>');
	var availableDate = new Date(availableDate.getTime() + 86400000);
	$('.rental_start_date').datepicker({
        dateFormat: 'yy-mm-dd',
        defaultDate: availableDate,
        minDate: availableDate,
        beforeShowDay: function(date){
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			if( disableDates.indexOf(string) == -1) {
				return [ disableDates.indexOf(string) == -1, '' ];
			} else  {
				return [ disableDates.indexOf(string) == -1, 'rental-unavailable-date' ];
			}
			
			$('.ui-datepicker').addClass('product-rental-calendar');
	      
		},
        onSelect: function (select_date) {
			getRentalDetails();
            var selectedDate = new Date(select_date);
			var msecsInADay = 86400000;
			var endDate = new Date(selectedDate.getTime() + msecsInADay);
			$(".rental_end_date").datepicker( "option", "minDate", endDate );
			//$("#endDatePicker").datepicker( "option", "maxDate", '+2y' );
        }
    });
	
	$('.rental_end_date').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: availableDate,
        defaultDate: availableDate,
        beforeShowDay: function(date){
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			if( disableDates.indexOf(string) == -1) {
				return [ disableDates.indexOf(string) == -1, '' ];
			} else  {
				return [ disableDates.indexOf(string) == -1, 'rental-unavailable-date' ];
			}
		},
        onSelect: function (select_date) {
			getRentalDetails();
            var selectedDate = new Date(select_date);
			var msecsInADay = 86400000;
			var startDate = new Date(selectedDate.getTime() - msecsInADay);
			$(".rental_start_date").datepicker( "option", "maxDate", startDate );
        }
    });
	
	$('.rental_start_datetime').datetimepicker({
        dateFormat: 'yy-mm-dd H:i',
        defaultDate: availableDate,
        minDate: availableDate,
        beforeShowDay: function(date){
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			if( disableDates.indexOf(string) == -1) {
				return [ disableDates.indexOf(string) == -1, '' ];
			} else  {
				return [ disableDates.indexOf(string) == -1, 'rental-unavailable-date' ];
			}
		},
        onChangeDateTime: function (select_date) {
			getRentalDetails();
            var selectedDate = new Date(select_date);
			var msecsInAHour = 60*60*1000; // Miliseconds in hours
			var startDate = new Date(selectedDate.getTime() + msecsInAHour);
			$(".rental_end_datetime").datepicker( "option", "maxDate", startDate );
        }
    });
	
	$('.rental_end_datetime').datetimepicker({
        dateFormat: 'yy-mm-dd H:i',
        minDate: availableDate,
        defaultDate: availableDate,
        beforeShowDay: function(date){
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			if( disableDates.indexOf(string) == -1) {
				return [ disableDates.indexOf(string) == -1, '' ];
			} else  {
				return [ disableDates.indexOf(string) == -1, 'rental-unavailable-date' ];
			}
		},
        onChangeDateTime: function (selected_date) {
            if (selected_date) {
                selected_date.setDate(selected_date.getDate() - 1);
                $(".rental_start_date").datepicker({maxDate: selected_date});
            }
        }
    });
	
</script>
<script type="text/javascript">
    var mainSelprodId = <?php echo $product['selprod_id'];?>;
    var layout = '<?php echo CommonHelper::getLayoutDirection();?>';

    $("document").ready(function() {
        recentlyViewedProducts(<?php echo $product['selprod_id'];?>);
        /*zheight = $(window).height() - 180; */
        zwidth = $(window).width() / 3 - 15;

        if (layout == 'rtl') {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: zwidth,
                /*zoomHeight: zheight,*/
                title: true,
                tint: '#333',
                position: 'left'
            });
        } else {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: zwidth,
                /*zoomHeight: zheight,*/
                title: true,
                tint: '#333',
                Xoffset: 2
            });
        }

        window.setInterval(function() {
            var scrollPos = $(window).scrollTop();
            if (scrollPos > 0) {
                setProductWeightage('<?php echo $product['selprod_code']; ?>');
            }
        }, 5000);

    });

    <?php /* if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
    $(function() {
        if ($(window).width() > 1050) {
            $(window).scroll(sticky_relocate);
            sticky_relocate();
        }
    });
    <?php } */ ?>
</script>
<script>
    $(document).ready(function() {
        $("#btnAddToCart").addClass("quickView");
        $('#slider-for').slick(getSlickGallerySettings(false));
        $('#slider-nav').slick(getSlickGallerySettings(true, '<?php echo CommonHelper::getLayoutDirection();?>'));

        /* for toggling of tab/list view[ */
        $('.list-js').hide();
        $('.view--link-js').on('click', function(e) {
            $('.view--link-js').removeClass("btn--active");
            $(this).addClass("btn--active");
            if ($(this).hasClass('list')) {
                $('.tab-js').hide();
                $('.list-js').show();
            } else if ($(this).hasClass('tab')) {
                $('.list-js').hide();
                $('.tab-js').show();
            }
        });
        /* ] */

        $(".nav-scroll-js").click(function(event) {
            event.preventDefault();
            var full_url = this.href;
            var parts = full_url.split("#");
            var trgt = parts[1];
            var target_offset = $("#" + trgt).offset();

            var target_top = target_offset.top - $('#header').height();
            $('html, body').animate({
                scrollTop: target_top
            }, 800);
        });
        $('.nav-detail-js li a').click(function() {
            $('.nav-detail-js li a').removeClass('is-active');
            $(this).addClass('is-active');
        });

    });
</script>
<!--Here is the facebook OG for this product  -->
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>
