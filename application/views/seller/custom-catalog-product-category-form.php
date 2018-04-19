<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frm->setFormTagAttribute ( 'onSubmit', 'searchCategory(this); return(false);' );

$frm->setFormTagAttribute('class', 'form'); 
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$keyFld = $frm->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frm->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frm->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-3');
$cancelBtnFld->developerTags['col'] = 2;
echo $frm->getFormHtml(); ?>
<div class="search-form"></div>
<h5><?php echo Labels::getLabel('Lbl_Select_Your_Product_category',$siteLangId);?></h5>
<div id="categories-js" class="categories-add-step">
	<div class="row select-categories-slider select-categories-slider-js slick-slider" id="categoryListing" dir="<?php echo CommonHelper::getLayoutDirection();?>">		
	</div>	
</div>
<div id="categorySearchListing"></div>
<p><?php echo Labels::getLabel('Lbl_Note:_if_not_found_it_may_either_require_approval',$siteLangId);?></p>
<script>
$('.select-categories-slider-js').slick( getSlickSliderSettings(3,1,langLbl.layoutDirection) );
</script>	