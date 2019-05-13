<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOrderSrch->setFormTagAttribute('onSubmit', 'searchOrders(this); return false;');
$frmOrderSrch->setFormTagAttribute('class', 'form ');
$frmOrderSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmOrderSrch->developerTags['fld_default_col'] = 12;

$keywordFld = $frmOrderSrch->getField('keyword');
$keywordFld->setWrapperAttribute('class', 'col-lg-3');
$keywordFld->developerTags['col'] = 3;
$keywordFld->developerTags['noCaptionTag'] = true;

$statusFld = $frmOrderSrch->getField('status');
$statusFld->setWrapperAttribute('class', 'col-lg-3');
$statusFld->developerTags['col'] = 3;
$statusFld->developerTags['noCaptionTag'] = true;

$priceFromFld = $frmOrderSrch->getField('price_from');
$priceFromFld->setWrapperAttribute('class', 'col-lg-3');
$priceFromFld->developerTags['col'] = 3;
$priceFromFld->developerTags['noCaptionTag'] = true;

$priceToFld = $frmOrderSrch->getField('price_to');
$priceToFld->setWrapperAttribute('class', 'col-lg-3');
$priceToFld->developerTags['col'] = 3;
$priceToFld->developerTags['noCaptionTag'] = true;

$dateFromFld = $frmOrderSrch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class', 'field--calender');
$dateFromFld->setWrapperAttribute('class', 'col-lg-3');
$dateFromFld->developerTags['col'] = 3;
$dateFromFld->developerTags['noCaptionTag'] = true;

$dateToFld = $frmOrderSrch->getField('date_to');
$dateToFld->setFieldTagAttribute('class', 'field--calender');
$dateToFld->setWrapperAttribute('class', 'col-lg-3');
$dateToFld->developerTags['col'] = 3;
$dateToFld->developerTags['noCaptionTag'] = true;

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
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_My_Sales', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="cards">
                <div class="cards-header p-3">
                    <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Search_Orders', $siteLangId); ?></h5>
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
