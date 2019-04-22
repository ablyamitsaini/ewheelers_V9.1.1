<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
?>
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				<div class="section__heading">
					<h2> <?php echo $pageTitle; ?>
					<span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ><?php echo $page;?> - </span><span id="end_record"><?php echo $pageCount;?></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"><?php echo $recordCount;?></span></span>
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
							<div class="filters__ele productFilters-js"></div>
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
						if( !empty($category['banner']) && (!isset($noProductFound)) ){ ?>
						<a href="<?php echo CommonHelper::generateUrl('Category','view', array($category['prodcat_id'])); ?>" title="<?php echo $category['prodcat_name']; ?>" class="advertise__block advertise__block--main"><img data-ratio="16:9 (1000x563)" src="<?php echo CommonHelper::generateUrl('Category','Banner', array($category['prodcat_id'], $siteLangId, 'wide')); ?>" alt="<?php echo Labels::getLabel('LBL_category_Banner', $siteLangId); ?>"></a>
						<?php }

						if(!empty($category) && array_key_exists('prodcat_description',$category) && (!isset($noProductFound))){ ?>
						<div class="category__description container--cms">
						<?php  echo FatUtility::decodeHtmlEntities($category['prodcat_description']); ?>
						</div>
						<?php }	?>
						<div class="listing-products -listing-products listing-products--grid ">
							<div id="productsList" role="main-listing" class="row product-listing">
								<?php if($recordCount > 0 ) {
									$productsData = array (
										'products'=> $products,
										'page'=> $page,
										'pageCount'=> $pageCount,
										'postedData'=> $postedData,
										'recordCount'=> $recordCount,
										'siteLangId'=> $siteLangId,
									);
									$this->includeTemplate('products/products-list.php',$productsData,false);
						        } else {
									$pSrchFrm = Common::getSiteSearchForm();
							        $pSrchFrm->fill(array('btnSiteSrchSubmit' => Labels::getLabel('LBL_Submit', $siteLangId)));
							        $pSrchFrm->setFormTagAttribute('onSubmit', 'submitSiteSearch(this); return(false);');

						            $this->includeTemplate('_partial/no-product-found.php',array('pSrchFrm'=>$pSrchFrm,'siteLangId'=>$siteLangId,'postedData'=>$postedData) ,true);
						        } ?>
							</div>
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
							<div class="grids" id="searchPageBanners">

							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<div class="gap"></div>
<script type="text/javascript">
$(document).ready(function(){
	$currentPageUrl = '<?php echo $canonicalUrl; ?>';
	$productSearchPageType = '<?php echo $productSearchPageType; ?>';
	$recordId = <?php echo $recordId; ?>;
	loadProductListingfilters(document.frmProductSearch);
    bannerAdds('<?php echo $bannerListigUrl;?>');
});
</script>
