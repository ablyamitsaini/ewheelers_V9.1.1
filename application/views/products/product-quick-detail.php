<div class="row">
    <div class="col-lg-6 col-md-6 quick-col-1">
    <?php include(CONF_THEME_PATH.'_partial/collection-ui.php'); ?>
    <?php if ($productImagesArr) { ?>
        <div class="js-product-gallery product-gallery" dir="<?php echo CommonHelper::getLayoutDirection();?>">
            <?php foreach ($productImagesArr as $afile_id => $image) {
                $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg');
                $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] )), CONF_IMG_CACHE_TIME, '.jpg'); ?>
            <div class=""><?php if (isset($imageGallery) && $imageGallery) { ?>
                <a href="<?php echo $mainImgUrl; ?>" class="gallery" rel="gallery">
                    <?php } ?>
                    <img src="<?php echo $mainImgUrl; ?>">
                    <?php if (isset($imageGallery) && $imageGallery) { ?>
                </a>
                <?php } ?></div>
            <?php }?>
        </div>
    <?php } else {
        $mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 )), CONF_IMG_CACHE_TIME, '.jpg'); ?>
        <div class="item__main"><img src="<?php echo $mainImgUrl; ?>"></div>
        <?php
    } ?>
    </div>
    <div class="col-lg-6 col-md-6 quick-col-2">
        <div class="product-detail product-description product-detail-quickview">
            <div>
                <div class="product-description-inner">
                    <div class="products__title">
						<a title="<?php echo $product['selprod_title']; ?>" href="<?php echo !isset($product['promotion_id']) ? CommonHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : CommonHelper::generateUrl('Products', 'track', array($product['promotion_record_id'])) ?>">
							<?php echo $product['selprod_title'];?>
						</a>
                    </div>
                    <div class="gap"></div>
					<!-- [ REntal Functionality -->
					<div class="row product-type-tabs-container mb-4">
						<?php if (ALLOW_RENT > 0 && $product['is_rent'] > 0) { ?>
						<div class="col-sm-6">
							<a href="javascript:void(0);" class="product-type-tabs active product-type-tabs--js" data-productfor="<?php echo applicationConstants::PRODUCT_FOR_RENT; ?>" >
								<span class="sticky-title">
									<?php echo Labels::getLabel('LBL_For_Rental', $siteLangId);?>
								</span>
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
						<?php if (ALLOW_SALE > 0 && $product['is_sell'] > 0) { ?>
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
						<?php } ?>
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
					<!-- REntal Functionality ]-->
					<div class="divider"></div>
                    <div class="gap"></div>
                </div>
				<?php if (!empty($optionRows)) { ?>
                <div class="row">
                <?php 
				$selectedOptionsArr = $product['selectedOptionValues'];
				$count = 0;
				foreach ($optionRows as $key => $option) {
					$selectedOptionValue = $option['values'][$selectedOptionsArr[$key]]['optionvalue_name'];
					$selectedOptionColor = $option['values'][$selectedOptionsArr[$key]]['optionvalue_color_code'];
					?>
                    <div class="col-md-6 mb-2">
                        <div class="h6"><?php echo $option['option_name']; ?></div>
                        <div class="js-wrap-drop-quick wrap-drop" id="js-wrap-drop-quick<?php echo $count; ?>">
                            <span>
                            <?php if ($option['option_is_color']) { ?>
                                <span class="colors" style="background-color:#<?php echo $selectedOptionColor; ?>; ?>;"></span>
                            <?php } ?>
                            <?php echo $selectedOptionValue; ?>
							</span>
                            <?php if ($option['values']) { ?>
                            <ul class="drop">
                                <?php foreach ($option['values'] as $opVal) {
									$isAvailable = true;
                                    if (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) {
                                        $optionUrl = CommonHelper::generateUrl('Products', 'view', array($product['selprod_id']));
                                        $selprodId = $product['selprod_id'];
                                    } else {
                                        $optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
                                        $selprodId = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id'], true);
                                        $optionUrlArr = explode("::", $optionUrl);
                                        if (is_array($optionUrlArr) && count($optionUrlArr) == 2) {
                                            $optionUrl = $optionUrlArr[0];
                                            $isAvailable = false;
                                        }
                                    } ?>
									<li class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' selected' : ' '; echo (!$optionUrl) ? 'is-disabled' : ''; echo (!$isAvailable) ? 'not--available':''; ?>">
                                    <?php if ($option['option_is_color'] && $opVal['optionvalue_color_code'] != '') { ?>
                                        <a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>" class="<?php echo (!$option['option_is_color']) ? 'selector__link' : ''; echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' ' : ' '; echo (!$optionUrl) ? ' is-disabled' : '';  ?>" href="javascript:void(0)" onclick="quickDetail(<?php echo $selprodId; ?>)"> 
										<span class="colors" style="background-color:#<?php echo $opVal['optionvalue_color_code']; ?>;"></span>
											<?php echo $opVal['optionvalue_name'];?>
										</a>
									<?php } else { ?>
                                            <a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>"
                                                title="<?php echo $opVal['optionvalue_name'];
                                                echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>"
                                                class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? '' : ' '; echo (!$optionUrl) ? ' is-disabled' : '' ?>" href="javascript:void(0)" onclick="quickDetail(<?php echo $selprodId; ?>)">
                                                <?php echo $opVal['optionvalue_name'];  ?> </a>
									<?php } ?>
									</li>
								<?php } ?>
							</ul>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $count++;
                    } ?>
                </div>
                <?php } ?>
			</div>
            <!-- Add To Cart [ -->
            <?php if ($product['in_stock'] ||  $product['sprodata_rental_stock'] > 0) {
				
                echo $frmBuyProduct->getFormTag();
                $qtyField = $frmBuyProduct->getField('quantity');
                $qtyField->addFieldTagAttribute('class', 'qty-input cartQtyTextBox productQty-js');
                $qtyField->addFieldTagAttribute('data-page', 'product-view');
				$qtyFieldName =  $qtyField->getCaption(); 
				
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
					$rentalStartDateFld->addFieldTagAttribute('onChange', 'getRentalDetails()');
					$rentalEndDateFld->addFieldTagAttribute('onChange', 'getRentalDetails()'); ?>
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
				<?php } ?>
				<div class="row align-items-end rental-fields--js mb-3">
				<div class="col-sm-12">
                    <label class="h6"><?php echo $qtyFieldName; ?></label>
                    <div class="qty-wrapper">
                        <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                            <span class="decrease decrease-js">-</span>
                            <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                            </div>
                            <span class="increase increase-js">+</span>
                        </div>
                    </div>
                </div>
				</div>
				
				<div class="buy-group">
                <?php 
				if (strtotime($product['selprod_available_from']) <= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) {
					echo $frmBuyProduct->getFieldHtml('btnProductBuy');
                    echo $frmBuyProduct->getFieldHtml('btnAddToCart');
                }
				echo $frmBuyProduct->getFieldHtml('selprod_id');
				echo $frmBuyProduct->getFieldHtml('product_for');
				?>
                </div>
                </form>
				<?php if ($product['is_rent'] > 0 && ALLOW_RENT > 0) { ?>
				<div class="gap"></div>
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
				<?php }
				echo $frmBuyProduct->getExternalJs();
                } else { ?>
				<div class="sold">
					<h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></h3>
					<p class="text--normal-secondary"><?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?></p>
				</div>
				<?php }
				
				if (strtotime($product['selprod_available_from']) > strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) { ?>
				<div class="sold">
					<h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Not_Available', $siteLangId); ?></h3>
					<p class="text--normal-secondary"><?php echo str_replace('{available-date}', FatDate::Format($product['selprod_available_from']), Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?></p>
				</div>
				<?php } ?>
            <!-- ] -->
        </div>
    </div>
</div>
<?php 
$rentalAvailableDate = date('Y-m-d');
?>
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
			return [ disableDates.indexOf(string) == -1, '' ]
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
			return [disableDates.indexOf(string) == -1, '']
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
			return [ disableDates.indexOf(string) == -1, '' ]
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
			return [disableDates.indexOf(string) == -1, '']
		},
        onChangeDateTime: function (selected_date) {
            if (selected_date) {
                selected_date.setDate(selected_date.getDate() - 1);
                $(".rental_start_date").datepicker({maxDate: selected_date});
            }
        }
    });
	
