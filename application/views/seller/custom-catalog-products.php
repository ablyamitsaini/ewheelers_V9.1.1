<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearchCustomCatalogProducts->setFormTagAttribute('onSubmit', 'searchCustomCatalogProducts(this); return(false);');

    $frmSearchCustomCatalogProducts->setFormTagAttribute('class', 'form');
    $frmSearchCustomCatalogProducts->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearchCustomCatalogProducts->developerTags['fld_default_col'] = 12;

    $keyFld = $frmSearchCustomCatalogProducts->getField('keyword');
    $keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
    $keyFld->setWrapperAttribute('class', 'col-lg-6');
    $keyFld->developerTags['col'] = 6;
    $keyFld->developerTags['noCaptionTag'] = true;

    $submitBtnFld = $frmSearchCustomCatalogProducts->getField('btn_submit');
    $submitBtnFld->setFieldTagAttribute('class', 'btn--block');
    $submitBtnFld->setWrapperAttribute('class', 'col-lg-3');
    $submitBtnFld->developerTags['col'] = 3;
    $submitBtnFld->developerTags['noCaptionTag'] = true;

    $cancelBtnFld = $frmSearchCustomCatalogProducts->getField('btn_clear');
    $cancelBtnFld->setFieldTagAttribute('class', 'btn--block');
    $cancelBtnFld->setWrapperAttribute('class', 'col-lg-3');
    $cancelBtnFld->developerTags['col'] = 3;
    $cancelBtnFld->developerTags['noCaptionTag'] = true;
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <?php $this->includeTemplate('_partial/productPagesTabs.php', array('siteLangId'=>$siteLangId,'controllerName'=>$controllerName,'action'=>$action), false); ?>
                <h2 class="content-header-title">
                    <?php echo Labels::getLabel('LBL_Requested_Products', $siteLangId); ?>
                    <div class="delivery-term">
                        <a href="javascript:void(0)" class="initTooltip" rel="facebox"> <i class="fa fa-question-circle"></i></a>
                        <div id="requestedProductsToolTip" style="display:none">
                            <div class="delivery-term-data-inner">
                                <div class="heading">Requested Products<span>All the information you need regarding this page</span></div>
                                <ul>
                                    <li>This tab lists all the products requested by seller to the admin which are not available in the marketplace products.</li>
                                    <li>On admin approval, the product will be added to the marketplace products and to the seller inventory.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </h2>
            </div>
        </div>
        <div class="content-body">
            <div class="cards">
                <div class="cards-header p-3">
                    <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Search_Products', $siteLangId); ?></h5>
                    <div class="action">
                        <?php if (User::canAddCustomProductAvailableToAllSellers()) {?>
                        <a href="<?php echo CommonHelper::generateUrl('Seller', 'customCatalogProductForm');?>" class="btn btn--primary ripplelink btn--sm"><?php echo Labels::getLabel('LBL_Request_New_Product', $siteLangId);?></a>
                        <?php }?>
                    </div>
                </div>
                <div class="cards-content p-3">
                    <div class="bg-gray-light p-3 pb-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo $frmSearchCustomCatalogProducts->getFormHtml(); ?>
                                <?php echo $frmSearchCustomCatalogProducts->getExternalJS(); ?>
                            </div>
                        </div>
                    </div>
                    <span class="gap"></span>
                    <div id="listing">
                        <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $(".initTooltip").click(function(){
            $.facebox({ div: '#requestedProductsToolTip' }, 'catalog-bg');
        });
    });
</script>
