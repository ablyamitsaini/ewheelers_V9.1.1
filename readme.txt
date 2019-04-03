Fixes :
	. Optimized page load time.
	. Category search for autocomplete listing.
	. Buyer can cancel COD orders and Pending payment orders.
        . Admin approval is necessary to cancel the pending payments orders.
    . Fixed product category search result mismatch issue while adding catalog.
    . Products link option removed from header breadcrumb of product detail page.
    . Arabic email[SMTP] content was not showing properly.
    . Export options data from seller dashboard.
    . Auto suggest search listing results display according to order by searched keyword position.
    . Retain user on current page after social login.
	. Admin can view advertiser promotional banner or slides requests even advertiser is seller and his shop is inactive.
	. Seller promotional shop/product request will not be visible in admin if shop is inactive.
    . Xzoom image is displaying on wrong side for arabic language, issue resolved.
    . Showing some html elements content on seller products inventory(frontend), issue resolved.
    . Error Notice showing while searching products on frontend, issue resolved.
	. Aweber newsletter signup.
	. Refund and shipping calculation based on free shipping.
	. Replaced google plus login with google login.
	. Invalid access error on placing the cancellation request.
	. Labels cache value and removed tags from value.
	. Validation on date fields for product special price.
	. Displayed latest added collection on top when listing based on all type of collection(Admin).
	. Admin dashboard stats in case of cache.
	. Displayed volume discount on cart popup and view cart.
	. On product categories page controller name visible in breadcrumb.
	. Small fonts of dropdown on Add/Edit category and brand form popup.
	. Small fonts of Active dropdown in Search filter section on product catalog page.

Enhancements :
    . Import error handling via csv.
    . Order Print layout and functionality.
    . Managing product temp images(Import/Export) in admin.
    . Managing notifications according to sub admin permissions.
    . Managing email notifications
        . Having additional alert emails
        . Sending mail notification to super admin only
        . Sending email notifications to sub admin according to their permissions.
    . Displaying instructions as per each import module including general instructions.
    . New Payment method Braintree implemented.
	. From name on email notifications updated with site from name.
	. Import Error log file will be automatically downloaded if it contains errors listing.
	. Removed setting to use userId or username from import/export. Only username will be in use.
Note:
	Exceute {domainUrl}/dummy/update-cat-order-code.
