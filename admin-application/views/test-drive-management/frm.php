<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Update_Test_Drive_Credit_Settings',$adminLangId); ?></h4>

	</div>
<div class="wrapcenter" style="margin-top:20px">
	<?php 
		$frm->setFormTagAttribute('onsubmit', 'addTestDriveSettings(this); return(false);'); 
		$frm->developerTags['fld_default_col'] = 12;
		$fld = $frm->getField('btn_submit');
		$fld->developerTags['col'] = 12;
		$fld->setFieldTagAttribute('class', 'btn btn--primary block-on-mobile');
		$fld->setFieldTagAttribute('id', 'addSettings');
		echo $frm->getFormHtml();
	?>
</div>
</section>

