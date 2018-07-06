<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
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
						<div class="box box--white">
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
					$blockTitle=Labels::getLabel('LBL_All_PRODUCTS', $siteLangId);
					$class ='col-lg-9';
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
						<div class="grids" id="searchPageBanners">
							
						</div>   
					</div>  
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){ 
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Products','search'); ?>';
	searchProducts(document.frmProductSearch);
});	 
</script>	