Features :

	. ON/OFF management for Favorites/wishlist feature. 	
	. Reminder to buyer for products in cart.	
	. Reminder to buyer for products in Wishlist.
	. Re-order functionality. Added items to cart from previous order.
	. Save search functionality implemented.
	. Search filter values with url.
	. GDPR module.
	
Fixes: 
	. Default image display in case of actual image not exist.
	. On Return request approval fixed seller amount credit issue.
	. Fixed Seller dashboard order sales stats.
	. Fixes "Invalid access" error message display in case of change order status. 
	. Reward point discount with volume discount issue fixed.

Updates/Enhancements:

	. Url structure updates discarded slashes with url.
	. Updated Cookie path CONF_WEBROOT_URL in case of setCookies.
	. Search listing update based on multiple filter selection.
	. Rewards point immediately get subtracted if order is COD.
	. Order product settings save in separate table.
	. Blog design updates.

Existing Database updates:

	. Change all / to - in "urlrewrite_custom" column of table "tbl_url_rewrite".
	. tbl_user_favourite_products change `ufp_product_id` to `ufp_selprod_id`.
	. added one more table tbl_order_product_settings.
	
Risk :

	. Url structure updates : It will rewrite existing url structure and may impact on SEO.		

Note :  
	Url rewriting update : You can hit the url http://domainname.com/dummy/change-custom-url. It will rewrite existing url structure to compatible with current version.
	Order product setting: By using this url http://domainname.com/dummy/update-order-prod-setting
	
	Please be sure to remove dummyController file.