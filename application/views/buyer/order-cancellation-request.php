<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOrderCancel->setFormTagAttribute( 'class', 'form form--horizontal' );
$frmOrderCancel->setFormTagAttribute('onsubmit', 'setupOrderCancelRequest(this); return(false);');
$frmOrderCancel->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderCancel->developerTags['fld_default_col'] = 12;
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Order_Cancellation_Request', $siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header">
				<h5 class="cards-title p-3"></h5>
			</div>
			<div class="cards-content p-3">
				<?php echo $frmOrderCancel->getFormHtml(); ?>
			</div>
		</div>
	</div>
  </div>
</main>