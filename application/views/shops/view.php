<?php defined('SYSTEM_INIT') or die('Invalid Usage');
	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input name="btnSrchSubmit" value="" type="submit" class="input-submit">';
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id));
?>
<div id="body" class="body" role="main" <?php if($showBgImage){ /* echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; */ } ?> >
	<?php
		$variables= array('shop'=>$shop, 'siteLangId'=>$siteLangId,'frmProductSearch'=>$frmProductSearch,'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action,'canonicalUrl'=>$canonicalUrl,'shopId'=>$shopId,'productFiltersArr'=>$productFiltersArr,'shopTotalReviews'=>$shopTotalReviews,'shopRating'=>$shopRating);
		$this->includeTemplate('shops/templates/'.$template_id.'.php',$variables,false);
	?>
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				<div class="section__heading">
					<h2> <?php echo Labels::getLabel('LBL_SHOP_PRODUCTS', $siteLangId)?>
						<span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ></span>-<span id="end_record"></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"></span></span>
					</h2>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-5">
					<div class="breadcrumbs d-none d-xl-block  d-lg-block">
					  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
					</div>
				</div>
				<div class="col-lg-7">
					<?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'siteLangId'=>$siteLangId),false);  ?>
				</div>
			</div>
		</div>
	</section>
	<section class="">
		<div class="container">
			<div class="row">
				<?php if(!isset($noProductFound)) { ?>
				<div class="col-lg-3 col-md-3 column">
					<div class="filters">
						<div class="filters__ele">
							<?php
							/* Left Side Filters Side Bar [ */
							if( $productFiltersArr ){
								$productFiltersArr['searchFrm']=$searchFrm;
								$this->includeTemplate('_partial/productFilters.php',$productFiltersArr,false);
							}
							/* ] */
							?>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if(!isset($noProductFound)){
					$class ='col-xl-9';
				}else{
					$class= 'col-lg-12';
				}
				?>
				<div class="<?php echo $class;?>">
					<div class="listing-products -listing-products listing-products--grid ">

							<div id="productsList" role="main-listing" class="row"></div>
					 
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
<script type="text/javascript">
$(document).ready(function(){
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Shops','view',array($shopId)); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_SHOP; ?>';
	$recordId = <?php echo $shopId;?>;
	<?php if($productFiltersArr['priceInFilter']){?>
		updatePriceFilter(<?php echo floor($productFiltersArr['priceArr']['minPrice']);?>,<?php echo ceil($productFiltersArr['priceArr']['maxPrice']);?>);
	<?php }?>
});

(function($){
	if(langLbl.layoutDirection == 'rtl'){
		$('.shops-sliders').slick({
			arrows: false,
			dots: true,
			autoplay: true,
			pauseOnHover: false,
			speed: 500,
			fade: true,
			cssEase: 'linear',
            rtl:true
		});
	}
	else
	{
		$('.shops-sliders').slick({
		arrows: false,
			dots: true,
			autoplay: true,
			pauseOnHover: false,
			speed: 500,
			fade: true,
			cssEase: 'linear',
		});
	}
})(jQuery);

</script>
