<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frm->setFormTagAttribute('onsubmit', 'uploadCollectionImage(this); return(false);');
    $frm->developerTags['colClassPrefix'] = 'col-md-';
    $frm->developerTags['fld_default_col'] = 12;
    $fld = $frm->getField('collection_image');
    $fld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');
?>
<div class="tabs__content">
    <div class="form__content ">
        <div class="row" id="shopFormBlock">
            <div id="mediaResponse"></div>
            <div class="col-md-4">
                <div class="preview">
                    <small class="text--small"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_logo_text', $siteLangId), '150*150')?></small>
                    <?php echo $frm->getFormHtml();?>
                       <div id="imageLising" class="row" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
