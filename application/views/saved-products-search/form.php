<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frm->setFormTagAttribute('class', 'custom-form setupSaveProductSearch-Js' );
$frm->setFormTagAttribute('onsubmit', 'setupSaveProductSearch(this,event); return(false);');
$search_title_fld = $frm->getField('pssearch_name');
$search_title_fld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search_Title', $siteLangId));
?>

<span class="collection__title"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></span>
<div class="collection__form form">
  <?php 
		echo $frm->getFormTag();
		echo $frm->getFieldHtml('btn_submit');
		echo $frm->getFieldHtml('pssearch_name');
	?>
  </form>
  <?php echo $frm->getExternalJs(); ?> 
</div>