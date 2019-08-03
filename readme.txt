Multivendor - Released Version : RV-9.0.0

New Features:

	• Brand new UI for front-end, Shop and dashboard pages.
	• Improved user dashboards
	• Performance optimized
	• Full screen view of product image
	• Upload media from local machine. Removed dependency from servers and public URL’s.
	• Referred User listing page for Affiliate user.
	• Updated jQuery version to 3.4.1
	• Multi-Select Options for Admin/Seller & Buyer (Delete, Status Change)
	• Upgraded scripts to PHP V7.2 (Phpmailer Autoload function deprecated.)

Enhancements:

	Import-Export Module
		• Introduced ‘Product temp images’ page under ‘Misc’ in the Admin Console that updates the status of the cron job set for image update through bulk import.
		• Introduced ‘Upload Bulk images’ page under ‘Misc’ in the Admin Console that lets the user to add zip file for images to be imported via CSV file.
	Cart and Wish list
		• Connectivity in Cart and Wish list modules - Product can be moved from cart to Wishlist and vice versa seamlessly.
		• Cart will display total cart value with items count in header.
	Listing Pages
		• Listing pages have been updated where products are loaded through a permanent link and respective filters via Ajax. This will improve page load speed and SEO for listing pages.
		• Added ‘Sort by most discounted’ filter
	Orders
		• Added fields for min/max COD order limit for sellers.
		• Max negative amount on COD allowed for sellers. Defined at a global level as well as seller level for admin.
	Performance Optimization
		• Disabled parent category link in header navigation. Will improve page load speed.
		• Restricted empty search. Search string must be at least 3 characters. Will improve search results page load speed.
	User Dashboards
		• Updated Seller, Buyer, Affiliate and Advertiser dashboard KPI’s to more useful statistics.
	General Enhancements
		• Introduced validations handling/messages through a centralized class/repository.
		• Option values cannot be deleted from the Option group if it is linked with a product and seller inventory.
		• All Admin links will open in a new tab for better usability.
		• Introduced Cost Price field for products. Cost price will be reflected in the reports where user can view profits made per product.
		• On the product detail page user cannot add ‘qty’ more than available inventory for the product.
		• Added layout template preview for Content pages.
		• Removed collections primary record field and managed collection from static defined values.
		• Added filter to refine search listing on the catalog page in admin console based on user.
		. Added device specific media upload feature on shop, category and brand banners.

Fixes:

	UI Fixes
		• Heading layout direction in Seller order view.
	Functional Updates & Code Fixes
		• Fixed Payfort & Paytm payment gateway issues.
		• Updated Authorize.net payment gateway API’s.
		• Fixed Product Model mandatory option in the Admin console.
		• ‘Request new brand’ count will be displayed on admin sidebar.
		• Fixed ‘available date’ checks for product to display on the front end.
		• Fixed Featured shops & All Shops listing issues.
		• Added recently viewed products slider on product view page.
		• Updated slides banner identifier to be unique.
		• Fixed system accepting 'Date From' greater than 'Date To' on discount coupon form.
		• Fixed Integer and Alphanumeric validation for Phone No. and Zip Code.
		• Applied Validation for adding more than 100% volume discount.
		• Restriction on entering negative value in the ‘free shipping on’ field, on the manage shop page.
		• Fixed Price filter accepting decimal input
		• Apple touch icon does not display correctly
		• Fixed Aweber code
		• Fixed redirection to same page after turning on the ‘Shipped by me’ option on the seller dashboard.
		• 029021 - No default address selected when previous default address is deleted
		• 029024 - Default address is changed even when user clicks on cancel button while changing default address
		• 029114 - Pop-up for confirm message is displayed even when clicked on current default address
Known Issues and Problems:

	Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release.
	• Change in minimum selling price
	• Change in user assignment for a catalog product

Installation steps:
 	• Download the files and configured with your development/production environment.
 	• You can get all the files mentioned in .gitignore file from git-ignored-files directory.
 	• Renamed -.htaccess file to .htaccess from {document root} and {document root}/public directory
	• Upload Fatbit library and licence files under {document root}/library.
	• Define DB configuration under {document root}/public/settings.php
	• Update basic configuration as per your system requirements under {document root}/conf directory.
