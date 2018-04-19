<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="col-md-2 hide--mobile hide--tab no-print">
	<div class="box box--white box--space">
	  <h6><?php echo Labels::getLabel('LBL_Advertiser_Dashboard',$siteLangId); ?></h6>
	  <div class="gap"></div>
			<?php if(User::canViewBuyerTab() || User::canViewSupplierTab() || User::canViewAffiliateTab()){?>
		<div class="gap"></div>
		<div class="dashboard-togles dropdown"><span><?php echo Labels::getLabel('LBL_Advertiser',$siteLangId); ?> </span><a href="javascript:void(0)" class="ripplelink fa fa-ellipsis-v dropdown__trigger-js"><span class="ink animate" ></span></a>
                <div class="dropdown__target dropdown__target-js dashboard-options">
                  <ul>
				   <?php if(User::canViewBuyerTab()) { ?>
                    <li><a href="<?php echo CommonHelper::generateUrl('buyer');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Buyer',$siteLangId); ?></a></li>
                   <?php } if(User::canViewSupplierTab()) {  ?>
                    <li><a href="<?php echo CommonHelper::generateUrl('seller');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?></a></li>
				   <?php } if(User::canViewAffiliateTab()) {  ?>
                    <li><a href="<?php echo CommonHelper::generateUrl('affiliate');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Affiliate',$siteLangId); ?></a></li>
				   <?php } ?>
                  </ul>
                </div>
              </div>
		
		
		
		<?php }?>

	<?php if(User::canViewAdvertiserTab()) { ?>
	<div class="box box--list">
		<h6><?php echo Labels::getLabel('LBL_Quick_filters',$siteLangId);?></h6>
		<ul class="links--vertical">
		   <li class="<?php echo ($controller == 'advertiser' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('advertiser'); ?>"><i class="fa fa-home"></i><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
		</ul>
	</div> 
	<div class="box box--list">
	   <h6><?php echo Labels::getLabel("LBL_Promotions",$siteLangId); ?></h6>
	   <ul class="links--vertical">
			<li class="<?php echo ($controller == 'advertiser' && ($action == 'promotions' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('advertiser','promotions'); ?>"><i class="fa fa-file-text-o"></i><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
	   </ul>
	</div>
	<?php } ?>
	<div class="box box--list">
	   <h6><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></h6>
	   <ul class="links--vertical">
		   <li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
		   <li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
		   <li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><i class="fa fa-cog"></i><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
	   </ul>
    </div>
  </div>
</div>
