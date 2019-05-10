<div class="cards-header p-3">
    <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Product_Setup', $siteLangId); ?></h5>
</div>
<div class="cards-content p-3">
    <div class="tabs tabs--small   tabs--scroll clearfix">
        <?php require_once('sellerCatalogProductTop.php');?>
    </div>
    <div class="tabs__content form">
        <div class="form__content">
            <div class="col-md-12">
                <?php require_once('sellerProductSeoTop.php');?>
                <div class="form__subcontent">
                    <?php
                        $productSeoLangForm->setFormTagAttribute('class', 'form form--horizontal layout--'.$formLayout);
                        $productSeoLangForm->setFormTagAttribute('onsubmit', 'setupProductLangMetaTag(this); return(false);');
                        $productSeoLangForm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-';
                        $productSeoLangForm->developerTags['fld_default_col'] = 6;
                        echo $productSeoLangForm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
