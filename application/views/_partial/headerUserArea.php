<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<?php if( !$isUserLogged ){ ?>
      <div class="login-account">
	  <a href="javascript:void(0)" class="sign-in"><span class="icn-txt"><?php echo Labels::getLabel('LBL_Sign_In', $siteLangId); ?></span> <span class="icn"> </span></a> </div>

	 <?php
	// $this->includeTemplate('guest-user/loginFormTemplate.php');
	 } else {
		$userActiveTab = false;
		if( User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S' )){ $userActiveTab = true;
		$dashboardUrl = CommonHelper::generateUrl('Seller');
		}else if( User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B' )) { $userActiveTab = true;
		$dashboardUrl = CommonHelper::generateUrl('Buyer');
		}else if( User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='Ad' ) ) { $userActiveTab = true;
		$dashboardUrl = CommonHelper::generateUrl('Advertiser');
		} else if( User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='AFFILIATE' )){ $userActiveTab = true;
		$dashboardUrl = CommonHelper::generateUrl('Affiliate');
		} if(!$userActiveTab){
		$dashboardUrl = CommonHelper::generateUrl('Account');
		}
	 ?>
	 <div class="login-account dropdown"> <a href="#" class="dropdown__trigger dropdown__trigger-js"><span class="icn-txt"><?php echo Labels::getLabel( 'LBL_Hi,', $siteLangId ).' '.$userName; ?></span> <span class="icn"> </span></a>
          <div class="dropdown__target dropdown__target-account dropdown__target-js">
            <div class="box">
              <div class="dropdown__target-head align--center"> <span class="iconavtar"><i class="icon fa fa-user"></i></span>
				<a class="link" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a>
                <p><?php echo $userEmail;?></p>
              </div>
              <div class="dropdown__target-body">
                <!-- for desktop my account links -->
                <ul class="list--vertical hide--mobile hide--tab">
					<?php
						$userActiveTab = false;
						if( User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S' )){ $userActiveTab = true;?>
						<li><a href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
						<li><a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></a></li>
						<?php } else if( User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B' )) { $userActiveTab = true;?>
						<li><a href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
						<li><a href="<?php echo CommonHelper::generateUrl('Buyer','Orders'); ?>"><?php echo Labels::getLabel("LBL_My_Orders",$siteLangId); ?></a></li>
						<?php }else if( User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='Ad' ) ) { $userActiveTab = true;?>
						<li><a href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
						<li><a href="<?php echo CommonHelper::generateUrl('advertiser','promotions'); ?>"><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></a></li>
						<?php } else if( User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='AFFILIATE' )){ $userActiveTab = true;?>
						<li><a href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
						<?php } if(!$userActiveTab){?>
						<li><a href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
						<?php }else{?>
						<li><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
						<?php }?>
						<?php if( (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B' )) || (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S' )) ){ ?>
						<li><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><?php echo Labels::getLabel("LBL_My_Messages",$siteLangId); ?></a></li>
						<?php } ?>
						<li><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><?php echo Labels::getLabel("LBL_My_Credits",$siteLangId); ?></a></li>
						<li><a href="<?php echo CommonHelper::generateUrl('GuestUser','logout');?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?></a></li>
				</ul>
				<?php if( $isUserLogged ){ ?>
					<?php if( User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S' )){ ?>
						<?php $this->includeTemplate('_partial/seller/sellerDashboardMobileNavigation.php'); ?>
					<?php }else if(User::canViewBuyerTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'B' )){?>
						<?php $this->includeTemplate('_partial/buyerDashboardMobileNavigation.php'); ?>
					<?php }else if(User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'Ad' )){?>
						<?php $this->includeTemplate('_partial/advertiser/advertiserDashboardMobileNavigation.php'); ?>
					<?php }else { ?>
						<ul class="list--vertical hide--desktop">
							<?php if( $isUserLogged ){
							$userActiveTab = false;
							if( User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S' )){ $userActiveTab = true;?>
							<li><a href="<?php echo CommonHelper::generateUrl('Seller'); ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
							<li><a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></a></li>
							<?php } else if( User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B' )) { $userActiveTab = true;?>
							<li><a href="<?php echo CommonHelper::generateUrl('Buyer'); ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
							<li><a href="<?php echo CommonHelper::generateUrl('Buyer','Orders'); ?>"><?php echo Labels::getLabel("LBL_My_Orders",$siteLangId); ?></a></li>
							<?php }else if( User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='Ad' ) ) { $userActiveTab = true;?>
							<li><a href="<?php echo CommonHelper::generateUrl('Advertiser'); ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
							<li><a href="<?php echo CommonHelper::generateUrl('advertiser','promotions'); ?>"><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></a></li>
							<?php } else if( User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='AFFILIATE' )){ $userActiveTab = true;?>
							<li><a href="<?php echo CommonHelper::generateUrl('Affiliate'); ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
							<?php if(FatApp::getConfig('CONF_FACEBOOK_APP_ID',FatUtility::VAR_STRING,'') && FatApp::getConfig('CONF_FACEBOOK_APP_SECRET',FatUtility::VAR_STRING,'')) { ?>
							<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel("LBL_Sharing",$siteLangId); ?></span>
								<ul class="childs">
									<li><a href="<?php echo CommonHelper::generateUrl('Affiliate','sharing'); ?>"><?php echo Labels::getLabel("LBL_Sharing",$siteLangId); ?></a></li>
								</ul>
							</li>
							<?php }?>
							<?php }?>
							<?php if(!$userActiveTab){?>
							<li><a href="<?php echo CommonHelper::generateUrl('Account'); ?>"><?php echo Labels::getLabel("LBL_Dashboard",$siteLangId); ?></a></li>
							<?php } ?>
							<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel("LBL_Profile",$siteLangId); ?></span>
								<ul class="childs">
									<?php if($userActiveTab){?>
									<li><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
									<?php }?>
									<li><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><?php echo Labels::getLabel("LBL_My_Credits",$siteLangId); ?></a></li>
									<li><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><?php echo Labels::getLabel("LBL_Change_Email",$siteLangId); ?></a></li>
									<li><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><?php echo Labels::getLabel("LBL_Change_Password",$siteLangId); ?></a></li>
								</ul>
							</li>
							<li><a href="<?php echo CommonHelper::generateUrl('GuestUser','logout');?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?></a></li>
							<?php } ?>
						</ul>
					<?php }?>
				<?php } ?>
              </div>
            </div>
          </div>
        </div>
	<?php } ?>