</script>
<script>
    $(document).ready(function() {
        var layoutDirection = '<?php echo CommonHelper::getLayoutDirection();?>';
        if (layoutDirection == 'rtl') {
            $('.js-product-gallery').slick({
                dots: true,
                arrows: true,
                autoplay: false,
                pauseOnHover: false,
                slidesToShow: 1,
                rtl: true,
            });
        } else {
            $('.js-product-gallery').slick({
                dots: true,
                arrows: true,
                autoplay: false,
                pauseOnHover: false,
                slidesToShow: 1,
            });
        }

        $('#close-quick-js').click(function() {
            if ($('html').removeClass('quick-view--open')) {
                $('.quick-view').removeClass('quick-view--open');
            }
        });

        /* $('#close-quick-js').click(function () {
            if ($('html').removeClass('quick-view--open')) {
                $(document).trigger('close.facebox');
                $('.quick-view').removeClass('quick-view--open');
            }
        }); */
        /* $('#quickView-slider-for').slick( getSlickGallerySettings(false,'<?php echo CommonHelper::getLayoutDirection();?>') );
        $('#quickView-slider-nav').slick( getSlickGallerySettings(true,'<?php echo CommonHelper::getLayoutDirection();?>') ); */

        function DropDown(el) {
            this.dd = el;
            this.placeholder = this.dd.children('span');
            this.opts = this.dd.find('ul.drop li');
            this.val = '';
            this.index = -1;
            this.initEvents();
        }

        DropDown.prototype = {
            initEvents: function() {
                var obj = this;
                obj.dd.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).toggleClass('active');
                });
                obj.opts.on('click', function() {
                    var opt = $(this);
                    obj.val = opt.text();
                    obj.index = opt.index();
                    obj.placeholder.text(obj.val);
                    opt.siblings().removeClass('selected');
                    opt.filter(':contains("' + obj.val + '")').addClass('selected');
                    var link = opt.filter(':contains("' + obj.val + '")').find('a').attr('href');
                    window.location.replace(link);
                }).change();
            },
            getValue: function() {
                return this.val;
            },
            getIndex: function() {
                return this.index;
            }
        };

        $(function() {
            // create new variable for each menu
            $(document).click(function() {
                // close menu on document click
                $('.wrap-drop').removeClass('active');
            });

            $('.js-wrap-drop-quick').click(function() {
    			$(this).parent().siblings().children('.js-wrap-drop-quick').removeClass('active');
    		});
        });

        $( ".js-wrap-drop-quick" ).each(function( index, element ) {
            var div = '#js-wrap-drop-quick'+index;
            new DropDown($(div));
        });

    });
</script>
