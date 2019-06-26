<div class="replaced specification" id="specification<?php echo $divCount; ?>">
	<?php foreach($languages as $langId=>$langName){ ?>
	<div class="row">
		<div class="col-lg-1 col-md-1 col-sm-4 col-xs-12">
		   <div class="field-set">
			 <div class="caption-wraper">
			   <div class="h3"><strong><?php  echo $langName;?></strong></div>
			 </div>
		   </div>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
		   <div class="field-set">
			 <div class="caption-wraper">
			   <label class="field_label"><?php echo Labels::getLabel('LBL_Specification_Name',$siteLangId)?></label>
			 </div>
			 <div class="field-wraper">
			   <div class="field_cover">
				<input class="<?php echo 'layout--'.Language::getLayoutDirection($langId); ?>" title="Specification Name" type="text" name="prod_spec_name[<?php echo $langId ?>][<?php echo $divCount ?>]" value="">
			   </div>
			 </div>
		   </div>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
		   <div class="field-set">
			 <div class="caption-wraper">
			   <label class="field_label"><?php echo Labels::getLabel('LBL_Specification_Value',$siteLangId)?></label>
			 </div>
			 <div class="field-wraper">
			   <div class="field_cover">
				<input class="<?php echo 'layout--'.Language::getLayoutDirection($langId); ?>" title="Specification Value" type="text" name="prod_spec_value[<?php echo $langId ?>][<?php echo $divCount ?>]" value="">
			   </div>
			 </div>
		   </div>
		</div>
		<?php if($langId == key( array_slice( $languages, -1, 1, TRUE ) )){ ?>
		<div class="col-lg-1 col-md-1 col-sm-4 col-xs-12 align--right">
		  <button type="button" onclick="removeSpecDiv(<?php echo $divCount ?>);" class="btn btn--primary ripplelink" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId)?>"  ><i class="fa fa-minus"></i></button>
		</div>
		<?php }?>
	</div>
	<?php  } ?>
</div>
