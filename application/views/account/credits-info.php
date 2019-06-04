<!-- wallet balance[ -->
<?php
$showTotalBalanceAvailableDiv = false;
$divCol = 12;
if ($userTotalWalletBalance != $userWalletBalance || ($promotionWalletToBeCharged) || ($withdrawlRequestAmount)) {
    $showTotalBalanceAvailableDiv = true;
    $divCol = 4;
} ?>
<div class="row">
    <?php if ($showTotalBalanceAvailableDiv) { ?>
        <div class="col-lg-8 col-md-8 mb-3 mb-md-0 mt-4">
            <div class="balancebox">
                <div class="pl-4 pr-4 ">
                    <div class="credits-number">
                        <ul>
                            <?php if ($userTotalWalletBalance != $userWalletBalance) { ?>
                            <li>
                                <span class="total"><?php echo Labels::getLabel('LBL_Wallet_Balance', $siteLangId); ?>: </span>
                                <span class="total-numbers"><strong><?php echo CommonHelper::displayMoneyFormat($userTotalWalletBalance); ?></strong></span>
                                <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                                    \
                                    <small>
                                        <?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?>
                                        <?php echo CommonHelper::displayMoneyFormat($userTotalWalletBalance, true, true); ?>
                                    </small>
                                <?php } ?>
                            </li>
                            <?php } ?>
                            <?php if ($promotionWalletToBeCharged) { ?>
                            <li>
                                <span class="total"><?php echo Labels::getLabel('LBL_Pending_Promotions_Charges', $siteLangId); ?>:</span>
                                <span class="total-numbers"> <strong>
                                    <?php echo CommonHelper::displayMoneyFormat($promotionWalletToBeCharged); ?></strong></span>
                                    <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                                        <small>
                                            <?php echo Labels::getLabel('LBL_Approx.', $siteLangId);
                                            echo CommonHelper::displayMoneyFormat($promotionWalletToBeCharged, true, true); ?>
                                        </small>
                                    <?php } ?>
                            </li>
                            <?php } ?>
                            <?php if ($withdrawlRequestAmount) { ?>
                            <li>
                                <span class="total"><?php echo Labels::getLabel('LBL_Pending_Withdrawl_Requests', $siteLangId); ?>:</span>
                                <span class="total-numbers"> <strong>
                                <?php echo CommonHelper::displayMoneyFormat($withdrawlRequestAmount); ?></strong></span>
                                <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                                    <small><?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?> <?php echo CommonHelper::displayMoneyFormat($withdrawlRequestAmount, true, true); ?></small>
                                <?php } ?>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-<?php echo $divCol; ?> col-md-<?php echo $divCol; ?> mt-4">
        <div class="balancebox">
            <p><?php echo Labels::getLabel('LBL_Available_Balance', $siteLangId);?>: </p>
            <h2><strong>
                <?php echo CommonHelper::displayMoneyFormat($userWalletBalance);?></strong></h2>
                <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                    <small><?php echo Labels::getLabel('LBL_Approx.', $siteLangId); ?> <?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, true); ?></small>
                <?php } ?>
                <a href="javascript:void(0)" onClick="withdrawalReqForm()" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Request_Withdrawal', $siteLangId); ?></a>
        </div>
    </div>
</div>
