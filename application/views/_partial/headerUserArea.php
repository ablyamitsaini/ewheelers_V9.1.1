<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
if (!$isUserLogged) {
    if (UserAuthentication::isGuestUserLogged()) { ?>
        <li class="logout"><a
        data-org-url="<?php echo CommonHelper::generateUrl('GuestUser', 'logout', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('GuestUser', 'logout'); ?>"><?php echo User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name");?> | <?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?></a>
</li> <?php
    } else {
        ?> <li class="dropdown--user"> <a href="javascript:void(0)" class="sign-in sign-in-popup-js"><i class="icn icn--login"><svg class="svg">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#login"></use>
            </svg></i> <span>
            <strong><?php echo Labels::getLabel('LBL_Login_/_Sign_Up', $siteLangId); ?></strong></span></a></li> <?php
    } ?> <?php
    // $this->includeTemplate('guest-user/loginFormTemplate.php');
} else {
    $userActiveTab = false;
    if (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S')) {
        $userActiveTab = true;
        $dashboardUrl = CommonHelper::generateUrl('Seller');
        $dashboardOrgUrl = CommonHelper::generateUrl('Seller', '', array(), '', null, false, $getOrgUrl);
    } elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B')) {
        $userActiveTab = true;
        $dashboardUrl = CommonHelper::generateUrl('Buyer');
        $dashboardOrgUrl = CommonHelper::generateUrl('Buyer', '', array(), '', null, false, $getOrgUrl);
    } elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='Ad')) {
        $userActiveTab = true;
        $dashboardUrl = CommonHelper::generateUrl('Advertiser');
        $dashboardOrgUrl = CommonHelper::generateUrl('Advertiser', '', array(), '', null, false, $getOrgUrl);
    } elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='AFFILIATE')) {
        $userActiveTab = true;
        $dashboardUrl = CommonHelper::generateUrl('Affiliate');
        $dashboardOrgUrl = CommonHelper::generateUrl('Affiliate', '', array(), '', null, false, $getOrgUrl);
    }
    if (!$userActiveTab) {
        $dashboardUrl = CommonHelper::generateUrl('Account');
        $dashboardOrgUrl = CommonHelper::generateUrl('Account', '', array(), '', null, false, $getOrgUrl);
    } ?> <li class="dropdown dropdown--arrow dropdown--user"> <?php if (isset($isUserDashboard) && ($isUserDashboard)) { ?>
        <a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js">
        <img class="my-account__avatar" src="<?php echo $profilePicUrl; ?>" alt="">
    </a> <?php
    } else {
        ?> <a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js"><span class="icn icn-txt"><?php echo Labels::getLabel('LBL_Hi,', $siteLangId).' '.$userName; ?></span></a> <?php
    } ?> <div
        class="dropdown__target dropdown__target__right dropdown__target-js">
        <div class="dropdown__target-space">
            <div class="dropdown__target-body">
                <!-- for desktop my account links -->
                <ul class="list-vertical list-vertical--tick">
                    <?php
                    $userName = User::getAttributesById(UserAuthentication::getLoggedUserId(), "user_name");
                    ?>
                    <li>
                        <a href="<?php echo CommonHelper::generateUrl('account', 'profileInfo'); ?>">
                            <?php echo Labels::getLabel('LBL_Hi,', $siteLangId).' '.$userName; ?>
                        </a>
                    </li>
                    <li><div class="divider"></div></li>
                    <?php
                    $userActiveTab = false;
                    if (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S')) {
                        $userActiveTab = true; ?>
                        <li><a data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li>
                        <li><a data-org-url="<?php echo CommonHelper::generateUrl('Seller', 'sales', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Seller', 'sales'); ?>"><?php echo Labels::getLabel('LBL_My_Sales', $siteLangId); ?></a></li>
                        <?php
                    } elseif (User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B')) {
                        $userActiveTab = true; ?>
                        <li><a data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li>
                        <li><a data-org-url="<?php echo CommonHelper::generateUrl('Buyer', 'Orders', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Buyer', 'Orders'); ?>"><?php echo Labels::getLabel("LBL_My_Orders", $siteLangId); ?>
                        </a></li>
                        <?php
                    } elseif (User::canViewAdvertiserTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='Ad')) {
                        $userActiveTab = true; ?>
                        <li><a data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li>
                        <li><a data-org-url="<?php echo CommonHelper::generateUrl('Advertiser', 'promotions', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('advertiser', 'promotions'); ?>"><?php echo Labels::getLabel("LBL_My_Promotions", $siteLangId); ?></a></li>
                                    <?php
                    } elseif (User::canViewAffiliateTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='AFFILIATE')) {
                        $userActiveTab = true; ?>
                        <li><a data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li> <?php
                    }
                    if (!$userActiveTab) {
                        ?> <li><a data-org-url="<?php echo $dashboardOrgUrl; ?>" href="<?php echo $dashboardUrl; ?>"><?php echo Labels::getLabel("LBL_Dashboard", $siteLangId); ?></a></li> <?php
                    } else {
                        ?> <li><a data-org-url="<?php echo CommonHelper::generateUrl('Account', 'ProfileInfo', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Account', 'ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account", $siteLangId); ?></a></li> <?php
                    } ?>
                    <?php if ((User::canViewBuyerTab()  && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B')) || (User::canViewSupplierTab() && (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S'))) {
                        ?>
                    <li><a data-org-url="<?php echo CommonHelper::generateUrl('Account', 'Messages', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Account', 'Messages'); ?>"><?php echo Labels::getLabel("LBL_My_Messages", $siteLangId); ?></a></li>
                    <?php } ?>
                    <li><a data-org-url="<?php echo CommonHelper::generateUrl('Account', 'credits', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Account', 'credits'); ?>"><?php echo Labels::getLabel("LBL_My_Credits", $siteLangId); ?></a></li>
                    <li class="logout"><a data-org-url="<?php echo CommonHelper::generateUrl('GuestUser', 'logout', array(), '', null, false, $getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('GuestUser', 'logout'); ?>"><?php echo Labels::getLabel('LBL_Logout', $siteLangId); ?>
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</li>
<?php } ?>
