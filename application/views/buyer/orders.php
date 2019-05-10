<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmOrderSrch->setFormTagAttribute('onSubmit', 'searchOrders(this); return false;');
$frmOrderSrch->setFormTagAttribute('class', 'form');
$frmOrderSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderSrch->developerTags['fld_default_col'] = 12;

$keywordFld = $frmOrderSrch->getField('keyword');
$keywordFld->setWrapperAttribute('class', 'col-lg-2');
$keywordFld->developerTags['col'] = 2;
$keywordFld->developerTags['noCaptionTag'] = true;
/* $keywordFld->htmlAfterField = '<small class="text--small">'.Labels::getLabel('LBL_Buyer_account_orders_listing_search_form_keyword_help_txt', $siteLangId).'</small>'; */

$statusFld = $frmOrderSrch->getField('status');
$statusFld->setWrapperAttribute('class', 'col-lg-2');
$statusFld->developerTags['col'] = 2;
$statusFld->developerTags['noCaptionTag'] = true;

$dateFromFld = $frmOrderSrch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class', 'field--calender');
$dateFromFld->setWrapperAttribute('class', 'col-lg-2');
$dateFromFld->developerTags['col'] = 2;
$dateFromFld->developerTags['noCaptionTag'] = true;

$dateToFld = $frmOrderSrch->getField('date_to');
$dateToFld->setFieldTagAttribute('class', 'field--calender');
$dateToFld->setWrapperAttribute('class', 'col-lg-2');
$dateToFld->developerTags['col'] = 2;
$dateToFld->developerTags['noCaptionTag'] = true;

$priceFromFld = $frmOrderSrch->getField('price_from');
$priceFromFld->setWrapperAttribute('class', 'col-lg-2');
$priceFromFld->developerTags['col'] = 2;
$priceFromFld->developerTags['noCaptionTag'] = true;

$priceToFld = $frmOrderSrch->getField('price_to');
$priceToFld->setWrapperAttribute('class', 'col-lg-2');
$priceToFld->developerTags['col'] = 2;
$priceToFld->developerTags['noCaptionTag'] = true;

$submitBtnFld = $frmOrderSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn--block');
$submitBtnFld->setWrapperAttribute('class', 'col-lg-2');
$submitBtnFld->developerTags['col'] = 2;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmOrderSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn--block');
$cancelBtnFld->setWrapperAttribute('class', 'col-lg-2');
$cancelBtnFld->developerTags['col'] = 2;
$cancelBtnFld->developerTags['noCaptionTag'] = true;
?>
<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
    <div class="content-header justify-content-between row mb-3">
        <div class="content-header-left col-md-auto">
            <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
            <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_My_Orders', $siteLangId); ?></h2>
        </div>
    </div>
    <div class="content-body">
        <div class="cards">
            <div class="cards-header">
                <h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Search_Orders', $siteLangId); ?></h5>
            </div>
            <div class="cards-content p-3">
                <div class="bg-gray-light p-3 pb-0">
                    <?php echo $frmOrderSrch->getFormHtml(); ?>
                </div>
                <span class="gap"></span>
                <div id="ordersListing"></div>
            </div>
        </div>
    </div>
  </div>
</main>
