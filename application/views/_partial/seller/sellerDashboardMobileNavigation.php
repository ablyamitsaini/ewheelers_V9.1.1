<?php 
$controller = strtolower($controller);
$action = strtolower($action);
?>
<ul class="list--vertical hide--desktop">
	<li class="<?php echo ($controller == 'seller' && $action == 'index')?'is-active':''?>"><a href="<?php echo CommonHelper::generateUrl('Seller'); ?>"><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></a></li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Shop',$siteLangId);?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'seller' && $action == 'shop') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','shop'); ?>"><?php echo Labels::getLabel('LBL_Manage_Shop',$siteLangId);?></a></li>
			<?php if( $isShopActive ){ ?>
			<li><a href="<?php echo CommonHelper::generateUrl('Shops','view', array($shop_id)); ?>"><?php echo Labels::getLabel('LBL_View_Shop',$siteLangId);?></a></li>
			<!--<li class="<?php // echo ($controller == 'seller' && $action == 'categorybanners') ? 'is-active' : ''; ?>"><a href="<?php // echo CommonHelper::generateUrl('Seller','CategoryBanners'); ?>"><?php // echo Labels::getLabel('LBL_Category_Banners',$siteLangId);?></a></li>-->
			<?php } ?>
			<li class="<?php echo ($controller == 'seller' && ($action == 'catalog' || $action == 'products' ||  $action == 'customproduct')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('seller','products' );?>" ><?php echo Labels::getLabel('LBL_Products',$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'seller' && ($action == 'inventoryupdate')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('seller','InventoryUpdate' );?>" ><?php echo Labels::getLabel('LBL_Inventory_Update',$siteLangId); ?></a></li>
		</ul>
	</li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'seller' && $action == 'sales') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>"><?php echo Labels::getLabel('LBL_Sales',$siteLangId);?></a></li>
			<li class="<?php echo ($controller == 'seller' && $action == 'ordercancellationrequests') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','orderCancellationRequests'); ?>"><?php echo Labels::getLabel("LBL_Order_Cancellation_Requests",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'seller' && ($action == 'orderreturnrequests' || $action == 'vieworderreturnrequest') ) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','orderReturnRequests'); ?>"><?php echo Labels::getLabel("LBL_Order_Return_Requests",$siteLangId); ?></a></li>
		</ul>
	</li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Settings',$siteLangId);?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'seller' && $action == 'taxcategories') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','taxCategories'); ?>"><?php echo Labels::getLabel('LBL_Tax_Category',$siteLangId);?></a></li>
			<?php /*?><li class="<?php echo ($controller == 'seller' && $action == 'socialplatforms') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','socialPlatforms'); ?>"><?php echo Labels::getLabel('LBL_Social_Platforms',$siteLangId);?></a></li><?php */?>
			<li class="<?php echo ($controller == 'seller' && $action == 'options') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl(	'Seller','options'); ?>"><?php echo Labels::getLabel('LBL_Options', $siteLangId); ?></a></li>
		</ul>
	</li>
	<?php if(FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')){ ?>
		<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Subscriptions', $siteLangId); ?></span>
			<ul class="childs">
				<li class="<?php echo ($controller == 'seller' && ($action == 'subscriptions' || $action == 'viewsubscriptionorder')) ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions'); ?>"><?php echo Labels::getLabel('LBL_My_Subscriptions', $siteLangId); ?></a></li>
				<li class="<?php echo ($controller == 'seller' && $action == 'packages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Seller','Packages'); ?>"><?php echo Labels::getLabel('LBL_Subscription_Packages', $siteLangId); ?></a></li>
			</ul>
		</li>
	<?php } ?>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Profile', $siteLangId); ?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'account' && $action == 'profileinfo') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','ProfileInfo'); ?>"><?php echo Labels::getLabel("LBL_My_Account",$siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'messages') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>"><?php echo Labels::getLabel("LBL_Messages",$siteLangId); ?> <?php if($todayUnreadMessageCount > 0) { ?><span class="msg-count"><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span> <?php } ?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'credits') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','credits');?>"><?php echo Labels::getLabel('LBL_My_Credits',$siteLangId);?></a></li>
			<!--<li class="<?php /* echo ($controller == 'account' && $action == 'wishlist') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><?php echo Labels::getLabel('LBL_Wishlist/Favorites',$siteLangId); */?></a></li>-->
			<li class="<?php echo ($controller == 'SavedProductsSearch' && $action == 'listing') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('SavedProductsSearch','listing');?>"><?php echo Labels::getLabel('LBL_Saved_Searches',$siteLangId);?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'changepassword') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changePassword');?>"><?php echo Labels::getLabel('LBL_Change_Password',$siteLangId);?></a></li>
			<li class="<?php echo ($controller == 'account' && $action == 'changeemail') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Account','changeEmail');?>"><?php echo Labels::getLabel('LBL_Change_Email',$siteLangId);?></a></li>
		</ul>
	</li>
	<li class="has-child"><span class="parents--link"><?php echo Labels::getLabel('LBL_Reports', $siteLangId); ?></span>
		<ul class="childs">
			<li class="<?php echo ($controller == 'reports' && $action == 'salesreport') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','SalesReport'); ?>"><?php echo Labels::getLabel('LBL_Sales_Report', $siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'reports' && $action == 'productsperformance') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','ProductsPerformance'); ?>"><?php echo Labels::getLabel('LBL_Products_Performance', $siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'reports' && $action == 'productsinventorystockstatus') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventory'); ?>"><?php echo Labels::getLabel('LBL_Products_Inventory', $siteLangId); ?></a></li>
			<li class="<?php echo ($controller == 'reports' && $action == 'productsinventorystockstatus') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('Reports','productsInventoryStockStatus'); ?>"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status', $siteLangId); ?></a></li>
		</ul>
	</li>
	<li class="<?php echo ($controller == 'GuestUser' && $action == 'Logout') ? 'is-active' : ''; ?>"><a href="<?php echo CommonHelper::generateUrl('GuestUser','Logout');?>"><?php echo Labels::getLabel('LBL_Logout',$siteLangId);?></a></li>
</ul>
