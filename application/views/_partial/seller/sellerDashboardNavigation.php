<?php
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="sidebar">
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
	<div class="sidebar__content custom-scrollbar">
		<nav class="dashboard-menu">
			<ul>
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel('LBL_Shop',$siteLangId);?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'seller' && $action == 'shop') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','shop'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Manage_Shop',$siteLangId);?></span></a></div></li>

			   <?php if( $isShopActive && $shop_id > 0 ){ ?>
			   <li class="menu__item"><div class="menu__item__inner"><a target="_blank" href="<?php echo CommonHelper::generateUrl('Shops','view', array($shop_id)); ?>"><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_View_Shop',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && ($action == 'customProductForm' || $action == 'customproduct'|| $action == 'catalog')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('seller','catalog' );?>" ><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Products',$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && ($action == 'inventoryupdate')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('seller','InventoryUpdate' );?>" ><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Inventory_Update',$siteLangId); ?></span></a></div></li>
				<?php  if(FatApp::getConfig('CONF_ENABLE_IMPORT_EXPORT',FatUtility::VAR_INT,0)){?>
				<li class="menu__item <?php echo ($controller == 'importexport' && ($action == 'index')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('ImportExport','index' );?>" ><i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Import_Export',$siteLangId); ?></span></a></div></li>
				<?php }?>
				<li class="divider"></li>
			   <?php }?>
			   
			   
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'seller' && $action == 'Sales') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','Sales'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','orderCancellationRequests'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','orderReturnRequests'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></span></a></div></li>
				<li class="divider"></li>
				
				
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel('LBL_Settings',$siteLangId);?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'seller' && $action == 'taxcategories') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','taxCategories'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Tax_Category',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && $action == 'options') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','options'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Options',$siteLangId);?></span></a></div></li>
				<li class="divider"></li>
				
				<?php if(FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')){ ?>
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel('LBL_Settings',$siteLangId);?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'seller' && ($action == 'subscriptions' || $action == 'viewsubscriptionorder')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Subscriptions",$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'seller' && ($action == 'subscriptions' || $action == 'viewsubscriptionorder')) ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('seller','Packages' );?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Subscription_Packages',$siteLangId);?></span></a></div></li>
				<li class="divider"></li>
				<?php } ?>
				
				
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel("LBL_Profile",$siteLangId); ?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?> <?php if($todayUnreadMessageCount > 0) { ?><span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span> <?php } ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></span></a></div></li>
				<li class="divider"></li>
				
				
				<li class="menu__item">
					<div class="menu__item__inner"> <span class="menu-head"><?php echo Labels::getLabel("LBL_Reports",$siteLangId); ?></span></div>
				</li>
				<li class="menu__item <?php echo ($controller == 'reports' && $action == 'salesreport') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Reports','SalesReport'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Sales_Report', $siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'reports' && $action == 'productsperformance') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Reports','ProductsPerformance'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Products_Performance', $siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'reports' && $action == 'productsinventory') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventory'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Products_Inventory', $siteLangId); ?></span></a></div></li>
				<li class="menu__item <?php echo ($controller == 'reports' && $action == 'productsinventorystockstatus') ? 'is-active' : ''; ?>"><div class="menu__item__inner"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventoryStockStatus'); ?>">
				<i class="icn shop"><svg class="svg"><use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#manage-shop"></use></svg>
				</i><span class="menu-item__title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status', $siteLangId); ?></span></a></div></li>
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