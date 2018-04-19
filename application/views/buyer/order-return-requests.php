<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$frmOrderReturnRequestsSrch->setFormTagAttribute('onSubmit','searchOrderReturnRequests(this); return false;');
$frmOrderReturnRequestsSrch->setFormTagAttribute('class', 'form'); 
$frmOrderReturnRequestsSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderReturnRequestsSrch->developerTags['fld_default_col'] = 12;
	
$keywordFld = $frmOrderReturnRequestsSrch->getField('keyword');
$keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keywordFld->htmlAfterField = '<small class="text--small">'.Labels::getLabel('LBL_Search_in_Order_Id/Invoice_number,_Product_Name,_Brand_Name,_SKU,_Model,_,Request_reference_number', $siteLangId).'</small>';
$keywordFld->setWrapperAttribute('class','col-sm-6');
$keywordFld->developerTags['col'] = 8;

$statusFld = $frmOrderReturnRequestsSrch->getField('orrequest_status');
$statusFld->setWrapperAttribute('class','col-sm-6');
$statusFld->developerTags['col'] = 4;
	
$orrequestDateFromFld = $frmOrderReturnRequestsSrch->getField('orrequest_date_from');
$orrequestDateFromFld->setFieldTagAttribute('class','field--calender');
$orrequestDateFromFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_From', $siteLangId));
$orrequestDateFromFld->setWrapperAttribute('class','col-sm-6');
$orrequestDateFromFld->developerTags['col'] = 4;

$orrequestDateToFld = $frmOrderReturnRequestsSrch->getField('orrequest_date_to');
$orrequestDateToFld->setFieldTagAttribute('class','field--calender');
$orrequestDateToFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Date_to', $siteLangId));
$orrequestDateToFld->setWrapperAttribute('class','col-sm-6');
$orrequestDateToFld->developerTags['col'] = 4;
	
$submitBtnFld = $frmOrderReturnRequestsSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-6');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmOrderReturnRequestsSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-6');
$cancelBtnFld->developerTags['col'] = 2;
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
							<h2><?php echo Labels::getLabel('LBL_Order_Return_Requests', $siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
									<h5><?php echo Labels::getLabel('LBL_Search_Order_Return_Requests', $siteLangId); ?></h5>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
										<?php echo $frmOrderReturnRequestsSrch->getFormHtml(); ?>
									</div>
									<span class="gap"></span>
									<div id="returnOrderRequestsListing"></div>
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