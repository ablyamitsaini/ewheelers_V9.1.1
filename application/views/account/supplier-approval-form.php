<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$approvalFrm->setFormTagAttribute('onsubmit', 'setupSupplierApproval(this); return(false);');
$approvalFrm->setFormTagAttribute('class','form');
$approvalFrm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
$approvalFrm->developerTags['fld_default_col'] = '12';

?>
<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('Lbl_Seller_Approval_Form',$siteLangId);?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
											<div class="form__content">
													<?php echo $approvalFrm->getFormHtml(); ?>
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
