<?php
   defined('SYSTEM_INIT') or die('Invalid Usage.');
   $frm->setFormTagAttribute('class', 'web_form form_horizontal');
   $frm->setFormTagAttribute( 'onSubmit', 'uploadZip(); return false;' );
   $frm->developerTags['colClassPrefix'] = 'col-md-';
   $frm->developerTags['fld_default_col'] = 12;
?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                  <div class="row">
                     <div class="col--first col-lg-6">
                        <span class="page__icon"><i class="ion-android-star"></i></span>
                        <h5><?php echo Labels::getLabel('LBL_Upload_Bulk_Images',$adminLangId); ?> </h5>
                        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                     </div>
                  </div>
                </div>
                <!--<div class="col-sm-12">-->
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo Labels::getLabel('LBL_Upload_Bulk_Images',$adminLangId); ?></h4>
                    </div>
                    <div class="sectionbody">
                        <div class="container">
                            <div class="row" >
                                <div class="col-md-8" >
                                    <?php echo $frm->getFormHtml(); ?>
                                    <div class="warning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
