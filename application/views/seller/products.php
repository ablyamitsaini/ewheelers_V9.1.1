<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearch->setFormTagAttribute('onSubmit', 'sellerProducts(0,1); return(false);');

    $frmSearch->setFormTagAttribute('class', 'form');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 12;

    $keyFld = $frmSearch->getField('keyword');
    $keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
    $keyFld->setWrapperAttribute('class', 'col-lg-6');
    $keyFld->developerTags['col'] = 6;
    $keyFld->developerTags['noCaptionTag'] = true;

    $submitBtnFld = $frmSearch->getField('btn_submit');
    $submitBtnFld->setFieldTagAttribute('class', 'btn--block');
    $submitBtnFld->setWrapperAttribute('class', 'col-lg-3');
    $submitBtnFld->developerTags['col'] = 3;
    $submitBtnFld->developerTags['noCaptionTag'] = true;

    $cancelBtnFld = $frmSearch->getField('btn_clear');
    $cancelBtnFld->setFieldTagAttribute('class', 'btn--block');
    $cancelBtnFld->setWrapperAttribute('class', 'col-lg-3');
    $cancelBtnFld->developerTags['col'] = 3;
    $cancelBtnFld->developerTags['noCaptionTag'] = true; ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header">
            
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <?php $this->includeTemplate('_partial/productPagesTabs.php', array('siteLangId'=>$siteLangId,'controllerName'=>$controllerName,'action'=>$action), false); ?>
                <h2 class="content-header-title">
                    <?php
                    // echo Labels::getLabel('LBL_Store_Inventory', $siteLangId);
                    ?>
                    <div class="delivery-term">
                        <div id="inventoryToolTip" style="display:none">
                            <div class="delivery-term-data-inner">
                                <div class="heading">Store Inventory<span>All the information you need regarding this page</span></div>
                                <ul>
                                    <li>This tab lists all the products available to your front end store.</li>
                                    <li>For each product variant, separate copy need to be created by seller either from Marketplace product tab or clone product icon.</li>
                                    <li>To add new product to your store inventory, seller will have to pick the products from the marketplace products tabs from "Add to Store" button</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </h2>
            </div>
       
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-header p-4">
                            <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Search_your_inventory', $siteLangId); ?></h5>
                            <div class="action">
                                <a class="btn btn--primary formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Make_Active', $siteLangId); ?>" onclick="toggleBulkStatues(1)" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Make_Active', $siteLangId); ?></a>
                                <a class="btn btn--primary-border formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Make_InActive', $siteLangId); ?>" onclick="toggleBulkStatues(0)" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Make_InActive', $siteLangId); ?></a>
                                <a class="btn btn--primary formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Delete_selected', $siteLangId); ?>" onclick="deleteBulkSellerProducts()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Delete_selected', $siteLangId); ?></a>
                            </div>
                        </div>
                        <div class="cards-content pl-4 pr-4 pb-4">
                            <div class="bg-gray-light p-4 pb-0">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php
                                        $submitFld = $frmSearch->getField('btn_submit');
                                        $submitFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');

                                        $fldClear= $frmSearch->getField('btn_clear');
                                        $fldClear->setFieldTagAttribute('class', 'btn--block btn btn--primary-border');

                                        echo $frmSearch->getFormHtml();
                                        ?>
                                        <?php echo $frmSearch->getExternalJS();?>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cards">
                        
                        <div class="cards-content pl-4 pr-4 pt-4">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                            <span class="gap"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo FatUtility::createHiddenFormFromData(array('product_id'=>$product_id), array('name' => 'frmSearchSellerProducts'));?>
<script>
    jQuery(document).ready(function($) {
        $(".initTooltip").click(function(){
            $.facebox({ div: '#inventoryToolTip' }, 'catalog-bg');
        });
    });
</script>
