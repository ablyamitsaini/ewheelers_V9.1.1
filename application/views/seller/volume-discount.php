<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearch->setFormTagAttribute('class', 'form');
    $frmSearch->setFormTagAttribute('onsubmit', 'searchVolumeDiscountProducts(this); return(false);');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;

    $keywordFld = $frmSearch->getField('keyword');
    $keywordFld->setWrapperAttribute('class', 'col-lg-4');
    $keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_by_keyword', $siteLangId));
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

    $updateBtnFld = $addVolDiscountFrm->getField('btn_update');
    $updateBtnFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');

    $addVolDiscountFrm->addHiddenField('', 'selector', 1);

    $prodName = $addVolDiscountFrm->getField('product_name');
    $prodName->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Select_Product', $siteLangId));

    $minQty = $addVolDiscountFrm->getField('voldiscount_min_qty');
    $minQty->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Minimum_Quantity', $siteLangId));

    $disPerc = $addVolDiscountFrm->getField('voldiscount_percentage');
    $disPerc->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Discount_Percentage', $siteLangId));

    $addVolDiscountFrm->setFormTagAttribute('class', 'form');
    $addVolDiscountFrm->setFormTagAttribute('id', 'frmAddVolumeDiscount');
    $addVolDiscountFrm->setFormTagAttribute('name', 'frmAddVolumeDiscount');
    $addVolDiscountFrm->setFormTagAttribute('onsubmit', 'updateVolumeDiscount(this); return(false);');
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Manage_Volume_Discount', $siteLangId); ?></h2>
            </div>

        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pt-4 pl-4 pr-4 pb-0">
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
                        $clone = clone $addVolDiscountFrm;

                        foreach ($dataToUpdate as $key => $value) {
                            $addVolDiscountFrm->fill($value);
                            $addVolDiscountFrm->setFormTagAttribute('class', 'form');
                            $addVolDiscountFrm->setFormTagAttribute('id', 'frmAddVolumeDiscount-'.$key);
                            $addVolDiscountFrm->setFormTagAttribute('name', 'frmAddVolumeDiscount-'.$key);
                            $addVolDiscountFrm->setFormTagAttribute('onsubmit', 'updateVolumeDiscount(this); return(false);');
                            $productName = $addVolDiscountFrm->getField('product_name');
                            $productName->setFieldTagAttribute('readonly', 'readonly');
                            $this->includeTemplate('seller/add-volume-discount-form.php', array('addVolDiscountFrm'=>$addVolDiscountFrm, 'addMultiple' => 1), false);
                        }
                        $this->includeTemplate('seller/add-volume-discount-form0.php', array('addVolDiscountFrmClone'=>$clone), false);


                        ?>
                        <div class="cards-content pl-4 pr-4">
                            <div class="row justify-content-between">
                                <div class="col-auto"></div>
                                 <div class="col-auto">
                                    <div class="action">
                                        <a class="btn btn--primary-border btn--sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?>" onclick="deleteVolumeDiscount()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?></a>

                                    </div>
                                </div>
                            </div>
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
