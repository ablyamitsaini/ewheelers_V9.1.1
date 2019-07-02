<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form ');

$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute('onSubmit', 'uploadZip(); return false;');

$variables = array('siteLangId'=>$siteLangId,'action'=>$action);
$this->includeTemplate('import-export/_partial/top-navigation.php', $variables, false); ?>

<div class="content-body">
    <div class="replaced">
        <?php echo $frm->getFormHtml();  ?>
    </div>
    <span class="gap"></span><span class="gap"></span>
    <div class="cards">
        <div class="cards-header p-4">
            <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Uploaded_Media_Directory_List', $siteLangId); ?></h5>
        </div>
        <div class="cards-content pl-4 pr-4 ">
            <div class="row">
                <div class="col-lg-12">
                    <div id="listing"> <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?></div>
                    <span class="gap"></span>
                </div>
            </div>
        </div>
        <span class="gap"></span>
    </div>
</div>
