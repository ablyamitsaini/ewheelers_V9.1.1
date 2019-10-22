New Features
    => Google Tag Manager Script section in Admin Console under General Settings->SEO
    => New text field for adding Robots.txt file content in the Admin console under General
    Settings->SEO
    => New App mid banner under banners section in the Admin (Only for mobile apps)
    => Collection Image management for Mobile Application in admin. Admin can choose to display
    products or banner for mobile app only.
    => Sellers can add social profile links to their shop page
    => Quick books integration (Alpha build)

Enhancements
    Performance Updates
        => System now supports 500,000 products with 200 concurrent users with a load speed of under
        5 secs.
        => Application labels are fetched from JSON file.
        => System images rendering functionality is optimized.
        => Recommended products on product detail page is optimized.
        => Cache used on the home page for collections templates.
        => Added 304 headers for JS/CSS browser cache.
        => Last modified time cache is being used for system Banners and slides.
        => Header top navigation optimization via cache.
        Common API Functions
        => Mobile app, API and web are using the same centralized functions within the same file.
        => API Documentation:
        https://docs.google.com/document/d/1OfSDUCczkFVvg8ePo18ykjfLt8CP3gyN/edit#
        => API Responses:
        https://drive.google.com/drive/folders/16YnofIcYRhNyOvenKYmEUgGtoPLIAEU_?usp=sharing
        => Checkout process is handled within the app
        => RTL &amp; language labels support for mobile app
        => Domain links such as shop, product, category &amp; band are handled within app
        Sitemap (HTML &amp; XML)
        => Added new ‘Sitemap’ menu item in Admin Console with links to
        => View Sitemap in HTML
        => View Sitemap in XML
        => Update Sitemap
     => Added ‘lastmod’, ‘changefreq’, ‘priority’ tags to the XML file for better search engine crawling.

    Special Price &amp; Volume Discount
        => New menu items on Admin &amp; Seller consoles for Special Price &amp; Volume discount.
        => Both have been decoupled from the product inventory option.
        => User can add multiple entries without having to navigate to the product
        => Multi select options
        => Entries can be edited in the field itself.
        Language Labels
        => Language labels type column added (Web &amp; App)
        => App notifications content can be managed from the Admin
        => Manageable mobile app labels
        => Added ‘Update’ button for mobile and web labels for manual update.

    General Enhancements
        => Updated application code to handle UTM parameters generated via 3rd party marketing websites.
        => Search results and products listing can be sort by &#39;Most Discounted&#39;
        => Warning notification displayed to user if inventories are added for all product options. User will
        not be able to clone the product as well.
        => Added Shop, Dashboard, Homepage icons on user dashboards
        => Upgraded the reward points functionality on checkout. Application show how many reward
        points are applied for the order instead of the balance.
        => Replaced the filter reset button with text on the listing pages.
        => Added Yo!Kart script (&lt;!-- Yo!Kart --->) in application code so that websites like BuiltWith can
        recognize the platform
        => Admin can set users maximum withdraw threshold for wallet

Fixes

    UI Fixes
        => Cart and Search icon are manageable via Admin theme settings
        => Fixed auto-close on sharing options on product detail page.
        => Fixed UI issue for product image on quick view in favorites
        => Fixed user dashboard navigation bar issue.
        => Fixed additional addresses should not be in grey so that they don’t look disabled.
        => Fixed collection spacing issue on Home Page for Categories
        => Reordered cart Labels
        => RTL upgrades &amp; Fixes
        => Fixed unwanted white space on the product details page, for Recommended Products.
        => Fixed date picker while Cloning seller inventory.
        => Fixed configure email page layout when user logs in via Facebook account registered with mobile
        number
        => Fixed products images are display on featured shop page in quick view popup.

    Functional Updates &amp; Code Fixes
        => Fixed listing of messages on seller dashboard for return requests    
        => Fixed JS issues on product detail page
        => Handled invalid request error on Wishlist page
        => Fixed digital downloads JSON error
        => Removed google fonts from text editor. (Editor shall be upgraded in the next release)
        => Fixed invalid access error on submitting catalog request from seller for the first time.
        => Checkout page &amp; Address page buyer address needs to be selected by default
        => Changed all category/brand page listing to alphabetical.
        => Removed phone validations
        => Fixed IP change issues, removed code from the application.
        => Fixed messaging functionality in the system where incorrect profile image and messages were
        displayed on listing page
        => Fixed Import product media issue.
        => Fixed retain cart on login
        => Fixed rewards points calculation when discount coupon applied at checkout
        => Fixed affiliate commission history display for admin
        => Restricted display of shipping address in case of digital order product.
        => Remove Support Links from Base copy
        => Fixed &amp; aligned search results for keyword search and popular searches.
        => Fixed Google sign in for new email account
        => Fixed Ship station API rates output when no rates are fetched from the API.
        => Fixed redirection issue when back button is used on browser
        => Fixed default commission value that was not getting updated
        => Fixed search results based on product option filters        

Known Issues and Problems

Following is a list of known errors that don’t have a workaround. These issues will be fixed in the
subsequent release.
    => Change in minimum selling price when reconfigured by Admin
    => Additional product when options are added later on front end
    => Safari and IE 11 do not support our CSS. More info can be found at
    https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/

Installation steps:
 	• Download the files and configured with your development/production environment.
 	• You can get all the files mentioned in .gitignore file from git-ignored-files directory.
 	• Renamed -.htaccess file to .htaccess from {document root} and {document root}/public directory
	• Upload Fatbit library and licence files under {document root}/library.
	• Define DB configuration under {document root}/public/settings.php
	• Update basic configuration as per your system requirements under {document root}/conf directory.    
