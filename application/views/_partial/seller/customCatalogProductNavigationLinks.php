<div class="cards-header p-4">
	<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Add_Custom_Product',$siteLangId); ?></h5>
		<div class="">
			<?php if(isset($preqId) && $preqId >0){ ?>
				<a href="<?php echo CommonHelper::generateUrl('seller','customCatalogProducts');?>" class="btn btn--primary btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Back', $siteLangId)?></strong> </a>
				<?php if(!User::isCatalogRequestSubmittedForApproval($preqId)){?>
				<a href="<?php echo CommonHelper::generateUrl('seller','approveCustomCatalogProducts',array($preqId));?>" class="btn btn--primary-border btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Submit_For_Approval', $siteLangId)?></strong> </a>
				<?php } }else{?>
				<a href="<?php echo CommonHelper::generateUrl('seller','customCatalogProductForm');?>" class="btn btn--primary btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Back', $siteLangId)?></strong> </a>
			<?php }?>
		</div>
</div>
