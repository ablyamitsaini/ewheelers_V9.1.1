<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frmOrderReturnRequest->setFormTagAttribute( 'class', 'form form--horizontal' );
$frmOrderReturnRequest->setFormTagAttribute('onsubmit', 'setupOrderReturnRequest(this); return(false);');
$frmOrderReturnRequest->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderReturnRequest->developerTags['fld_default_col'] = 12;	

$orRequestTypeFld = $frmOrderReturnRequest->getField('orrequest_type');
$orRequestTypeFld->setOptionListTagAttribute('class', 'list-inline');
?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>  
				<div class="col-md-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_Order_Return/Refund/Replace_Request', $siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head">
									<h5></h5>
								</div>
								<div class="box__body">
									<?php echo $frmOrderReturnRequest->getFormHtml(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>