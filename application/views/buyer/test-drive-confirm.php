<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="popup__body">
	<div class="pop-up-title"><?php echo Labels::getLabel('LBL_Add_Feedback_To_Confirm_Request',$siteLangId);?></div>
<?php
$frmTestDriveStatus->setFormTagAttribute('id', 'frmTdConfirmStatus');
$frmTestDriveStatus->setFormTagAttribute('class', 'form');
$frmTestDriveStatus->setFormTagAttribute('onsubmit', 'submitTdFeedbackComment(this); return(false);');
echo $frmTestDriveStatus->getFormTag();
echo $fld = $frmTestDriveStatus->getFieldHtml('ptdr_feedback');
echo $frmTestDriveStatus->getFieldHtml('ptdr_id');
echo $frmTestDriveStatus->getFieldHtml('ptdr_status');
echo $frmTestDriveStatus->getFieldHtml('btn_submit');
echo $frmTestDriveStatus->getExternalJs();
?>
</div>