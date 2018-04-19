<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="col-md-2 hide--mobile hide--tab no-print">
	<div class="box box--white box--space">
		<?php if(User::canViewSupplierTab() && User::canViewBuyerTab()) { ?>
			<h6><?php echo Labels::getLabel('LBL_Buyer_Dashboard',$siteLangId); ?></h6>
			<div class="gap"></div>
			<div class="switch-links">
			<a href="<?php echo CommonHelper::generateUrl('seller');?>"><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?></a>
			<div class="switch-button buyer is--active"></div>
			<a href="<?php echo CommonHelper::generateUrl('buyer'); ?>" class="is--active"><?php echo Labels::getLabel('LBL_Buyer',$siteLangId); ?></a> 
			</div>
		<?php } elseif( User::canViewSupplierTab() ){ /*?>
			<h6><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId); ?></h6>
			<div class="gap"></div>
			<div class="switch-links ">
			<a href="<?php echo CommonHelper::generateUrl('seller');?>"><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?></a>
			</div>
			<?php
		*/ } ?>
		
		<?php if( User::canViewAffiliateTab() ) { ?>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel('LBL_Quick_filters',$siteLangId);?></h6>
				<ul class="links--vertical">
				<li class="<?php echo ($controller == 'affiliate' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Affiliate'); ?>"><i class="fa fa-home"></i><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
				</ul>
			</div>
			<?php if(FatApp::getConfig('CONF_FACEBOOK_APP_ID',FatUtility::VAR_STRING,'') && FatApp::getConfig('CONF_FACEBOOK_APP_SECRET',FatUtility::VAR_STRING,'')) { ?>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel("LBL_Sharing",$siteLangId); ?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'affiliate' && $action == 'sharing') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Affiliate','sharing'); ?>"><i class="fa fa-share-alt"></i><?php echo Labels::getLabel("LBL_Sharing",$siteLangId); ?></a></li>
				</ul>
			</div>
			<?php }?>
		<?php } ?>
		
		<?php if( User::canViewBuyerTab() ) { ?>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel('LBL_Quick_filters',$siteLangId);?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'buyer' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('buyer'); ?>"><i class="fa fa-home"></i><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
				</ul>
			</div> 
			<div class="box box--list">
				<h6><?php echo Labels::getLabel("LBL_Orders",$siteLangId); ?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'buyer' && ($action == 'orders' || $action == 'vieworder')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','Orders'); ?>"><i class="fa fa-file-text-o"></i><?php echo Labels::getLabel("LBL_My_Orders",$siteLangId); ?></a></li>
					<li class="<?php echo ($controller == 'buyer' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderCancellationRequests'); ?>"><i class="fa fa-file-text-o"></i><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></a></li>
					<li class="<?php echo ($controller == 'buyer' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderReturnRequests'); ?>"><i class="fa fa-file-text-o"></i><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></a></li>
				</ul>
			</div>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel("LBL_Addresses",$siteLangId); ?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'buyer' && $action == 'myaddresses') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','myAddresses'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Addresses",$siteLangId); ?></a></li>
				</ul>
			</div>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel("LBL_Rewards",$siteLangId); ?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'buyer' && $action == 'rewardPoints') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','rewardPoints'); ?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel("LBL_Reward_Points",$siteLangId); ?></a></li>
					<?php if(FatApp::getConfig('CONF_ENABLE_REFERRER_MODULE')){?>
					<li class="<?php echo ($controller == 'buyer' && $action == 'shareEarn') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','shareEarn'); ?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel("LBL_Share_and_Earn",$siteLangId); ?></a></li>			
					<?php }?>
					<li class="<?php echo ($controller == 'buyer' && $action == 'offers') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','offers'); ?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel("LBL_My_Offers",$siteLangId); ?></a></li>			
				</ul>
			</div>
		<?php } ?>
		
		<div class="box box--list">
			<h6><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></h6>
			<ul class="links--vertical">
				<li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
				
				<?php if( !User::canViewAffiliateTab() ) { ?>
				<li class="<?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><i class="fa fa-envelope"></i><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?></a></li>		    
				<?php } ?>
				
				<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
				
				<?php if( !User::canViewAffiliateTab() ) { ?>
				<li class="<?php echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><i class="fa fa-heart"></i><?php echo Labels::getLabel('LBL_Wishlist/Favorites',$siteLangId);?></a></li>
				<?php } ?>
				
				<li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
			</ul>
		</div>
	</div>
</div>