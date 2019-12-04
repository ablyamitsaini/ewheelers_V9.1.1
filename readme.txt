Release Number: TV-1.4.0.20191204

Release Date: 2019/12/04

New Features :

	Admin 
	.  Admin user shall be able to Enable/Disable the 'Book now' functionality as a global setting via the admin console.
	.  The booking amount functionality shall be provided on the product level & not on the global level
	.  The admin shall decide the booking fees amount at the product level and create the product catalog for the Book now functionality.
	.  The input for booking fees setting shall be percentage-wise and the fees shall be applied to the whole product amount.
	.  Note
	   a)There will be no dedicated booking fees commission module for the book now products. The existing commission module will work.
	   b)The commission shall apply to the whole product amount & not on the booking amount.
	   c)The book now products shall not be eligible for the Cash on Delivery payment method.
	   d)In the cart, the same product shall not be eligible for the Buy now & Book now at the same time.
	   e)In case of Booking module is disabled from the global setting, the booking fees commission will also be disabled for book now products.
	 
	 Seller
	.  Seller shall get the option while adding/editing inventory product i.e CheckBox: Enable "Book Now"
	.  The partial payment or remaining amount shall be updated by the seller at the order level.
	.  The seller shall not decide the booking amount for the product.
	.  Note:
		a)The products shall be enabled for Book Now feature only if the global book now setting is enabled by the admin.
		b)The seller shall only be able to update the shipping status to 'Delivered' if he/she updated the remaining payment in the system
		c)In the case of Book Now products, the shipping module or address will be disabled/hidden because shipping is done by the seller offline.
		d)In case of return or refund requests, that shall be handled by seller/admin offline.
		
	Buyer
	.  Buyer shall get the functionality of 'Book Now' on the product detail page.
	.  The buyer shall need to login to the application to opt for 'Book Now' options.
	.  On the Check out page, the checkout amount shall get an additional column of booking amount instead of normal checkout.
	.  The shipping option shall be disabled only for "Book Now" products, as the product is not getting shipped, only the booking amount is being charged.
	.  The users shall get the proper notification wherever it is required in the form of emails, system alerts, etc 
	
Updates:
	
Fixes:

Notes: