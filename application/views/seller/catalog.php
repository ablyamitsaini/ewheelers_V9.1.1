<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <?php $this->includeTemplate('_partial/productPagesTabs.php', array('siteLangId'=>$siteLangId,'controllerName'=>$controllerName,'action'=>$action), false); ?>
                <h2 class="content-header-title">
                    <?php echo Labels::getLabel('LBL_Marketplace_Products', $siteLangId); ?>
                    <div class="delivery-term">
                        <a href="javascript:void(0)" class="initTooltip" rel="facebox"> <i class="fa fa-question-circle"></i></a>
                        <div id="catalogToolTip" style="display:none">
                            <div class="delivery-term-data-inner">
                                <div class="heading">Products<span>All the information you need regarding this page</span></div>
                                <ul class="">
                                    <li>
                                        This page lists all the marketplace products added by admin and seller.
                                        Marketplace products are of two types:-
                                        <ul>
                                            <li><strong>System Products</strong>: Available to all sellers and any seller can add to their own store.</li>
                                            <li><strong>My Products</strong>: Available only for you. No other seller can add to their own store.</li>
                                        </ul>
                                    </li>
                                    <li>On clicking "<strong>Add Product</strong>" button, seller can add new product to marketplace products.</li>
                                    <li>On click of "<strong>Add to Store</strong>" the seller can pick the product and add the products to his store inventory.</li>
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
                    <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Search_Products', $siteLangId); ?></h5>
                    <div class="action">
                        <?php if (User::canAddCustomProduct()) { ?>
                        <a href="<?php echo CommonHelper::generateUrl('seller', 'customProductForm');?>" class="btn btn--primary ripplelink btn--sm"><?php echo Labels::getLabel('LBL_Add_New_Product', $siteLangId);?></a>
                        <?php }
                        ?>
                        <!--<a href="<?php /* echo CommonHelper::generateUrl('seller','products');?>" class="btn btn--primary btn--sm "><?php echo Labels::getLabel( 'LBL_My_Inventory', $siteLangId) */?></a>-->
                        <?php if ((isset($canAddCustomProduct) && $canAddCustomProduct==false) && (isset($canRequestProduct) && $canRequestProduct === true)) {?>
                        <a href="<?php echo CommonHelper::generateUrl('Seller', 'requestedCatalog');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Request_A_Product', $siteLangId);?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="cards-content p-3">
                    <div class="bg-gray-light p-3 pb-0">
                        <?php
                        $frmSearchCatalogProduct->setFormTagAttribute('id', 'frmSearchCatalogProduct');
                        $frmSearchCatalogProduct->setFormTagAttribute('class', 'form');
                        $frmSearchCatalogProduct->setFormTagAttribute('onsubmit', 'searchCatalogProducts(this); return(false);');
                        $frmSearchCatalogProduct->getField('keyword')->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_by_keyword/EAN/ISBN/UPC_code', $siteLangId));
                        $frmSearchCatalogProduct->developerTags['colClassPrefix'] = 'col-md-';
                        $frmSearchCatalogProduct->developerTags['fld_default_col'] = 12;

                        $keywordFld = $frmSearchCatalogProduct->getField('keyword');
                        $keywordFld->setFieldTagAttribute('id', 'tour-step-3');
                        $keywordFld->setWrapperAttribute('class', 'col-lg-4');
                        $keywordFld->developerTags['col'] = 4;

                        if (FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT')) {
                            $dateFromFld = $frmSearchCatalogProduct->getField('type');
                            $dateFromFld->setFieldTagAttribute('class', '');
                            $dateFromFld->setWrapperAttribute('class', 'col-lg-2');
                            $dateFromFld->developerTags['col'] = 2;
                        }
                        $typeFld = $frmSearchCatalogProduct->getField('product_type');
                        $typeFld->setWrapperAttribute('class', 'col-lg-2');
                        $typeFld->developerTags['col'] = 2;

                        $submitFld = $frmSearchCatalogProduct->getField('btn_submit');
                        $submitFld->setFieldTagAttribute('class', 'btn--block');
                        $submitFld->setWrapperAttribute('class', 'col-lg-2');
                        $submitFld->developerTags['col'] = 2;

                        $fldClear= $frmSearchCatalogProduct->getField('btn_clear');
                        $fldClear->setFieldTagAttribute('onclick', 'clearSearch()');
                        $fldClear->setFieldTagAttribute('class', 'btn--block');
                        $fldClear->setWrapperAttribute('class', 'col-lg-2');
                        $fldClear->developerTags['col'] = 2;
                            /* if( User::canAddCustomProductAvailableToAllSellers() ){
                              $submitFld = $frmSearchCatalogProduct->getField('btn_submit');
                              $submitFld->setFieldTagAttribute('class','btn--block');
                              $submitFld->developerTags['col'] = 4;
                            } */
                        echo $frmSearchCatalogProduct->getFormHtml();
                        ?>
                    </div>
                    <span class="gap"></span>
                    <div id="listing"> </div>
                    <span class="gap"></span>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
    <?php if (!$displayDefaultListing) { ?>
        searchCatalogProducts(document.frmSearchCatalogProduct);
    <?php } ?>
    });

    $(".btn-inline-js").click(function(){
        $(".box-slide-js").slideToggle();
    });

    $(".initTooltip").click(function(){
        $.facebox({ div: '#catalogToolTip' }, 'catalog-bg');
    });
</script>
