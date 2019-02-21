<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
// ob_end_clean(); die('<pre>' . print_r($categoryData, true) . '</pre>');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	//$keywordFld->htmlAfterField = '<i class="fa fa-search"></i>';
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
?>

<div id="body" class="body" role="main">
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				<div class="section__heading">
					<h2> <?php echo $categoryData['prodcat_name']; ?>
					<span><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ></span>-<span id="end_record"></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"></span></span>
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
						<?php
						if( !empty($categoryData['catBanner']) && (!isset($noProductFound)) ){ ?>
						<a href="<?php echo CommonHelper::generateUrl('Category','view', array($categoryData['prodcat_id'])); ?>" title="<?php echo $categoryData['prodcat_name']; ?>" class="advertise__block advertise__block--main"><img src="<?php echo CommonHelper::generateUrl('Category','Banner', array($categoryData['prodcat_id'], $siteLangId, 'wide')); ?>" alt="<?php echo Labels::getLabel('LBL_category_Banner', $siteLangId); ?>"></a>
						<?php }

						if( !empty($categoryData['prodcat_description'] && (!isset($noProductFound))) ){ ?>
						<div class="category__description container--cms">
						<?php  echo FatUtility::decodeHtmlEntities($categoryData['prodcat_description']); ?>
						</div>
						<?php }	?>
						<div class="listing-products -listing-products listing-products--grid ">
							<div id="productsList" role="main-listing" class="row"></div>
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
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Category','view',array($category_id)); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_CATEGORY; ?>';
	$recordId = <?php echo $category_id; ?>;
	<?php if($priceInFilter){?>
		updatePriceFilter(<?php echo floor($priceArr['minPrice']);?>,<?php echo ceil($priceArr['maxPrice']);?>);
	<?php }?>
	searchProducts(document.frmProductSearch);
});
</script>
