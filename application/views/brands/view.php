<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	//$keywordFld->htmlAfterField = '<i class="fa fa-search"></i>';
?>
<div id="body" class="body bg--gray">
	<section class="dashboard">
		<div class="fixed-container">
			<?php if(!isset($noProductFound)) { ?>
				<div class="breadcrumb">
				  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-lg-3 col--left <?php if(isset($noProductFound)) { echo "hidden"; }?>">
					<div class="overlay overlay--filter"></div>
					<div class="filters">
						<div class="">
							<?php
							if( $productFiltersArr ){
								$this->includeTemplate('_partial/productFilters.php',$productFiltersArr,false);
							}
							?>
						</div>
					</div>
				</div>
				<?php
				if(!isset($noProductFound)){
					if(!empty($brandData)){
					$blockTitle=$brandData['brand_name'];
					}else $blockTitle='';
					$class ='col-lg-9';
				}else{
					$class= 'col-lg-12';
					$blockTitle = '';
				}
				?>
				<div class="<?php echo $class;?>">
					<?php if(!empty($brandData))
					{ ?>
					  <?php if( !empty($brandData) ){ ?>
					  <a href="<?php echo CommonHelper::generateUrl('Brands','view', array($brandData['brand_id'])); ?>" title="<?php echo $brandData['brand_name']; ?>" class="advertise__block advertise__block--main"><img src="<?php echo CommonHelper::generateUrl('Image','Brand', array($brandData['brand_id'], $siteLangId)); ?>" alt="<?php echo $brandData['brand_name'];?>"></a>
					  <?php }
					  if(!empty($brandData['brand_short_description'])){ ?>
					  <div class="category__description container--cms">
						<?php  echo FatUtility::decodeHtmlEntities($brandData['brand_short_description']); ?>
					  </div>
					  <?php }
					}
					$this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'blockTitle'=>$blockTitle,'siteLangId'=>$siteLangId ),false);  ?>
				</div>
				<div class="col-md-3 col--left col--left-adds">
					<div class="wrapper--adds" >
						<div class="grids" id="brandBanners">

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<script type="text/javascript">
var isBrandPage = 1;
$(document).ready(function(){
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Brands','view',array($brandId)); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_BRAND; ?>';
	$recordId = <?php echo $brandId; ?>;
	<?php if($priceInFilter){?>
		updatePriceFilter(<?php echo floor($priceArr['minPrice']);?>,<?php echo ceil($priceArr['maxPrice']);?>);
	<?php }?>
	searchProducts(document.frmProductSearch);
});
</script>
