<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->overrideFldType("hidden");
?>

<div id="body" class="body" role="main">
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				<div class="section__heading">
					<h2> <?php echo Labels::getLabel('LBL_All_Products', $siteLangId); ?>
					<span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ></span>-<span id="end_record"></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"></span></span>
					</h2>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="row align-items-center">
				<?php if(!isset($noProductFound)) { ?>
				<div class="col-md-5">
					<div class="breadcrumbs d-none d-xl-block  d-lg-block">
					  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
					</div>
				</div>
				<div class="col-lg-7">
					<?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'siteLangId'=>$siteLangId),false);  ?>
				</div>
				<?php } ?>
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
						<div id="productsList" role="main-listing" class="row product-listing"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-3 col--left col--left-adds">
					<div class="wrapper--adds" >
						<div class="grids" id="searchPageBanners"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
  <div class="gap"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Products','index'); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_PRODUCT_INDEX; ?>';
	$recordId = 0;
	<?php if($priceInFilter){?>
		updatePriceFilter(<?php echo floor($priceArr['minPrice']);?>,<?php echo ceil($priceArr['maxPrice']);?>);
	<?php }?>
	searchProducts(document.frmProductSearch);
});
</script>
