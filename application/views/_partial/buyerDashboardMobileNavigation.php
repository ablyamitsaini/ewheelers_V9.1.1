<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>

<ul class="list--vertical hide--desktop">
  <li class="<?php echo ($controller == 'buyer' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('buyer'); ?>"><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
  <li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Orders',$siteLangId);?></span>
    <ul class="childs">
      <li class="<?php echo ($controller == 'buyer' && ($action == 'orders' || $action == 'vieworder')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','Orders'); ?>"><?php echo Labels::getLabel("LBL_My_Orders",$siteLangId); ?></a></li>
	  <li class="<?php echo ($controller == 'buyer' && ($action == 'mydownload')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','MyDownloads'); ?>"><?php echo Labels::getLabel("LBL_My_Downloads",$siteLangId); ?></a></li>
      <li class="<?php echo ($controller == 'buyer' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderCancellationRequests'); ?>"><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></a></li>
      <li class="<?php echo ($controller == 'buyer' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','orderReturnRequests'); ?>"><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></a></li>
    </ul>
  </li>
  <li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Addresses',$siteLangId);?></span>
  <ul class="childs">
	<li class="<?php echo ($controller == 'account' && $action == 'myaddresses') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','myAddresses'); ?>"><?php echo Labels::getLabel("LBL_My_Addresses",$siteLangId); ?></a></li>
	
 	 </ul>
  </li>
  <li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Rewards',$siteLangId);?></span>
    <ul class="childs">
      <li class="<?php echo ($controller == 'buyer' && $action == 'rewardpoints') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','rewardPoints'); ?>"><?php echo Labels::getLabel("LBL_Reward_Points",$siteLangId); ?></a></li>
      <li class="<?php echo ($controller == 'buyer' && $action == 'shareearn') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','shareEarn'); ?>"><?php echo Labels::getLabel("LBL_Share_and_Earn",$siteLangId); ?></a></li>
      <li class="<?php echo ($controller == 'buyer' && $action == 'offers') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Buyer','offers'); ?>"><?php echo Labels::getLabel("LBL_My_Offers",$siteLangId); ?></a></li>
    </ul>
  </li>
  <li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></span>
    <ul class="childs">
      <li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
      <li class="<?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?>
        <?php if($todayUnreadMessageCount > 0) { ?>
        <span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span>
        <?php } ?>
        </a></li>
      <li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
      <li class="<?php echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><?php echo Labels::getLabel('LBL_Wishlist/Favorites',$siteLangId);?></a></li>
	  <li class="<?php echo ($controller == 'account' && $action == 'savedsearches') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','savedSearches');?>"><?php echo Labels::getLabel('LBL_Saved_Searches',$siteLangId);?></a></li>
      <li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
      <li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
    </ul>
  </li>
  <li class="<?php echo ($controller == 'GuestUser' && $action == 'Logout') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('GuestUser','Logout');?>"><?php echo Labels::getLabel('LBL_Logout',$siteLangId);?></a></li>
</ul>
