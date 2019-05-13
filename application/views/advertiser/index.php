<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <div class="content-header justify-content-between row mb-3">
            <div class="content-header-left col-md-auto">
                <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
                <h2 class="content-header-title"><?php echo Labels::getLabel('Lbl_Advertiser', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="content-body">
            <div class="widget-wrapper mb-3">
                <div class="widget widget-stats">
                    <a href="<?php echo CommonHelper::generateUrl('account', 'credits');?>">
                        <div class="cards">
                            <div class="cards-header">
                                <h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Credits', $siteLangId);?></h5>
                            </div>
                            <div class="cards-content p-3">
                                <div class="stats">
                                    <i class="icn">
                                        <svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#credits" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#Credits"></use>
                                        </svg>
                                    </i>
                                    <div class="stats-number">
                                        <h6 class="total"><?php echo Labels::getLabel('LBL_Total', $siteLangId);?></h6>
                                        <?php echo CommonHelper::displayMoneyFormat($walletBalance);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="widget widget-stats">
                    <a href="javascript:void(0)" onClick="redirectToPromotions('<?php echo CommonHelper::generateUrl('advertiser', 'promotions');?>')">
                        <div class="cards">
                            <div class="cards-header">
                                <h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Active_Promotions', $siteLangId);?></h5>
                            </div>
                            <div class="cards-content p-3">
                                <div class="stats">
                                    <i class="icn">
                                        <svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#speaker" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#speaker"></use>
                                        </svg>
                                    </i>
                                    <div class="stats-number">
                                        <h6 class="total"><?php echo Labels::getLabel('LBL_Total_Active_promotions', $siteLangId);?> </h6>
                                        <?php  echo $totActivePromotions; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="widget widget-stats">
                    <a href="<?php echo CommonHelper::generateUrl('advertiser', 'promotionCharges');?>">
                        <div class="cards">
                            <div class="cards-header">
                                <h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Amount_Spent_on_Promotions', $siteLangId);?></h5>
                            </div>
                            <div class="cards-content p-3">
                                <div class="stats">
                                    <i class="icn">
                                        <svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#give-money" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#give-money"></use>
                                        </svg>
                                    </i>
                                    <div class="stats-number">
                                        <h6 class="total"><?php echo Labels::getLabel('LBL_Total_Charged_Amount', $siteLangId);?></h6>
                                        <?php echo CommonHelper::displayMoneyFormat($totChargedAmount);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12 col-md-12">
                    <div class="cards">
                        <div class="cards-header p-3">
                            <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Active_Promotions', $siteLangId);?></h5>
                            <?php if (count($activePromotions)>0) { ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('advertiser', 'promotions');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All', $siteLangId);?></a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="cards-content p-3">
                            <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                                <tbody>
                                    <tr class="">
                                        <th colspan="2"><?php echo Labels::getLabel('LBL_Promotions', $siteLangId);?></th>
                                        <th ><?php echo Labels::getLabel('LBL_Type', $siteLangId);?></th>
                                        <th ><?php echo Labels::getLabel('LBL_CPC', $siteLangId);?></th>
                                        <th ><?php echo Labels::getLabel('LBL_Budget', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Clicks', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Duration', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Approved', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Action', $siteLangId);?></th>
                                    </tr>
                                    <?php if (count($activePromotions) > 0) {
                                        $arrYesNo = applicationConstants::getYesNoArr($siteLangId);
                                        foreach ($activePromotions as $promotionId => $row) {
                                            $duraionStr = Labels::getLabel('LBL_Start_Date', $siteLangId).' : '.FatDate::format($row[    'promotion_start_date']).'<br>';
                                            $duraionStr.= Labels::getLabel('LBL_End_Date', $siteLangId).' : '.FatDate::format($row['promotion_end_date']); ?>
                                    <tr>
                                        <td  colspan="2">
                                            <?php echo $row['promotion_name']; ?>
                                        </td>
                                        <td><?php echo $typeArr[$row['promotion_type']]; ?>
                                        </td>
                                        <td>
                                            <?php echo CommonHelper::displayMoneyFormat($row['promotion_cpc']); ?>
                                        </td>
                                        <td>
                                            <?php echo CommonHelper::displayMoneyFormat($row['promotion_budget']) ; ?>
                                        </td>
                                        <td>
                                            <?php echo FatUtility::int($row['clicks']); ?>
                                        </td>
                                        <td>
                                            <?php   echo $duraionStr; ?>
                                        </td>
                                        <td>
                                            <?php echo $arrYesNo[$row['promotion_approved']]; ?>
                                        </td>
                                        <td>
                                            <ul class="actions">
                                                <li><a  title="<?php echo Labels::getLabel('LBL_Analytics', $siteLangId); ?>"   href="<?php echo CommonHelper::generateUrl('advertiser', 'analytics', array($row['promotion_id'])); ?>"><i class="fa fa-file-text-o"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                            <?php
                                        }
                                    } else { ?>
                                    <tr>
                                        <td colspan="8">
                                            <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId), false); ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                    <span class="scroll-hint-icon">
                                        <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable', $siteLangId);?></div>
                                    </span>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12 col-md-12">
                    <div class="cards">
                        <div class="cards-header p-3">
                            <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Transaction_History', $siteLangId);?></h5>
                            <?php if (count($transactions) > 0) { ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('Account', 'credits');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All', $siteLangId);?></a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="cards-content p-3">
                            <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                                <tbody>
                                    <tr class="">
                                        <th><?php echo Labels::getLabel('LBL_Txn._Id', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Date', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Credit', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Debit', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Balance', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Comments', $siteLangId);?></th>
                                        <th><?php echo Labels::getLabel('LBL_Status', $siteLangId);?></th>
                                    </tr>
                                    <?php if (count($transactions) > 0) {
                                        foreach ($transactions as $row) { ?>
                                    <tr>
                                        <td>
                                            <div class="txn__id">
                                                <?php echo Labels::getLabel('Lbl_Txn._Id', $siteLangId)?>: <?php echo Transactions::formatTransactionNumber($row['utxn_id']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__date">
                                                <?php echo FatDate::format($row['utxn_date']);?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__credit">
                                                <?php echo CommonHelper::displayMoneyFormat($row['utxn_credit']);?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__debit">
                                                <?php echo CommonHelper::displayMoneyFormat($row['utxn_debit']);?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__balance">
                                                <?php echo CommonHelper::displayMoneyFormat($row['balance']);?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__comments">
                                                <?php echo $row['utxn_comments'];?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="txn__status">
                                                <?php echo $txnStatusArr[$row['utxn_status']];?>
                                            </div>
                                        </td>
                                    </tr>
                                        <?php }
                                    } else { ?>
                                    <tr>
                                        <td colspan="7">
                                            <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId), false); ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                    <span class="scroll-hint-icon">
                                        <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable', $siteLangId);?></div>
                                    </span>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    redirectToPromotions = function(url) {
        var input = '<input type="hidden" name="active_promotion" value="' + 1 + '">';
        $('<form action="' + url + '" method="POST">' + input + '</form>').appendTo($(document.body)).submit();
    };
</script>
