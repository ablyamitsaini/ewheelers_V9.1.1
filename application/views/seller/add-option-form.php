<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOptions->setFormTagAttribute('class', 'form web_form form_horizontal');
$frmOptions->setFormTagAttribute('onsubmit', 'submitOptionForm(this); return(false);');
echo $frmOptions->getFormHtml();
?>
