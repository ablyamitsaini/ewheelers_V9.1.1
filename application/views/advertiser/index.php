<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('Lbl_Advertiser' , $siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
        <div class="widget-wrapper mb-3">
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('account','credits');?>">
                    <div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Credits',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#credits" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#Credits"></use>
    								</svg></i>
    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
    								<?php echo CommonHelper::displayMoneyFormat($walletBalance);?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('advertiser','promotions');?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Active_Promotions',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#speaker" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#speaker"></use>
    								</svg></i>

    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Total_Active_promotions',$siteLangId);?> </h6>
    								<?php  echo $totActivePromotions; ?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('account','credits');?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Amount_Spent_on_Promotions',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#give-money" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#give-money"></use>
    								</svg></i>

    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Total_Charged_Amount',$siteLangId);?></h6>
                                    <?php echo CommonHelper::displayMoneyFormat($totChargedAmount);?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="cards">
					<div class="cards-header p-3">
						<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Latest_Promotions',$siteLangId);?></h5>
						<div class="action">
							<?php if( $promotionCount > 5 ){?>
							<a href="<?php echo CommonHelper::generateUrl('advertiser','promotions');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
							<?php }?>
						</div>
					</div>

					<div class="cards-content p-3">
  						<div class="row">
  							<div class="col-md-6">
  								<h3><?php echo Labels::getLabel('LBL_Current_Balance',$siteLangId);?>: <strong><?php echo CommonHelper::displayMoneyFormat($walletBalance);?></strong> </h3>
  								<p class="note"><?php echo Labels::getLabel('MSG_Minimum_balance_Required_For_Promotions',$siteLangId).' : '. CommonHelper::displaymoneyformat(FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE'));?></p>
  							</div>
  							<div class="col-md-6">
  								<?php
  								$frmRechargeWallet->setFormTagAttribute('onSubmit','setUpWalletRecharge(this); return false;');
  								$frmRechargeWallet->setFormTagAttribute('class', 'form');
  								$frmRechargeWallet->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
  								$frmRechargeWallet->developerTags['fld_default_col'] = 6;
  								$frmRechargeWallet->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_WITH_NONE);

  								$btnFld = $frmRechargeWallet->getField('btn_submit');
  								$btnFld->setFieldTagAttribute('class','btn--block');
  								$amountFld = $frmRechargeWallet->getField('amount');
  								$amountFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Enter_amount_to_be_Added', $siteLangId));
  								echo $frmRechargeWallet->getFormHtml(); ?>
  							</div>
  						</div>

						<?php if(count($promotionList)>0){ ?>
						<table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
							<tbody>
								<tr class="">
								<th colspan="2"><?php echo Labels::getLabel('LBL_Promotions',$siteLangId);?></th>
								<th ><?php echo Labels::getLabel('LBL_Type',$siteLangId);?></th>
								<th ><?php echo Labels::getLabel('LBL_CPC',$siteLangId);?></th>
								<th ><?php echo Labels::getLabel('LBL_Budget',$siteLangId);?></th>
								<th><?php echo Labels::getLabel('LBL_Clicks',$siteLangId);?></th>
								<th><?php echo Labels::getLabel('LBL_Duration',$siteLangId);?></th>
								<th><?php echo Labels::getLabel('LBL_Approved',$siteLangId);?></th>
								<th><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></th>
								</tr>
								<?php
									$arrYesNo = applicationConstants::getYesNoArr($siteLangId);
									foreach($promotionList as $promotionId=>$row){
									$duraionStr = Labels::getLabel('LBL_Start_Date', $siteLangId).' : '.FatDate::format($row[	'promotion_start_date']).'<br>';
									$duraionStr.= Labels::getLabel('LBL_End_Date', $siteLangId).' : '.FatDate::format($row['promotion_end_date']);
								?>
								<tr>
								<td  colspan="2">
								<?php echo $row['promotion_name'];?>
								</td>
								<td><?php echo $typeArr[$row['promotion_type']];?>
								</td>
								<td>
								<?php echo CommonHelper::displayMoneyFormat($row['promotion_cpc']);?>
								</td>
								<td>
								<?php echo CommonHelper::displayMoneyFormat($row['promotion_budget']) ;?>
								</td>
								<td>
								<?php echo FatUtility::int($row['clicks']);?>
								</td> <td>
								<?php   echo $duraionStr;?>
								</td> <td>
								<?php echo $arrYesNo[$row['promotion_approved']];?>
								</td> <td>
								<ul class="actions"><li><a  title="<?php echo Labels::getLabel('LBL_Analytics',$siteLangId);?>"   href="<?php echo CommonHelper::generateUrl('advertiser','analytics', array($row['promotion_id']));?>"><i class="fa fa-file-text-o"></i></a></li></ul>
								</td>
								</tr>
								<?php } ?>
							</tbody>
							<div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
								<span class="scroll-hint-icon">
								  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
								</span>
							</div>
						</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>
</main>
