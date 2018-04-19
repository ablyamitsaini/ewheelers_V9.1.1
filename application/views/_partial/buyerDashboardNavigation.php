<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="col-md-2 hide--mobile hide--tab no-print">
	<div class="box box--white box--space">
		<?php if(User::canViewSupplierTab() || User::canViewAdvertiserTab() || USer::canViewAffiliateTab()) { ?>
			<h6><?php echo Labels::getLabel('LBL_Buyer_Dashboard',$siteLangId); ?></h6>
			<div class="gap"></div>
			<div class="dashboard-togles dropdown"><span><?php echo Labels::getLabel('LBL_Buyer',$siteLangId); ?> </span><a href="javascript:void(0)" class="ripplelink fa fa-ellipsis-v dropdown__trigger-js"><span class="ink animate" ></span></a>
                <div class="dropdown__target dropdown__target-js dashboard-options">
                  <ul>
				  <?php if(User::canViewSupplierTab()){?>
                    <li><a href="<?php echo CommonHelper::generateUrl('seller');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?></a></li>
				  <?php } if(User::canViewAdvertiserTab()) { ?>
                    <li><a href="<?php echo CommonHelper::generateUrl('advertiser');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Advertiser',$siteLangId); ?></a></li>
				  <?php } if(User::canViewAffiliateTab()) {  ?>
                    <li><a href="<?php echo CommonHelper::generateUrl('affiliate');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Affiliate',$siteLangId); ?></a></li>
				   <?php } ?>
                  </ul>
                </div>
              </div>
			
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
			<li class="<?php echo ($controller == 'buyer' && ($action == 'orders' || $action == 'vieworder')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','Orders'); ?>"><i class="fa fa-first-order"></i><?php echo Labels::getLabel("LBL_My_Orders",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'buyer' && ($action == 'mydownloads')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','MyDownloads'); ?>"><i class="fa fa-first-order"></i><?php echo Labels::getLabel("LBL_My_Downloads",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'buyer' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderCancellationRequests'); ?>"><i class="fa  fa-file-text"></i><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'buyer' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderReturnRequests'); ?>"><i class="fa fa-reply"></i><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></a></li>
			</ul>
			</div>
			<div class="box box--list">
			<h6><?php echo Labels::getLabel("LBL_Addresses",$siteLangId); ?></h6>
			<ul class="links--vertical">
			<li class="<?php echo ($controller == 'account' && $action == 'myaddresses') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','myAddresses'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Addresses",$siteLangId); ?></a></li>				
			</ul>
			</div>
			<div class="box box--list">
			<h6><?php echo Labels::getLabel("LBL_Rewards",$siteLangId); ?></h6>
			<ul class="links--vertical">
			<li class="<?php echo ($controller == 'buyer' && $action == 'rewardpoints') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','rewardPoints'); ?>"><i class="fa fa-trophy"></i><?php echo Labels::getLabel("LBL_Reward_Points",$siteLangId); ?></a></li>
			<?php if(FatApp::getConfig('CONF_ENABLE_REFERRER_MODULE')){?>
			<li class="<?php echo ($controller == 'buyer' && $action == 'shareearn') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','shareEarn'); ?>"><i class="fa fa-share-alt"></i><?php echo Labels::getLabel("LBL_Share_and_Earn",$siteLangId); ?></a></li>			
			<?php }?>
			<li class="<?php echo ($controller == 'buyer' && $action == 'offers') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','offers'); ?>"><i class="fa fa-tags"></i><?php echo Labels::getLabel("LBL_My_Offers",$siteLangId); ?></a></li>
			</ul>
			</div>
		<?php } ?>
		<div class="box box--list">
			<h6><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></h6>
			<ul class="links--vertical">
				<li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><i class="fa fa-envelope"></i><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?> <?php if($todayUnreadMessageCount > 0) { ?><span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span> <?php } ?></a></li>		    
				<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><i class="fa fa-credit-card-alt"></i><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><i class="fa fa-heart"></i><?php echo Labels::getLabel('LBL_Wishlist/Favorites',$siteLangId);?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><i class="fa  fa-unlock-alt"></i><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><i class="fa fa-envelope"></i><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
			</ul>
		</div>
	</div>
</div>