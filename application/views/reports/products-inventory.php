<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchProductsInventory(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSrch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class', 'col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn--block');
$submitBtnFld->setWrapperAttribute('class', 'col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn--block');
$cancelBtnFld->setWrapperAttribute('class', 'col-sm-3');
$cancelBtnFld->developerTags['col'] = 2; ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Report', $siteLangId);?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="cards">
                <div class="cards-header p-3">
                    <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Report', $siteLangId);?></h5>
                    <div class="action">
                        <?php
                            echo '<div class="btn-group"><a href="javascript:void(0)" onClick="exportProductsInventoryReport()" class="btn btn--secondary btn--sm">'.Labels::getLabel('LBL_Export', $siteLangId).'</a></div>';?>
                    </div>
                </div>
                <div class="cards-content p-3">
                    <div class="grids--profile">
                        <div class="bg-gray-light p-3 pb-0"> <?php echo $frmSrch->getFormHtml(); ?> </div>
                        <div id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
