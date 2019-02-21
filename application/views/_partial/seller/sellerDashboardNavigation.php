<?php
$controller = strtolower($controller);
$action = strtolower($action);
?>
<div class="sidebar">
	<div class="logo-wrapper">
		<div class="logo-dashboard"><a href="<?php echo $logoUrl; ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
		<div class="js-hamburger hamburger-toggle is-opened"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
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
				
				
			</ul>
		</nav>
	</div>
</div>








<div class="col-md-2 hide--mobile hide--tab no-print">
	<div class="box box--white box--space">
	   <h6><?php echo Labels::getLabel('LBL_Seller_Dashboard',$siteLangId); ?></h6>

		<?php if(User::canViewBuyerTab() || User::canViewAdvertiserTab() || User::canViewAffiliateTab()){?>
		<div class="gap"></div>
		<div class="dashboard-togles dropdown"><span><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?> </span><a href="javascript:void(0)" class="ripplelink fa fa-ellipsis-v dropdown__trigger-js"><span class="ink animate" ></span></a>
			<div class="dropdown__target dropdown__target-js dashboard-options">
			  <ul>
			   <?php if(User::canViewBuyerTab()) { ?>
				<li><a href="<?php echo CommonHelper::generateUrl('buyer');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Buyer',$siteLangId); ?></a></li>
			   <?php } if(User::canViewAdvertiserTab()) {  ?>
				<li><a href="<?php echo CommonHelper::generateUrl('advertiser');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Advertiser',$siteLangId); ?></a></li>
			   <?php } if(User::canViewAffiliateTab()) {  ?>
				<li><a href="<?php echo CommonHelper::generateUrl('affiliate');?>" class="ripplelink"><?php echo Labels::getLabel('LBL_Affiliate',$siteLangId); ?></a></li>
			   <?php } ?>
			  </ul>
			</div>
		</div>
		<?php }?>
		<div class="box box--list">
		   <h6><?php echo Labels::getLabel('LBL_Quick_filters',$siteLangId);?></h6>
		   <ul class="links--vertical">
			   <li class="<?php echo ($controller == 'seller' && $action == 'index')?'is-active':''?>">
			   <a href="<?php echo CommonHelper::generateUrl('Seller'); ?>"><i class="fa fa-home"></i>
				<?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
		   </ul>
		</div>
		<div class="box box--list">
		   <h6><?php echo Labels::getLabel('LBL_Shop',$siteLangId);?></h6>
		   <ul class="links--vertical">
			   
		   </ul>
		</div>

		<div class="box box--list">
		   <h6><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></h6>
		   <ul class="links--vertical">
			   <li class="<?php echo ($controller == 'seller' && $action == 'sales') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>"><i class="fa fa-bar-chart"></i><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></a></li>
			   <li class="<?php echo ($controller == 'seller' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','orderCancellationRequests'); ?>"><i class="fa  fa-file-text"></i><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></a></li>
			  <li class="<?php echo ($controller == 'seller' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','orderReturnRequests'); ?>"><i class="fa fa-reply"></i><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></a></li>
		   </ul>
		</div>
		<div class="box box--list">
			<h6><?php echo Labels::getLabel('LBL_Settings',$siteLangId);?></h6>
			<ul class="links--vertical">
				<li class="<?php echo ($controller == 'seller' && $action == 'taxcategories') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','taxCategories'); ?>"><i class="fa fa fa-usd"></i><?php echo Labels::getLabel('LBL_Tax_Category',$siteLangId);?></a></li>
				<?php /*?><li class="<?php echo ($controller == 'seller' && $action == 'socialplatforms') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','socialPlatforms'); ?>"><i class="fa fa-share-alt"></i><?php echo Labels::getLabel('LBL_Social_Platforms',$siteLangId);?></a></li><?php */?>
				<li class="<?php echo ($controller == 'seller' && $action == 'options') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','options'); ?>"><i class="fa fa-plus-square-o"></i><?php echo Labels::getLabel('LBL_Options',$siteLangId);?></a></li>
			</ul>
		</div>
		<?php if(FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')){ ?>
		<div class="box box--list">
		    <h6><?php echo Labels::getLabel("LBL_Subscriptions",$siteLangId); ?></h6>
		    <ul class="links--vertical">
				<li class="<?php echo ($controller == 'seller' && ($action == 'subscriptions' || $action == 'viewsubscriptionorder')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions'); ?>"><i class="fa fa-file-text-o"></i><?php echo Labels::getLabel("LBL_My_Subscriptions",$siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'seller' && $action == 'packages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('seller','Packages' );?>"><i class="fa fa-th-large"></i><?php echo Labels::getLabel('LBL_Subscription_Packages',$siteLangId);?></a></li>
			</ul>
		</div>
		<?php } ?>

		<?php /* if(User::canViewAdvertiserTab()) { ?>
			<div class="box box--list">
				<h6><?php echo Labels::getLabel("LBL_Promotions",$siteLangId); ?></h6>
				<ul class="links--vertical">
					<li class="<?php echo ($controller == 'account' && ($action == 'promote' || $action == 'viewpromotions')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('account','promote'); ?>"><i class="fa fa-tags"></i><?php echo Labels::getLabel("LBL_My_Promotions",$siteLangId); ?></a></li>
				</ul>
			</div>
		<?php } */ ?>
		<!--div class="box box--list">
			<h6><?php echo Labels::getLabel("LBL_Bulk_Import_Export",$siteLangId); ?></h6>
			<ul class="links--vertical">
				 <li class="<?php echo ($controller == 'ImportExport' && $action == 'index') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('ImportExport','index'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_Settings",$siteLangId); ?></a></li>
			</ul>
		</div-->
		<div class="box box--list">
		   <h6><?php echo Labels::getLabel("LBL_Profile",$siteLangId); ?></h6>
		    <ul class="links--vertical">
				<li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><i class="fa fa-user"></i><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><i class="fa fa-envelope"></i><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?> <?php if($todayUnreadMessageCount > 0) { ?><span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span> <?php } ?></a></li>
				<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><i class="fa fa-credit-card-alt"></i><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
			   <!--<li class="<?php /* echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><i class="fa fa-heart"></i><?php echo Labels::getLabel('LBL_Wishlist/Favorites',$siteLangId); */?></a></li>-->
				<!--<li class="<?php /* echo ($controller == 'SavedProductsSearch' && $action == 'listing') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('SavedProductsSearch','listing');?>"><i class="fa fa-search-plus"></i><?php echo Labels::getLabel('LBL_Saved_Searches',$siteLangId); */ ?></a></li>-->
			   <li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><i class="fa  fa-unlock-alt"></i><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
			   <li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><i class="fa fa-envelope"></i><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
		    </ul>
		</div>
		<div class="box box--list">
			<h6><?php echo Labels::getLabel("LBL_Reports",$siteLangId); ?></h6>
			<ul class="links--vertical">
				<li class="<?php echo ($controller == 'reports' && $action == 'salesreport') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','SalesReport'); ?>"><i class="fa fa-line-chart"></i><?php echo Labels::getLabel('LBL_Sales_Report', $siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'reports' && $action == 'productsperformance') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','ProductsPerformance'); ?>"><i class="fa fa-signal"></i><?php echo Labels::getLabel('LBL_Products_Performance', $siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'reports' && $action == 'productsinventory') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventory'); ?>"><i class="fa fa-sitemap"></i><?php echo Labels::getLabel('LBL_Products_Inventory', $siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'reports' && $action == 'productsinventorystockstatus') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventoryStockStatus'); ?>"><i class="fa fa-bar-chart"></i><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status', $siteLangId); ?></a></li>
			</ul>
		</div>
	</div>
</div>
