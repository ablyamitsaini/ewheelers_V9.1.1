<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="box__head">
  <h4><?php echo Labels::getLabel('LBL_Clone_Inventory',$siteLangId); ?></h4>
</div>
<div class="box__body">
    <?php
		$frm->setFormTagAttribute('class', 'form form--horizontal');
		$frm->setFormTagAttribute('onsubmit','setUpSellerProductClone(this); return(false);');
		echo $frm->getFormHtml();
	?>
</div>
