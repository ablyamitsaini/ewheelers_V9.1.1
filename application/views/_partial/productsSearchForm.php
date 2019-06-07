<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $keywordFld = $frmProductSearch->getField('keyword');
    $keywordFld->overrideFldType("hidden");
    echo $frmProductSearch->getFormTag();
?>
<section class="section-controls">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6">
                <div class="breadcrumbs">
                    <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
                </div>
                <h5 class="mt-3 mb-0"><?php echo $pageTitle; ?> <?php /* <span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record"><?php echo $page;?> - </span><span
                        id="end_record"><?php echo $pageCount;?></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"><?php echo $recordCount;?></span></span>  <span class="hide_on_no_product -color-light"><span id="total_records"><?php echo $recordCount;?></span> <?php echo Labels::getLabel('LBL_ITEMS_TOTAL', $siteLangId); ?></span>*/ ?> </h5>

            </div>
            <div class="col-xl-6">
                <div id="top-filters" class="page-sort hide_on_no_product">
                    <ul>
                        <li class="list__item">
                           <a href="javascript:void(0)" class="link__filter btn btn--secondary-border d-xl-none btn--filters-control"><i class="icn">
                                <svg class="svg">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter"></use>
                                </svg>
                            </i><span class="txt"><?php echo Labels::getLabel('LBL_Filter', $siteLangId); ?></span></a>
                            <?php if (!(UserAuthentication::isUserLogged()) || (UserAuthentication::isUserLogged() && (User::isBuyer()))) { ?>
                            <a href="javascript:void(0)" onclick="saveProductSearch()" class="btn btn--primary-border btn--filters-control"><i class="icn">
                                <svg class="svg">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#savesearch" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#savesearch"></use>
                                </svg>
                            </i><span class="txt"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></span></a>
							<?php } ?>
                        </li>
                        <li>
                        <?php echo $frmProductSearch->getFieldHtml('sortBy'); ?></li>
                        <li>
                        <?php echo $frmProductSearch->getFieldHtml('pageSize'); ?></li>
                        <li class="d-none d-md-block">
                            <div class="list-grid-toggle switch--link-js">
                                <div class="icon">
                                    <div class="icon-bar"></div>
                                    <div class="icon-bar"></div>
                                    <div class="icon-bar"></div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
    <?php if ((UserAuthentication::isUserLogged() && (User::isBuyer())) || (!UserAuthentication::isUserLogged())) { ?>
    <?php } ?>
        <?php /* <li class="is--active d-none d-xl-block">
            <a href="javascript:void(0)" class="switch--grind switch--link-js grid hide--mobile"><i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#gridview" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#gridview"></use>
                </svg>
            </i><span class="txt"><?php echo Labels::getLabel('LBL_Grid_View', $siteLangId); ?></span></a>
        </li>
        <li class="d-none d-xl-block">
            <a href="javascript:void(0)" class="switch--list switch--link-js list hide--mobile"><i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#listview" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#listview"></use>
                </svg>
            </i><span class="txt"><?php echo Labels::getLabel('LBL_List_View', $siteLangId); ?></span></a>
        </li> */ ?>

    <?php
        echo $frmProductSearch->getFieldHTML('keyword');
        echo $frmProductSearch->getFieldHtml('category');
        echo $frmProductSearch->getFieldHtml('sortOrder');
        echo $frmProductSearch->getFieldHtml('page');
        echo $frmProductSearch->getFieldHtml('shop_id');
        echo $frmProductSearch->getFieldHtml('collection_id');
        echo $frmProductSearch->getFieldHtml('join_price');
        echo $frmProductSearch->getFieldHtml('featured');
        echo $frmProductSearch->getFieldHtml('currency_id');
        echo $frmProductSearch->getFieldHtml('brand_id');
        echo $frmProductSearch->getFieldHtml('top_products');
        echo $frmProductSearch->getExternalJS();
    ?>
    </form>
