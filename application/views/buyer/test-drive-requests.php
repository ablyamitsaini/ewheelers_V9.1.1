<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
		<div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Test_Drive_Requests', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pt-3 pl-4 pr-4 pb-0">
                            <div class="replaced">
                                <?php
                                $frm->setFormTagAttribute('id', 'frm');
                                $frm->setFormTagAttribute('class', 'form');
                                $frm->setFormTagAttribute('onsubmit', 'searchTestDriveRequest(this); return(false);');
                                $frm->getField('keyword')->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_by_keyword', $siteLangId));
                                $frm->developerTags['colClassPrefix'] = 'col-md-';
                                $frm->developerTags['fld_default_col'] = 12;

                                $keywordFld = $frm->getField('keyword');
                                $keywordFld->setFieldTagAttribute('id', 'tour-step-3');
                                $keywordFld->setWrapperAttribute('class', 'col-lg-4');
                                $keywordFld->developerTags['col'] = 4;

                               
                                $typeFld = $frm->getField('status');
                                $typeFld->setWrapperAttribute('class', 'col-lg-2');
                                $typeFld->developerTags['col'] = 2;

                                $submitFld = $frm->getField('btn_submit');
                                $submitFld->setFieldTagAttribute('class', 'btn--block btn btn--primary');
                                $submitFld->setWrapperAttribute('class', 'col-lg-2');
                                $submitFld->developerTags['col'] = 2;

                                $fldClear= $frm->getField('btn_clear');
                                $fldClear->setFieldTagAttribute('onclick', 'clearSearch()');
                                $fldClear->setFieldTagAttribute('class', 'btn--block btn btn--primary-border');
                                $fldClear->setWrapperAttribute('class', 'col-lg-2');
                                $fldClear->developerTags['col'] = 2;
                          
                                echo $frm->getFormHtml();
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-content pt-2 pl-4 pr-4 pb-4">
                            <div id="listing"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        searchTestDriveRequest(document.frm);
    });

    $(".btn-inline-js").click(function(){
        $(".box-slide-js").slideToggle();
    });
</script>
