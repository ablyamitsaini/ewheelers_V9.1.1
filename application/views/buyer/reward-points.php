<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit','searchRewardPoints(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form'); 
$frmSrch->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmSrch->developerTags['fld_default_col'] = 12;
?>  
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> 						   
				<div class="col-md-10 panel__right--full">
				   <div class="cols--group">
					   <div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Reward_Points',$siteLangId);?></h2>	
						   <?php echo $frmSrch->getFormHtml();?>
					   </div>					   
					   <div class="panel__body">                            
							<div class="box box--white box--space">
                               <div class="box__head box__head--large">
									<h4><?php echo Labels::getLabel('LBL_Current_Reward_Points',$siteLangId);?> 
									(<?php echo $totalRewardPoints;?>) - <?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($totalRewardPoints));?></h4>	                                				
									<div class="group--btns">
										<?php /* if($convertReward == 'coupon'){?>
											<a href="javascript:void(0)" class="btn btn--primary btn--sm" onclick="generateCoupon()">Generate Coupon</a>
										<?php }else{ ?>
											<a href="<?php echo CommonHelper::generateUrl('Buyer','RewardPoints',array('coupon'));?>" class="btn btn--primary btn--sm" >Generate Coupon From Reward Points</a>
										<?php } */?>
										
									</div>	
                                </div>
                                <div class="box__body">									
									<span class="gap"></span> 
									<h2><?php echo Labels::getLabel("LBL_Reward_Point_History", $siteLangId); ?></h2>
									<div id="rewardPointsListing"><?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?></div>									                                 
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