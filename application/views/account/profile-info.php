<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?> <main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header  row justify-content-between mb-3">
            <div class="col-md-auto"> <?php $this->includeTemplate('_partial/dashboardTop.php'); ?> <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Profile', $siteLangId);?></h2>
            </div>
            <div class="col-md-auto">
                <div class="actions">
                    <?php if ($showSellerActivateButton) { ?>
                    <a href="<?php echo CommonHelper::generateUrl('Seller'); ?>" class="btn btn--secondary btn--sm panel__head_action"
                        title="<?php echo Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId); ?>">
                        <strong> <?php echo Labels::getLabel('LBL_Activate_Seller_Account', $siteLangId); ?></strong>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="cards">
                <div class="cards-header p-3">
                    <h5 class="cards-title"><?php echo Labels::getLabel('LBL_Account_Information', $siteLangId);?></h5>
                    <div class="btn-group">
                        <a class="btn btn--secondary btn--sm" href="javascript:void(0)" onclick="truncateDataRequestPopup()"><?php echo Labels::getLabel('LBL_Request_to_remove_my_data', $siteLangId); ?></a>
                        <a class="btn btn--primary btn--sm" href="javascript:void(0)" onclick="requestData()"><?php echo Labels::getLabel('LBL_Request_My_Data', $siteLangId); ?></a>
                    </div>
                </div>
                <div class="cards-content p-3">
                    <div class="tabs tabs--small   tabs--scroll clearfix setactive-js">
                        <ul>
                            <li class="is-active"><a href="javascript:void(0);" onClick="profileInfoForm()"><?php echo Labels::getLabel('LBL_My_Account', $siteLangId);?></a></li>
                            <?php if (User::isAffiliate()) { ?>
                                <li>
                                    <a href="javascript:void(0);"
                                    onClick="affiliatePaymentInfoForm()"><?php echo Labels::getLabel('LBL_Payment_Info', $siteLangId); ?></a>
                                </li>
                            <?php }
                            if (!User::isAffiliate()) { ?>
                                <li>
                                    <a href="javascript:void(0);" onClick="bankInfoForm()"><?php echo Labels::getLabel('LBL_Bank_Account', $siteLangId); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div id="profileInfoFrmBlock"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                </div>
            </div>
        </div>
    </div>
</main>
