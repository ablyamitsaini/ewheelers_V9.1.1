<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOptions->setFormTagAttribute('class', 'form web_form form_horizontal');
$frmOptions->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmOptions->developerTags['fld_default_col'] = 12;
$frmOptions->setFormTagAttribute('onsubmit', 'submitOptionForm(this); return(false);');
echo $frmOptions->getFormHtml();
?>
