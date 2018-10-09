<div id="body" class="body bg--gray">
	<section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head"><h2><?php echo Labels::getLabel('Lbl_Advertiser' , $siteLangId); ?></h2></div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head">
								<h4><?php echo Labels::getLabel('LBL_Latest_Promotions',$siteLangId);?></h4>
								<?php if( $promotionCount > 5 ){?>
								<a href="<?php echo CommonHelper::generateUrl('advertiser','promotions');?>" class="link--arrow"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
								<?php }?>
								</div>
								<div class="box__body">
								<div class="grids--container">
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
								</div>
								<?php 	 if(count($promotionList)>0){ ?>
								<div id="ppcListing">
								<table class="table table--orders">
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
								<span class="caption--td"><?php echo Labels::getLabel('LBL_Promotion',$siteLangId);?></span><?php echo $row['promotion_name'];?>
								</td>
								<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Type',$siteLangId);?></span><?php echo $typeArr[$row['promotion_type']];?>
								</td>
								<td><span class="caption--td"><?php echo Labels::getLabel('LBL_CPC',$siteLangId);?></span>
								<?php echo CommonHelper::displayMoneyFormat($row['promotion_cpc']);?>
								</td>
								<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Budget',$siteLangId);?></span>
								<?php echo CommonHelper::displayMoneyFormat($row['promotion_budget']) ;?>
								</td> 
								<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Clicks',$siteLangId);?></span>
								<?php echo FatUtility::int($row['clicks']);?>
								</td> <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Duration',$siteLangId);?></span>
								<?php   echo $duraionStr;?>
								</td> <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Approved',$siteLangId);?></span>
								<?php echo $arrYesNo[$row['promotion_approved']];?>
								</td> <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></span>
								<ul class="actions"><li><a  title="<?php echo Labels::getLabel('LBL_Analytics',$siteLangId);?>"   href="<?php echo CommonHelper::generateUrl('advertiser','analytics', array($row['promotion_id']));?>"><i class="fa fa-file-text-o"></i></a></li></ul>
								</td>
								</tr>
								<?php } ?>
								</table>
								</div>
								<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>