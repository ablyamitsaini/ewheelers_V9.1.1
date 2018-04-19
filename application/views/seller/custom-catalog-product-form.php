<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="top-space">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="cols--group">
				<div class="panel__head box__head">
					<h2><?php echo Labels::getLabel('LBL_Custom_Catalog_Product_Setup',$siteLangId); ?></h2>
					<div class="group--btns">
						<a href="<?php echo CommonHelper::generateUrl('seller'); ?>" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Back_to_Account_Area',$siteLangId); ?></a>
					</div>
				</div>
				<div class="panel__body">
					<div class="box box--white box--space box--height">					
						<div id="listing"></div>						
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<script>
$(document).ready(function(){
	<?php if($preqId){?>
	customCatalogProductForm(<?php echo $preqId;?>,<?php echo $preqCatId;?>);	
	<?php }else{?>
	customCatalogProductForm();
	<?php }?>
});
</script>