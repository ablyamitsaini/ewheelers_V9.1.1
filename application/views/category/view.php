<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
// ob_end_clean(); die('<pre>' . print_r($categoryData, true) . '</pre>');
	$frmProductSearch->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	//$keywordFld->htmlAfterField = '<i class="fa fa-search"></i>';
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
?>

<div id="body" class="body bg--gray">
  <section class="dashboard">
    <div class="fixed-container">
		<?php if( !isset($noProductFound) ) { ?>
			<div class="breadcrumb">
			  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
			</div>
		<?php } ?>
      <div class="row">
	   <?php if(!isset($noProductFound)) { ?>
		<div class="col-md-3 col--left">
		  <div class="overlay overlay--filter"></div>
		  <div class="filters">
			<div class="box box--white">
			  <?php
				//var_dump($productFiltersArr+$categoryData);
				/* Left Side Filters Side Bar [ */
				if( $productFiltersArr ){
					$this->includeTemplate('_partial/productFilters.php',$productFiltersArr+$categoryData, false);

				}
				/* ] */
				?>
			</div>
		  </div>
		</div>
		<?php }
		if(!isset($noProductFound)){
			$blockTitle=$categoryData['prodcat_name'];
			$class ='col-lg-9';
		}else{
			$class= 'col-lg-12';
			$blockTitle = '';
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
			<?php
			}

			$this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'blockTitle'=>$blockTitle,'siteLangId'=>$siteLangId), false);
			?>
		</div>
        <div class="col-md-3 col--left col--left-adds">
          <?php if(!empty($pollQuest)){ ?>
          <span class="gap"></span>
          <div class="box-poll">
            <?php $this->includeTemplate('_partial/poll-form.php'); ?>
          </div>
          <?php } ?>
          <div class="wrapper--adds">
            <div class="grids" id="categoryBanners"> </div>
          </div>
        </div>
      </div>
      <div class="gap"></div>
    </div>
  </section>
	<div class="gap"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	searchProducts(document.frmProductSearch);
});
</script>
