<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('id', 'supplierRequestForm');
$frm->setFormTagAttribute('onsubmit', 'updateBrandRequest(this); return(false);');
$frm->setValidatorJsObjectName('brandRequestFormValidator');

$fld = $frm->getField('status');
$fld->setFieldTagAttribute('onChange','showHideCommentBox(this.value)');

$fldBl = $frm->getField('comments');
$fldBl->htmlBeforeField = '<span id="div_comments_box" class="hide">Reason for Cancellation';
$fldBl->htmlAfterField = '</span>';
?>
<div class="col-sm-12">
	<h1><?php echo Labels::getLabel('LBL_Update_Status',$adminLangId); ?></h1>
	<div class="tabs_nav_container responsive flat">		
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $frm->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>