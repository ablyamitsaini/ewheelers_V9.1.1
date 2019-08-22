<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearch->setFormTagAttribute('class', 'web_form last_td_nowrap');
    $frmSearch->setFormTagAttribute('onsubmit', 'searchVolumeDiscountProducts(this); return(false);');
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

    $addVolDiscountfrm->setFormTagAttribute('class', 'web_form last_td_nowrap');
    $addVolDiscountfrm->setFormTagAttribute('id', 'frmAddVolumeDiscount');
    $addVolDiscountfrm->setFormTagAttribute('onsubmit', 'updateVolumeDiscount(this); return(false);');

    $updateBtnFld = $addVolDiscountfrm->getField('btn_update');
    $updateBtnFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');

    $addVolDiscountfrm->addHiddenField('', 'selector', 1);

    $prodName = $addVolDiscountfrm->getField('product_name');
    $prodName->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Select_Product', $siteLangId));

    $minQty = $addVolDiscountfrm->getField('voldiscount_min_qty');
    $minQty->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Minimum_Quantity', $siteLangId));

    $disPerc = $addVolDiscountfrm->getField('voldiscount_percentage');
    $disPerc->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Discount_Percentage', $siteLangId));
?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Manage_Volume_Discount', $siteLangId); ?></h2>
            </div>
            <div class="col-auto">
                <div class="action">
                    <a class="btn btn--primary btn--sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?>" onclick="deleteVolumeDiscount()" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Remove_Volume_Discount', $siteLangId); ?></a>
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
                        <div class="cards-content pl-4 pr-4 pt-4">
                            <div class="replaced">
                                <?php
                                    echo $addVolDiscountfrm->getFormTag();
                                    echo $addVolDiscountfrm->getFieldHtml('voldiscount_selprod_id');
                                    echo $addVolDiscountfrm->getFieldHtml('selector');
                                ?>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="field-set">
                                                <div class="field-wraper">
                                                    <?php echo $addVolDiscountfrm->getFieldHtml('product_name'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="field-set">
                                                <div class="field-wraper">
                                                    <?php echo $addVolDiscountfrm->getFieldHtml('voldiscount_min_qty'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="field-set">
                                                <div class="field-wraper">
                                                    <?php echo $addVolDiscountfrm->getFieldHtml('voldiscount_percentage'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <div class="field-set">
                                                <div class="field-wraper">
                                                    <div class="field_cover">
                                                        <?php echo $addVolDiscountfrm->getFieldHtml('btn_update'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <span class="gap"></span>
                            <div class="divider"></div>
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
