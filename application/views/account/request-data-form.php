<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
	$frm->setFormTagAttribute('class', 'form form--horizontal');
	$frm->setFormTagAttribute('onsubmit', 'setupRequestData(this); return(false);');
?>
<div class="box__head">
	<h4><?php echo Labels::getLabel('LBL_Request_data',$siteLangId); ?></h4>
</div>
<div class="box__body">
	<div class="form__subcontent">
		<?php
		echo $frm->getFormHtml();
		?>
	</div>
</div>