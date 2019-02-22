<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<?php if( !$isUserLogged ){ ?>
	<li> <a href="javascript:void(0)" class="sign-in sign-in-popup-js"><i class="icn icn--login"><svg class="svg">
		<use xlink:href="images/retina/sprite.svg#login" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
	</svg></i> <span>
	<strong><?php echo Labels::getLabel('LBL_Login_/_Sign_Up', $siteLangId); ?></strong></span></a></li>
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
	 <li class="dropdown dropdown--arrow">
		 <?php if(isset($controllerName) && ($controllerName == 'Seller' || $controllerName == 'Buyer' || $controllerName == 'Affiliate' || $controllerName == 'Advertiser')){ ?>
			<a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js">
				<img class="my-account__avatar" src="<?php echo $profilePicUrl;?>" alt="">
			</a>
		<?php }else{?>
			<a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js"><span class="icn icn-txt"><?php echo Labels::getLabel( 'LBL_Hi,', $siteLangId ).' '.$userName; ?></span></a>
		<?php }?>
		  <div class="dropdown__target dropdown__target__right dropdown__target-js">
            <div class="dropdown__target-space">
              <div class="dropdown__target-body">
                <!-- for desktop my account links -->
                <ul class="list-vertical list-vertical--tick hide--mobile hide--tab">
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
						<ul class="list-vertical list-vertical--tick hide--desktop">
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
        </li>
	<?php } ?>
