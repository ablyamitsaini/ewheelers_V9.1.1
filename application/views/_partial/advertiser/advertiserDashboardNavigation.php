<?php
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="sidebar no-print">
	<div class="logo-wrapper">
		<?php
		if( CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'] ) ){
			$logoUrl = CommonHelper::generateUrl('home','index');
		}else{
			$logoUrl = CommonHelper::generateUrl();
		}
		?>
		<div class="logo-dashboard"><a href="<?php echo $logoUrl; ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
		<div class="js-hamburger hamburger-toggle"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
	</div>
	<div class="sidebar__content custom-scrollbar" data-simplebar>
		<nav class="dashboard-menu">
			<ul>
				<?php if(User::canViewAdvertiserTab()) { ?>
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel("LBL_Promotions",$siteLangId); ?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'advertiser' && ($action == 'promotions' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a title="<?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?>" href="<?php echo CommonHelper::generateUrl('advertiser','promotions'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-promotions" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-promotions"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a title="<?php echo Labels::getLabel("LBL_My_Credits",$siteLangId); ?>" href="<?php echo CommonHelper::generateUrl('Account','credits');?>" ><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-credits" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-credits"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></span></a></div></li>
				<li class="divider"></li>
				<?php } ?>

				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a title="<?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?>" href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-account" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-account"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a title="<?php echo Labels::getLabel("LBL_Change_Password",$siteLangId); ?>" href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-change-password" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-change-password"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a title="<?php echo Labels::getLabel("LBL_Change_Email",$siteLangId); ?>" href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-change-email" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#dash-change-email"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></span></a></div></li>
				<li class="divider"></li>
			</ul>
		</nav>
	</div>
<script>

var Dashboard = function () {

	var menuChangeActive = function menuChangeActive(el) {
		var hasSubmenu = $(el).hasClass("has-submenu");
		$(global.menuClass + " .is-active").removeClass("is-active");
		$(el).addClass("is-active");


	};

	var sidebarChangeWidth = function sidebarChangeWidth() {
		var $menuItemsTitle = $("li .menu-item__title");

		$("body").toggleClass("sidebar-is-reduced sidebar-is-expanded");
		$(".hamburger-toggle").toggleClass("is-opened");



	};

	return {
		init: function init() {
			$(".js-hamburger").on("click", sidebarChangeWidth);

			$(".js-menu li").on("click", function (e) {
				menuChangeActive(e.currentTarget);
			});


		}
	};

}();

Dashboard.init();
</script>
</div>
