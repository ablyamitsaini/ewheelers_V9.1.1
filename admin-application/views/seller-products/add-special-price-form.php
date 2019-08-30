<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="cards-content pt-4 pl-4 pr-4 pb-0">
    <div class="replaced">
        <?php
        echo $addSpecialPriceFrm->getFormTag();
        echo $addSpecialPriceFrm->getFieldHtml('splprice_selprod_id');
        echo $addSpecialPriceFrm->getFieldHtml('addMultiple');

        $startDateFld = $addSpecialPriceFrm->getField('splprice_start_date');
        $startDateFld->setFieldTagAttribute('class', 'date_js');
        $startDateFld->setFieldTagAttribute('id', 'splprice_start_date'.$selProdId);

        $endDateFld = $addSpecialPriceFrm->getField('splprice_end_date');
        $endDateFld->setFieldTagAttribute('class', 'date_js');
        $endDateFld->setFieldTagAttribute('id', 'splprice_end_date'.$selProdId);

        $productName = $addSpecialPriceFrm->getField('product_name');
        if (0 < $selProdId) {
            $productName->setFieldTagAttribute('readonly', 'readonly');
        }

        ?>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addSpecialPriceFrm->getFieldHtml('product_name'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addSpecialPriceFrm->getFieldHtml('splprice_start_date'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addSpecialPriceFrm->getFieldHtml('splprice_end_date'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addSpecialPriceFrm->getFieldHtml('splprice_price'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="field-set">
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $addSpecialPriceFrm->getFieldHtml('btn_update'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="divider"></div>
