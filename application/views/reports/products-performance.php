<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> <main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto"> <?php $this->includeTemplate('_partial/dashboardTop.php'); ?> <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Products_Performance_Report', $siteLangId);?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="cards-header p-4">
                            <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Products_Performance_Report', $siteLangId);?></h5>
                            <div class="action"> <a href="javascript:void(0)" id="performanceReportExport" onclick="exportProdPerformanceReport('DESC')" class="btn btn--primary btn--block"><?php echo Labels::getLabel('LBL_Export', $siteLangId);?></a></div>
                        </div>
                        <div class="cards-content pl-4 pr-4 ">
                            <div class="tabs tabs--small   tabs--scroll clearfix setactive-js">
                                <ul>
                                    <li class="is-active"><a href="javascript:void(0);" onClick="topPerformingProducts()"><?php echo Labels::getLabel('LBL_Top_Performing_Products', $siteLangId);?></a></li>
                                    <li><a href="javascript:void(0);" onClick="badPerformingProducts()"><?php echo Labels::getLabel('LBL_Most_Refunded_Products_Report', $siteLangId);?></a></li>
                                    <li><a href="javascript:void(0);" onClick="mostWishListAddedProducts()"><?php echo Labels::getLabel('LBL_Most_WishList_Added_Products', $siteLangId);?></a></li>
                                </ul>
                            </div>
                            <div class="gap"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cards">
                        <div class="col-md-12" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        <div class="gap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
