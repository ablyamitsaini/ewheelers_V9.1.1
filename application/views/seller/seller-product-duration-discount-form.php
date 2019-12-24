<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="popup__body">
    <h2><?php echo Labels::getLabel('LBL_Duration_Discount', $siteLangId);?></h2>
    <?php
    $frmSellerProductDurationDiscount->setFormTagAttribute('onsubmit', 'setUpSellerProductDurationDiscount(this); return(false);');
    $frmSellerProductDurationDiscount->setFormTagAttribute('class', 'form');
    $frmSellerProductDurationDiscount->developerTags['colClassPrefix'] = 'col-md-';
    $frmSellerProductDurationDiscount->developerTags['fld_default_col'] = 6;

    $btnCancelFld = $frmSellerProductDurationDiscount->getField('btn_cancel');
    $btnCancelFld->setFieldTagAttribute('onClick', 'sellerProductDurationDiscounts(' . $selprod_id . ');');
    echo $frmSellerProductDurationDiscount->getFormHtml(); ?>
</div>
