<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
?>
<div id="body" class="body bg--gray">
  <section class="dashboard">
    <div class="container">
      <?php if(!isset($noProductFound)) { ?>
      <div class="breadcrumb">
        <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
      </div>
      <?php } ?>
      <div class="row">
        <?php if(!isset($noProductFound)) { ?>
        <div class="col-lg-3 col--left">
          <!--<h5 class="hide--mobile hide--tab hide--ipad"><?php echo Labels::getLabel('LBL_Quick_Filters', $siteLangId); ?></h5>-->
          <div class="overlay overlay--filter"></div>
          <div class="filters">
            <div class="">
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
		<?php }
		if(!isset($noProductFound)){
			$blockTitle = Labels::getLabel('LBL_FEATURED_PRODUCTS', $siteLangId);
			$class ='col-xl-9';
		}else{
			$class= 'col-lg-12';
			$blockTitle = '';
		}
		?>
        <div class="<?php echo $class;?>">
			<?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'blockTitle'=>$blockTitle,'siteLangId'=>$siteLangId),false);  ?>
		</div>
        <div class="col-md-3 col--left col--left-adds">
          <div class="wrapper--adds" >
            <div class="grids" id="searchPageBanners"> </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="gap"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Products','featured'); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_FEATURED_PRODUCT; ?>';
	$recordId = 0;
	<?php if($productFiltersArr['priceInFilter']){?>
		updatePriceFilter(<?php echo floor($productFiltersArr['priceArr']['minPrice']);?>,<?php echo ceil($productFiltersArr['priceArr']['maxPrice']);?>);
	<?php }?>
	searchProducts(document.frmProductSearch);
});
</script>
