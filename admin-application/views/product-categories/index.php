<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo Labels::getLabel('LBL_Manage_Product_Categories', $adminLangId); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <!--<div class="col-sm-12">-->
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo Labels::getLabel('LBL_Category_List', $adminLangId); ?></h4>
                        <?php
                            $ul = new HtmlElement("ul", array("class"=>"actions actions--centered"));
                            $li = $ul->appendElement("li", array('class'=>'droplink'));
                            $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                            $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                            $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));
                            //$innerLi=$innerUl->appendElement('li');

                            if (FatApp::getConfig('CONF_ENABLE_IMPORT_EXPORT', FatUtility::VAR_INT, 0) && $canView) {
                                $innerLiExport=$innerUl->appendElement('li');
                                $innerLiExport->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Export', $adminLangId),"onclick"=>"addExportForm(".Importexport::TYPE_CATEGORIES.")"), Labels::getLabel('LBL_Export', $adminLangId), true);
                            }
                            if (FatApp::getConfig('CONF_ENABLE_IMPORT_EXPORT', FatUtility::VAR_INT, 0) && $canEdit) {
                                $innerLiImport=$innerUl->appendElement('li');
                                $innerLiImport->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Import', $adminLangId),"onclick"=>"addImportForm(". Importexport::TYPE_CATEGORIES.")"), Labels::getLabel('LBL_Import', $adminLangId), true);
                            }
                            if ($canEdit) {
                                $innerLiAddCat=$innerUl->appendElement('li');
                                $innerLiAddCat->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Add_Category', $adminLangId),"onclick"=>"addCategoryForm(0)"), Labels::getLabel('LBL_Add_Category', $adminLangId), true);

                                $innerLiNewProduct=$innerUl->appendElement('li');
                                $innerLiNewProduct->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Make_Active', $adminLangId),"onclick"=>"toggleBulkStatues(1)"), Labels::getLabel('LBL_Make_Active', $adminLangId), true);

                                $innerLiNewProduct=$innerUl->appendElement('li');
                                $innerLiNewProduct->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Make_InActive', $adminLangId),"onclick"=>"toggleBulkStatues(0)"), Labels::getLabel('LBL_Make_InActive', $adminLangId), true);

                                $innerLiNewProduct=$innerUl->appendElement('li');
                                $innerLiNewProduct->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Delete_selected', $adminLangId),"onclick"=>"deleteSelected()"), Labels::getLabel('LBL_Delete_selected', $adminLangId), true);
                            }
                             echo $ul->getHtml();?>
                    </div>
                    <div class="sectionbody">
                        <div class="tablewrap" >
                            <div id="listing"> <?php echo Labels::getLabel('LBL_Processing...', $adminLangId); ?></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php echo FatUtility::createHiddenFormFromData(array('prodcat_parent'=>$prodcat_parent), array('name' => 'frmSearch'));?>
