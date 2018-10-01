<?php defined('SYSTEM_INIT') or die('Invalid Usage'); 
	$keywordFld = $headerSrchFrm->getField('keyword');
	$submitFld = $headerSrchFrm->getField('btnSiteSrchSubmit');
	$submitFld->setFieldTagAttribute('class','submit--js');
	$keywordFld->setFieldTagAttribute('class','search--keyword--js');
	$keywordFld->setFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search_for_Product...',$siteLangId));
	/* $keywordFld->setFieldTagAttribute('autofocus','autofocus'); */
	$keywordFld->setFieldTagAttribute('id','header_search_keyword');	
	$keywordFld->setFieldTagAttribute('onkeyup','animation(this)');
	
	$selectFld = $headerSrchFrm->getField('category');
	$selectFld->setFieldTagAttribute('id','category--js');
	$selectFld->setFieldTagAttribute('onChange','setSelectedCatValue()');
?>
<div class="main-search"> <a href="javascript:void(0)" class="toggle--search toggle--search-js"> <span class="icn"></span> <span class="icn-txt"><?php echo  Labels::getLabel('LBL_Search_for_Product',$siteLangId);?></span></a>
  <div class="form--search form--search-popup"> <a class="link__close" href="javascript:void(0)"></a>
    <div class="form__cover"> <?php echo $headerSrchFrm->getFormTag(); ?>
      <div class="select__cover"> <span class="select__value select_value-js"></span> <?php echo $headerSrchFrm->getFieldHTML('category'); ?> </div>  
	  <div class="field__cover">    <?php echo $headerSrchFrm->getFieldHTML('keyword'); ?> <?php echo $headerSrchFrm->getFieldHTML('btnSiteSrchSubmit'); ?> </div>
      </form>
      <?php echo $headerSrchFrm->getExternalJS(); ?> </div>
  </div>
</div>
