<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmOrderSrch->setFormTagAttribute('onSubmit','searchOrders(this); return false;');
$frmOrderSrch->setFormTagAttribute('class', 'form');
$frmOrderSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderSrch->developerTags['fld_default_col'] = 12;


$keywordFld = $frmOrderSrch->getField('keyword');
$keywordFld->setWrapperAttribute('class','col-sm-6');
$keywordFld->developerTags['col'] = 8;
/* $keywordFld->htmlAfterField = '<small class="text--small">'.Labels::getLabel('LBL_Buyer_account_orders_listing_search_form_keyword_help_txt', $siteLangId).'</small>'; */

$statusFld = $frmOrderSrch->getField('status');
$statusFld->setWrapperAttribute('class','col-sm-6');
$statusFld->developerTags['col'] = 4;

$dateFromFld = $frmOrderSrch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class','field--calender');
$dateFromFld->setWrapperAttribute('class','col-sm-6');
$dateFromFld->developerTags['col'] = 2;

$dateToFld = $frmOrderSrch->getField('date_to');
$dateToFld->setFieldTagAttribute('class','field--calender');
$dateToFld->setWrapperAttribute('class','col-sm-6');
$dateToFld->developerTags['col'] = 2;

$priceFromFld = $frmOrderSrch->getField('price_from');
$priceFromFld->setWrapperAttribute('class','col-sm-6');
$priceFromFld->developerTags['col'] = 2;

$priceToFld = $frmOrderSrch->getField('price_to');
$priceToFld->setWrapperAttribute('class','col-sm-6');
$priceToFld->developerTags['col'] = 2;

$submitBtnFld = $frmOrderSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-6');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmOrderSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-6');
$cancelBtnFld->developerTags['col'] = 2;
?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full" >

					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_My_Orders', $siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
									<h5><?php echo Labels::getLabel('LBL_Search_Orders', $siteLangId); ?></h5>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
										<?php echo $frmOrderSrch->getFormHtml(); ?>
									</div>
									<span class="gap"></span>
									<div id="ordersListing"></div>
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
