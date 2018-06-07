<div class="box__head">
   <h4><?php echo Labels::getLabel('LBL_Add_My_Product',$siteLangId); ?></h4>
   <?php if($alertToShow) { ?>
	<div class="note-messages"><?php echo Labels::getLabel('LBL_Category_and_brand_fields_are_mandatory',$siteLangId); ?></div>
   <?php }?>
	<div class="group--btns panel__head_action">
		<a href="<?php echo CommonHelper::generateUrl('seller','catalog');?>" class="btn btn--secondary btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Back_To_Products_list', $siteLangId)?></strong> </a>				
	</div>
</div>