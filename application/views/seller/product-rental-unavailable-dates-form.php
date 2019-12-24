<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="popup__body">
    <h2><?php echo Labels::getLabel('LBL_Rental_Unavailable_Dates', $siteLangId);?></h2>
    <?php
    $unavailableDatesForm->setFormTagAttribute('onsubmit', 'setUpRentalUnavailableDates(this); return(false);');
    $unavailableDatesForm->setFormTagAttribute('class', 'form');
    $unavailableDatesForm->developerTags['colClassPrefix'] = 'col-md-';
    $unavailableDatesForm->developerTags['fld_default_col'] = 6;
    $btnCancelFld = $unavailableDatesForm->getField('btn_cancel');
    $btnCancelFld->setFieldTagAttribute('onClick', 'productRentalUnavailableDates('. $selprod_id .');');
    echo $unavailableDatesForm->getFormHtml(); ?>
</div>
<script>
$(document).ready(function(){
	setCurrDateFordatePicker();
});
</script>