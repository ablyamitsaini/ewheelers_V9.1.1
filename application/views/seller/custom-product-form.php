<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
var  productId  =  <?php echo $prodId ;?>;
var  productCatId  =  <?php echo $prodCatId ;?>;
</script>
<div id="body" class="body bg--gray">
    <section class="top-space">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
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
	<?php if($prodId){?>
	customProductForm(<?php echo $prodId;?>,<?php echo $prodCatId;?>);	
	<?php }else{?>
	customProductForm();
	<?php }?>
});
</script>