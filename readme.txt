Bug:
    -> 030847 - Retain No Record Found if new volume discount or special price added for any product.
    -> 030841 - Admin> special price, volume discount > seller name column needs to be there
    -> 030840 - When currency is changed from front end> then it's displaying in INR while on editing it's in $
    -> 030839 - Club the special price and vol. discount in single section
    -> 030838 - When seller clicks on manage special price from product then it redirect to 404
    -> 030815 - Catalog requested by seller is not listing in admin
    -> 030638 - In arabic language> Throughout the website Vertical loader overlaps text
    -> 030832 - Shadow is there around the search result on searching item
    -> 030502 - On referral> clear search text in button is cropped.
    -> 030917 - Multiple special price are getting added for same date
    -> 030636 - If any popup is open then background page should not be scrolable
    -> 030632 - Drag&Drop functionality not working in mobile device for seller options(frontend)
    -> 030629 - In mobile devices > when we click on any option in drawer menu then drawer should get close.
    -> 030980 - When reviews are disabled from admin then they shouldn't be listed on front end
    -> 030918 - Getting error on shop policy page
    -> 030864 - Special price is not getting added for product which one having future date
    -> 030862 - Special Price & Volume Discount list label updated
    -> 030850 - In Special Price & Volume Discount listing, search by seller option should be there.
    -> 030848 - When invalid amount is added for special price then it sets the previous added amount without currency symbol(Admin & Frontend)
    -> 030849 - Latest added Special Price & Volume Discount are not listing on top in admin
    -> 030977 - Default affiliate commission entry is not there.
    -> 030567 - In Arabic language > Scroll bar should be display on RTL Mode
    -> 030560 - In Arabic language> on blogs page> subscribe button and text field are not properly arranged
    -> 030504 - Design changes of Save Changes and Cancel buttons
    -> 030501 - On "Rewards Points" page > columns should get display on whole screen and column name should not be scrollable.
    -> 030087 - Logo is displaying very large in Email template
    -> 030861 - Seller> on special price/volume discount> there needs to be some space between 'keyword", "search", "clear" buttons and between "select product", "price start date","price end date","special price".
    -> 030911 - On product details page, under recently viewed product,height needs to be same and name should be in 2 lines only
    -> 030563 - In arabic language, custom scroll bar displaying on on the wrong side
    -> 031119 - By deleting all Special Price or Volume Discount rows one by one, at last no message displayed for no record found

New Features :
	> Task - 64235 - Collection Image management for Mobile Application in admin.

<!-- Release notes TV-9.0.1.20190923 -- >
New Features :
	> Task - 66013 - Special Price Module
	> Task - 66013 - Volume Discount Module

Updates:
    > Message - 1017343 - Volume Discount Module.
	> App labels updated for all type of notifications

Enhancements :
    -> Display System image for product and banners
    -> JS/CSS handled browser cache with 304 headers.
    -> APP labels Management.
    -> For system Banners and slides - used cache by last modified time.
    -> Home page collections performance updates.
	-> Header top navigation optimization.

Bug:
    -> 030531 - Rewards points with discount coupon issue.
    -> 030635 - Retain cart on login
    -> 030272 - Import procuct media issue fixed.
    -> 030555 - On updating existing slide info details admin> it warns to have unique identifier
    -> 030456 - under wallet> display upto 2 digits after decimal
    -> 030520 - in blog section> on search box> place holder needs to be updated
    -> 030519 - admin> seller inventory> special price> button and heading are not aligned

API Feature:
    -> Downnload digital files in app.

<!--  Release notes TV-9.0.1.20190914 -- >
Bug :
    => 030496 - redirect back issue from browser back button.
    => 030167 - menu on dashboard is not loading randomly
    => 030287 - catalog data is not getting imported from admin
    => 029519 - User skips add address screen.
    => 030088 - admin> if wrong file is attached then warning message is not displaying properly
    => 030096 - default commission value is not getting changed.
    => 030097 - sales report> tax having wrong value on exporting file

<!--  Release notes TV-9.0.1.20190907 -- >

Updates:
    Buyer API

Enhancements :
   => Optimization for home page used cache for collections.
   => App notification labels update

<!--  Release notes TV-9.0.1.20190907 -- >

      Buyer API

      Sheet url : https://docs.google.com/spreadsheets/d/1FpUtNMAX3Zub5RIKe4ESxtXqcE7gkxJf_pe0hdKTTUI/edit#gid=0
      Notes: Check colomn "Web Status" in above sheet url for testing.

      => Login/Registration
      => Homepage/Landing
      => Account Management
      => Cart/Checkout
      => Address
      => General
      => Category
      => Product
      => Shop
      => Message
      => Order
      => Payment Gateways
      => Msg-1018591 Used Labels via json file.

   Enhancements :
      => Performance optimization : Used labels from json file.
      => Maintenance mode handling for API.
      => Optimization for system images.
      => Optimization for recommended products on product details page.
      => Optimization for home page used cache for collections templates.
