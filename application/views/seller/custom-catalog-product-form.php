<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
	<div class="content-wrapper content-space">
		<div class="content-header row justify-content-between mb-3">
			<div class="col-md-auto">
				<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
				<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Custom_Catalog_Product_Setup',$siteLangId); ?></h2>
			</div>
		</div>
		<div class="content-body">
			<div class="cards">
				<div class="cards-header p-3">
					<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Custom_Catalog_Product_Setup',$siteLangId); ?></h5>
					<div class="action">
						<a href="<?php echo CommonHelper::generateUrl('seller'); ?>" class="link"><?php echo Labels::getLabel('LBL_Back_to_Account_Area',$siteLangId); ?></a>
					</div>
				</div>
				<div class="cards-content p-3">
					<div id="listing"></div>	
				</div>
			</div>
		</div>
	</div>
</main>
<script>
$(document).ready(function(){
	<?php if($preqId){?>
	customCatalogProductForm(<?php echo $preqId;?>,<?php echo $preqCatId;?>);	
	<?php }else{?>
	customCatalogProductForm();
	<?php }?>
});
</script>