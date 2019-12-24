<?php $inactive = ($selprod_id==0)?'fat-inactive':'';	 ?>
<ul>
	<li class="<?php echo ($activeTab == 'GENERAL')?'is-active':''?>">
	<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="sellerProductForm(<?php echo $product_id;?>,<?php echo $selprod_id;?>)"<?php }?>>
	<?php echo Labels::getLabel('LBL_General',$siteLangId);?></a></li>
	
	<!-- Rental Tab According to Admin Settings-->
	<?php if (ALLOW_RENT > 0) { ?>
		<li class="<?php echo ($activeTab == 'RENT')?'is-active':''; echo $inactive;?> <?php if (!$is_rent) {?>productRentTabs <?php }?> tabsForRentJs">
			<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="productRental(<?php echo $selprod_id;?>)"<?php }?>>
			<?php echo Labels::getLabel('LBL_Rental_Details', $siteLangId);?></a>
		</li>
		
		<li class="<?php echo ($activeTab == 'DURATION_DISCOUNT')?'is-active':''; echo $inactive;?> <?php if (!$is_rent) {?>productRentTabs <?php }?> tabsForRentJs">
			<a href="javascript:void(0)" <?php if($selprod_id > 0 ){?>onClick="sellerProductDurationDiscounts(<?php echo $selprod_id; ?>)"  <?php } ?>>
			<?php echo Labels::getLabel('LBL_Rental_Duration_Discount', $siteLangId);?></a>
		</li>

		<li class="<?php echo ($activeTab == 'DURATION_UNAVAILABLE')?'is-active':''; echo $inactive;?> <?php if (!$is_rent) {?> productRentTabs <?php }?> tabsForRentJs">
			<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="productRentalUnavailableDates(<?php echo $selprod_id;?>)"<?php }?>>
			<?php echo Labels::getLabel('LBL_Rental_Unavailable', $siteLangId);?></a>
		</li>
	<?php } ?>
	<!-- Rent Tab -->
	
	<li class="<?php echo ($activeTab == 'SEO')?'is-active':''; echo $inactive;?>">
	<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="productSeo(<?php echo $selprod_id;?>)"<?php }?>>
	<?php echo Labels::getLabel('LBL_Seo',$siteLangId);?></a></li>
	
	<?php if (ALLOW_SALE > 0) { ?>
	<li class="<?php echo ($activeTab == 'SPECIAL_PRICE')?'is-active':''; echo $inactive;?> tabsForSaleJs <?php if (!$is_sale) {?>productSaleTabs <?php }?>">
	<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="sellerProductSpecialPrices(<?php echo $selprod_id;?>)"<?php }?>>
	<?php echo Labels::getLabel('LBL_Special_Price',$siteLangId);?></a></li>
	<li class="<?php echo ($activeTab == 'VOLUME_DISCOUNT')?'is-active':''; echo $inactive;?> tabsForSaleJs <?php if (!$is_sale) {?>productSaleTabs <?php }?>">
	<a href="javascript:void(0)" <?php if($selprod_id > 0 ){?>onClick="sellerProductVolumeDiscounts(<?php echo $selprod_id; ?>)"  <?php } ?>>
	<?php echo Labels::getLabel('LBL_Volume_Discount',$siteLangId);?></a></li>
	<?php }?>
	
	<li class="<?php echo ($activeTab == 'LINKS')?'is-active':''; echo $inactive;?>">
	<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="sellerProductLinkFrm(<?php echo $selprod_id;?>)"<?php }?>>
	<?php echo Labels::getLabel('LBL_Links',$siteLangId);?></a></li>
	<?php if($product_type == Product::PRODUCT_TYPE_DIGITAL){?>
	<li class="<?php echo ($activeTab == 'DOWNLOADS')?'is-active':''; echo $inactive;?>">
	<a href="javascript:void(0)" <?php if($selprod_id>0){?>onClick="sellerProductDownloadFrm(<?php echo $selprod_id;?>)"<?php }?>>
	<?php echo Labels::getLabel('LBL_Downloads',$siteLangId);?></a></li>
	<?php }?>
</ul>
