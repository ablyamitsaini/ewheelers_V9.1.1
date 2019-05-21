<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOrderReturnRequest->setFormTagAttribute( 'class', 'form form--horizontal' );
$frmOrderReturnRequest->setFormTagAttribute('onsubmit', 'setupOrderReturnRequest(this); return(false);');
$frmOrderReturnRequest->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderReturnRequest->developerTags['fld_default_col'] = 12;

$orRequestTypeFld = $frmOrderReturnRequest->getField('orrequest_type');
$orRequestTypeFld->setOptionListTagAttribute('class', 'list-inline');
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header row justify-content-between mb-3">
		<div class="col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Order_Return/Refund/Replace_Request', $siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header p-4">
				<h5 class="cards-title"></h5>
			</div>
			<div class="cards-content pl-4 pr-4 ">
				<div class="form__content">
					<?php echo $frmOrderReturnRequest->getFormHtml(); ?>
				</div>
			</div>
		</div>
	</div>
  </div>
</main>
