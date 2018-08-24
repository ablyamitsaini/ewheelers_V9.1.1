<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> 						   
				<div class="col-md-10 panel__right--full">
					<div class="cols--group">
					   <div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></h2>
						  
						  <?php  if( $showSellerActivateButton ){ ?>
                           	<a href="<?php echo CommonHelper::generateUrl('Seller');?>" class="btn btn--secondary btn--sm panel__head_action" title="<?php echo Labels::getLabel('LBL_Activate_Seller_Account',$siteLangId); ?>" ><strong> <?php echo Labels::getLabel('LBL_Activate_Seller_Account',$siteLangId); ?></strong> </a>
						  <?php  } ?>
						 
					   </div>
					   <div class="panel__body">
						 <div class="box box--white box--space">
						   <div class="box__head">
							   <h4><?php echo Labels::getLabel('LBL_Account_Information',$siteLangId);?></h4>
						   </div>
							<div class="box__body">
								<div class="tabs tabs--small tabs--offset tabs--scroll clearfix setactive-js">
									<ul>
										<li class="is-active"><a href="javascript:void(0);" onClick="profileInfoForm()"><?php echo Labels::getLabel('LBL_My_Account',$siteLangId);?></a></li>
										<?php if( User::isAffiliate() ){ ?>
										<li><a href="javascript:void(0);" onClick="affiliatePaymentInfoForm()"><?php echo Labels::getLabel('LBL_Payment_Info',$siteLangId);?></a></li>
										<?php } ?>
										<?php if( !User::isAffiliate() ){ ?>
										<li><a href="javascript:void(0);" onClick="bankInfoForm()"><?php echo Labels::getLabel('LBL_Bank_Account',$siteLangId);?></a></li>
										<?php } ?>
									</ul>
								</div>
								<div class="grids--profile">
								 <div class="grid__right">
								 <?php if( User::canViewBuyerTab() && User::canViewSupplierTab() ){ ?>
									<label class="field_label"><strong><?php echo Labels::getLabel('LBL_Preferred_Dashboard',$siteLangId);?> </strong></label>
									<?php } ?>
									 <ul class="switch setactive-js">										
										<?php if( User::canViewBuyerTab() && ( User::canViewSupplierTab() || User::canViewAdvertiserTab() || User::canViewAffiliateTab() ) ){ ?>
										<li <?php echo (User::USER_BUYER_DASHBOARD == $userPreferredDashboard)?'class="is-active"':''?>><a href="javascript:void(0)" onClick="setPreferredDashboad(<?php echo User::USER_BUYER_DASHBOARD ;?>)"><?php echo Labels::getLabel('LBL_Buyer',$siteLangId);?></a></li>
										<?php } ?>
										<?php if( User::canViewSupplierTab() && ( User::canViewBuyerTab() || User::canViewAdvertiserTab() || User::canViewAffiliateTab() ) ){ ?>
										<li <?php echo (User::USER_SELLER_DASHBOARD == $userPreferredDashboard)?'class="is-active"':''?>><a href="javascript:void(0)" onClick="setPreferredDashboad(<?php echo User::USER_SELLER_DASHBOARD ;?>)"><?php echo Labels::getLabel('LBL_Seller',$siteLangId);?></a></li><?php }?>
									 </ul>
									 <div class="gap"></div>
									 <div class="gap"></div>
									 <a class="btn btn--block btn--secondary btn--sm" href="javascript:void(0)" onclick="truncateDataRequestPopup()"><?php echo Labels::getLabel('LBL_Request_to_remove_my_data',$siteLangId); ?></a>
									 <a class="btn btn--block btn--primary btn--sm" href="javascript:void(0)" onclick="requestData()"><?php echo Labels::getLabel('LBL_Request_My_Data',$siteLangId); ?></a>
								 </div>
								 <div class="grid__left" id="profileInfoFrmBlock">
									<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>										 
								 </div>
								</div>   
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
