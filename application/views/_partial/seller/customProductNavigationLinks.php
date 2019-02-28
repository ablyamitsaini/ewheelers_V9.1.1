<div class="cards-header p-3">
	<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Add_My_Product',$siteLangId); ?></h5>
	<?php if($alertToShow) { ?>
	<div class="note-messages"><?php echo Labels::getLabel('LBL_Category_and_brand_fields_are_mandatory',$siteLangId); ?></div>
   <?php }?>
   <div class="actions">
		<a href="<?php echo CommonHelper::generateUrl('seller','catalog');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel( 'LBL_Back_To_Products_list', $siteLangId)?></a>
	</div>
</div>