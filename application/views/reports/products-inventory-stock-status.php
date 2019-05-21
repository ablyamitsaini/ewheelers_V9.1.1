<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchProductsInventoryStockStatus(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSrch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class', 'col-lg-6');
$keyFld->developerTags['col'] = 6;
$keyFld->developerTags['noCaptionTag'] = true;

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn--block');
$submitBtnFld->setWrapperAttribute('class', 'col-lg-3');
$submitBtnFld->developerTags['col'] = 3;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn--block');
$cancelBtnFld->setWrapperAttribute('class', 'col-lg-3');
$cancelBtnFld->developerTags['col'] = 3;
$cancelBtnFld->developerTags['noCaptionTag'] = true; ?>

<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
   <div class="content-wrapper content-space">
       <div class="content-header row justify-content-between mb-3">
           <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report', $siteLangId);?></h2>
           </div>
       </div>
       <div class="content-body">
           <div class="cards">
               <div class="cards-header p-4">
                   <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report', $siteLangId);?></h5>
               </div>
               <div class="cards-content pl-4 pr-4 ">
                   <div class="grids--profile">
                       <div class="bg-gray-light p-3 pb-0">
                           <div class="row">
                               <div class="col-lg-6">
                                   <?php echo $frmSrch->getFormHtml(); ?>
                               </div>
                           </div>
                       </div>
                       <div id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</main>
