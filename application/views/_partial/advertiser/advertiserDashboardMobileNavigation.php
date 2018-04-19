<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>
<ul class="list--vertical hide--desktop">
	<li class="<?php echo ($controller == 'advertiser' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('advertiser'); ?>"><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Promotions',$siteLangId);?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'account' && ($action == 'promote')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('advertiser','promotions'); ?>"><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"></i><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
		</ul>
	</li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
		</ul>
	</li>
	<li class="<?php echo ($controller == 'GuestUser' && $action == 'Logout') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('GuestUser','Logout');?>"><?php echo Labels::getLabel('LBL_Logout',$siteLangId);?></a></li>
</ul>