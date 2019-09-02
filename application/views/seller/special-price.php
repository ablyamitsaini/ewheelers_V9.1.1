<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearch->setFormTagAttribute('class', 'web_form last_td_nowrap');
    $frmSearch->setFormTagAttribute('onsubmit', 'searchSpecialPriceProducts(this); return(false);');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;

    $keywordFld = $frmSearch->getField('keyword');
    $keywordFld->setWrapperAttribute('class', 'col-lg-4');
    $keywordFld->developerTags['col'] = 4;
    $keywordFld->developerTags['noCaptionTag'] = true;

    $submitBtnFld = $frmSearch->getField('btn_submit');
    $submitBtnFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');
    $submitBtnFld->developerTags['col'] = 2;
    $submitBtnFld->developerTags['noCaptionTag'] = true;

    $cancelBtnFld = $frmSearch->getField('btn_clear');
    $cancelBtnFld->setFieldTagAttribute('class', 'btn--block btn btn--primary-border');
    $cancelBtnFld->developerTags['col'] = 2;
    $cancelBtnFld->developerTags['noCaptionTag'] = true;

    $updateBtnFld = $addSpecialPriceFrm->getField('btn_update');
    $updateBtnFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');

if (0 < $selProd_id) {
    $keywordFld = $frmSearch->getField('keyword');
    $keywordFld->setFieldTagAttribute('readonly', 'readonly');
}
    $prodName = $addSpecialPriceFrm->getField('product_name');
    $prodName->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Select_Product', $siteLangId));

    $startDate = $addSpecialPriceFrm->getField('splprice_start_date');
    $startDate->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Price_Start_Date', $siteLangId));
    $startDate->setFieldTagAttribute('class', 'date_js');

    $endDate = $addSpecialPriceFrm->getField('splprice_end_date');
    $endDate->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Price_End_Date', $siteLangId));
    $endDate->setFieldTagAttribute('class', 'date_js');

    $splPrice = $addSpecialPriceFrm->getField('splprice_price');
    $splPrice->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Special_Price', $siteLangId));

    $addSpecialPriceFrm->setFormTagAttribute('class', 'web_form');
    $addSpecialPriceFrm->setFormTagAttribute('id', 'frmAddSpecialPrice');
    $addSpecialPriceFrm->setFormTagAttribute('name', 'frmAddSpecialPrice');
    $addSpecialPriceFrm->setFormTagAttribute('onsubmit', 'updateSpecialPriceRow(this, '.$selProd_id.'); return(false);');

    $addSpecialPriceFrm->addHiddenField('', 'addMultiple', 0);
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Seller_Products_Special_Price_List', $siteLangId); ?></h2>
            </div>
            <div class="col-auto">
                <div class="action">
                    <a class="btn btn--primary btn--sm" title="<?php echo Labels::getLabel('LBL_Add_Special_Price', $siteLangId); ?>" onclick="addSpecialPrice()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Add_Special_Price', $siteLangId); ?></a>
                    <div class="gap"></div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pt-4 pl-4 pr-4 pb-4">
                            <div class="replaced">
                                <?php echo $frmSearch->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cards">
                        <?php
                        foreach ($dataToEdit as $value) {
                            $selProdId = $value['splprice_selprod_id'];
                            $cloneFrm = clone $addSpecialPriceFrm;
                            $value['addMultiple'] = 1;
                            $cloneFrm->fill($value, true);
                            $cloneFrm->setFormTagAttribute('id', 'frmAddSpecialPrice-'.$selProdId);
                            $cloneFrm->setFormTagAttribute('name', 'frmAddSpecialPrice-'.$selProdId);
                            /*$productName = $cloneFrm->getField('product_name');
                            $productName->setFieldTagAttribute('readonly', 'readonly');*/

                            $startDate = $cloneFrm->getField('splprice_start_date');
                            $startDate->setFieldTagAttribute('id', 'splprice_start_date'.$selProdId);

                            $endDate = $cloneFrm->getField('splprice_end_date');
                            $endDate->setFieldTagAttribute('id', 'splprice_end_date'.$selProdId);

                            $this->includeTemplate('seller/add-special-price-form.php', array('addSpecialPriceFrm'=>$cloneFrm), false);
                        }
                        $startDate = $addSpecialPriceFrm->getField('splprice_start_date');
                        $startDate->setFieldTagAttribute('id', 'splprice_start_date0');

                        $endDate = $addSpecialPriceFrm->getField('splprice_end_date');
                        $endDate->setFieldTagAttribute('id', 'splprice_end_date0');

                        $addSpecialPriceFrm->fill(array('product_name'=>'', 'splprice_selprod_id'=> ''));
                        $this->includeTemplate('seller/add-special-price-form.php', array('addSpecialPriceFrm'=>$addSpecialPriceFrm), false);
                        ?>
                        <div class="cards-content pl-4 pr-4">
                            <div class="row justify-content-between">
                                <div class="col-auto"></div>
                                 <div class="col-auto">
                                    <div class="action">
                                        <a class="btn btn--primary-border btn--sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Delete_Special_Price', $siteLangId); ?>" onclick="deleteSpecialPriceRows()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Delete_Special_Price', $siteLangId); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                            </div>
                            <span class="gap"></span>
                        </div>
                    </div>
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
