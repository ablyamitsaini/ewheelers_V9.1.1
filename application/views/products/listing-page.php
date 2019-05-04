<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
	$bannerImage = '';
	if( !empty($category['banner'])) {
	$bannerImage = CommonHelper::generateUrl('Category','Banner', array($category['prodcat_id'], $siteLangId, 'wide'));
	}
?>
	<?php if( !empty($category['banner']) || !empty($category['prodcat_description'])) { ?>
	<section class="section bg-brands" style="background-image: url(<?php echo $bannerImage; ?>)">
		<?php if(!empty($category['prodcat_description']) && array_key_exists('prodcat_description',$category)){ ?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9">
					<div class="text-center">
						<h6 class="txt-white"><?php  echo FatUtility::decodeHtmlEntities($category['prodcat_description']); ?></h6>
					</div>
				</div>
			</div>
		</div>
		<?php }	?>
	</section>
	<?php }	?>
	<section class="section section--pagebar">
		<div class="container">
			<div class="section-head justify-content-center mb-0">
				<div class="section__heading">
					<h2 class="mb-0"><?php echo $pageTitle; ?>
						<?php /* <span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ><?php echo $page;?> - </span><span id="end_record"><?php echo $pageCount;?></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"><?php echo $recordCount;?></span></span> */ ?>
					</h2>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
			<div class="container">
				<div class="row">
					<?php if(!isset($noProductFound)) { ?>
					<div class="col-lg-3 col-md-3 column">
                        <?php if (array_key_exists('brand_id', $postedData) && $postedData['brand_id'] > 0) { ?>
						<div class="brands-block-wrapper">
							<div class="brands-block">
								<img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'brand', array($postedData['brand_id'] , $siteLangId, 'COLLECTION_PAGE')), CONF_IMG_CACHE_TIME, '.jpg'); ?>">
							</div>
						</div>
                        <?php } ?>
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
                        <?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'siteLangId'=>$siteLangId,'recordCount'=>$recordCount),false);  ?>
                        <div class="gap"></div>
						<div class="listing-products -listing-products ">
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
