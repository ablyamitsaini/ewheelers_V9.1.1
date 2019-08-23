<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="cards-content pt-4 pl-4 pr-4 pb-0">
    <div class="replaced">
        <?php
        if (empty($addMultiple)) {
            $addVolDiscountFrmClone->fill(array());
            $addVolDiscountFrm = $addVolDiscountFrmClone;
        }
            echo $addVolDiscountFrm->getFormTag();
            echo $addVolDiscountFrm->getFieldHtml('voldiscount_selprod_id');
            echo $addVolDiscountFrm->getFieldHtml('selector');

        if (!empty($addMultiple) && 1 == $addMultiple) {
            $addVolDiscountFrm->addHiddenField('', 'addMultiple', $addMultiple);
            echo $addVolDiscountFrm->getFieldHtml('addMultiple');
        }

        ?>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addVolDiscountFrm->getFieldHtml('product_name'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addVolDiscountFrm->getFieldHtml('voldiscount_min_qty'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="field-set">
                        <div class="field-wraper">
                            <?php echo $addVolDiscountFrm->getFieldHtml('voldiscount_percentage'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <div class="field-set">
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $addVolDiscountFrm->getFieldHtml('btn_update'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="divider"></div>
