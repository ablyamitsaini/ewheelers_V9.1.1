<?php
    defined('SYSTEM_INIT') or die('Invalid Usage.');
    $blockLangFrm->setFormTagAttribute('class', 'web_form layout--'.$formLayout);
    $blockLangFrm->setFormTagAttribute('onsubmit', 'setupBlockLang(this); return(false);');

    $blockLangFrm->developerTags['colClassPrefix'] = 'col-md-';
    $blockLangFrm->developerTags['fld_default_col'] = 12;


    $edFld = $blockLangFrm->getField('epage_content');
    if( $epageData['epage_content_for'] == Extrapage::CONTENT_IMPORT_INSTRUCTION ){
    	$epage_label = $blockLangFrm->getField('epage_label');
    	$epage_content = $blockLangFrm->getField('epage_content');
    	$epage_label->changeCaption(Labels::getLabel('LBL_Section_Title',$adminLangId));
    	$epage_content->changeCaption(Labels::getLabel('LBL_Section_Content',$adminLangId));
    }
    $edFld->htmlBeforeField = '<br/><a class="themebtn btn-primary" onClick="resetToDefaultContent();" href="javascript:void(0)">Reset Editor Content to default</a>';

    if(array_key_exists($epageData['epage_id'],$contentBlockArrWithBg)) {
    	$fld = $blockLangFrm->getField('cblock_bg_image');
    	$fld->addFieldTagAttribute('class','btn btn--primary btn--sm');

    	$preferredDimensionsStr = '<small class="text--small"> '.Labels::getLabel('LBL_This_will_be_displayed_on_Registration_Page',$adminLangId).'</small>';

    	$htmlAfterField = $preferredDimensionsStr;
    	/* CommonHelper::printArray($bgImages);die; */
    	if( !empty($bgImages) ){
    		$htmlAfterField .= '<ul class="image-listing grids--onethird">';
    		foreach($bgImages as $bgImage){
    		$htmlAfterField .= '<li>'.$bannerTypeArr[$bgImage['afile_lang_id']].'<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('image','cblockBackgroundImage',array($epageData['epage_id'],$bgImage['afile_lang_id'],'THUMB',$bgImage['afile_type']),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeBgImage('.$bgImage['afile_record_id'].','.$bgImage['afile_lang_id'].','.$bgImage['afile_type'].')" class="remove--img"><i class="ion-close-round"></i></a></div>';
    		}
    		$htmlAfterField.='</li></ul>';
    	} else {
    		$htmlAfterField.='<div class="temp-hide"><ul class="image-listing grids--onethird"><li><div class="uploaded--image"></div></li></ul></div>';
    	}
    	$fld->htmlAfterField = $htmlAfterField;
    }
    ?>
<!-- editor's default content[ -->
<div id="editor_default_content" style="display:none;">
    <?php
        if( isset($epageData) ){
        	switch ($epageData['epage_type']){
        		case Extrapage::CONTACT_US_CONTENT_BLOCK:
        		?>
				    <h6 class="txt--uppercase">IMPORTANT INFORMATION REGARDING ONLINE PHISHING FRAUD</h6>
				    <p>If you have recently received suspect correspondence or a link regarding your data security on yoKart.com, please<a href="#">Click Here</a>.</p>
				    <h6 class="txt--uppercase">ORDER ACCEPTANCE POLICIES</h6>
				    <p>Yokart Does not accept the order by
				        <a href="#">Manufacturers contact page</a>.
				    </p>
		    	<?php
		        break;

		        case Extrapage::SELLER_PAGE_BLOCK1:
		        ?>
				    <div class="row">
				        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				            <div class="growth" style="background-image:url(images/customer.png);"><strong>5+</strong><br>
				                Millions Customers
				            </div>
				            <div class="growth" style="background-image:url(images/bussiness.png);"><strong>1000+</strong><br>
				                Business Growing rapidly with us
				            </div>
				        </div>
				        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				            <ul class="growth-txt">
				                <li>
				                    <i class="icn"><img src="images/star-unique.png" alt=""></i>
				                    <h4>Consectetur adipisicing</h4>
				                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
				                        incididunt ut labore et dolore magna aliqua.
				                    </p>
				                </li>
				                <li>
				                    <i class="icn"><img src="images/folder.png" alt=""></i>
				                    <h4>Consectetur adipisicing</h4>
				                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
				                        incididunt ut labore et dolore magna aliqua.
				                    </p>
				                </li>
				            </ul>
				        </div>
				    </div>
				<?php
		        break;

		        case Extrapage::SELLER_PAGE_BLOCK2:
		        ?>
		    		<div class="heading1">Simple steps to start selling online</div>
				    <div class="seller-steps">
				        <ul>
				            <li>
				                <i class="icn"><img src="/images/easyto-use.png" alt=""></i>
				                <h3>Easy to Use</h3>
				                <p>Set up simulation exercises for large group of students in a few steps.</p>
				            </li>
				            <li>
				                <i class="icn"><img src="/images/real-market.png" alt=""></i>
				                <h3>Real Market Data</h3>
				                <p>Use real financial markets data in simulation activities.</p>
				            </li>
				            <li>
				                <i class="icn"><img src="/images/simulated.png" alt=""></i>
				                <h3>Simulated Market Data</h3>
				                <p>Simulate past market events and data over a specific historical time period.</p>
				            </li>
				            <li>
				                <i class="icn"><img src="/images/customization.png" alt=""></i>
				                <h3>Fully Customisable</h3>
				                <p>Fully customise activities to meet various learning outcomes, disciplines and levels of difficulty.</p>
				            </li>
				        </ul>
				    </div>
				    <?php
		        break;

		        case Extrapage::SELLER_PAGE_BLOCK3:
		        ?>
				    <div class="heading1">Simple Pricing Structure</div>
				    <div class="pricing-structure">
				        <ul>
				            <li>
				                <span>10%</span>
				                <p>Commission Fee</p>
				            </li>
				            <li class="sign">+</li>
				            <li>
				                <span>$1</span>
				                <p>Shipping Fee</p>
				            </li>
				            <li class="sign">+</li>
				            <li>
				                <span>$4 </span>
				                <p>Marketplace Fee</p>
				            </li>
				            <li class="sign">+</li>
				            <li>
				                <span>15% </span>
				                <p>Service Tax</p>
				            </li>
				            <li class="sign">+</li>
				            <li>
				                <span>Amt. </span>
				                <p>Amount You Earned</p>
				            </li>
				            <li class="sign">=</li>
				            <li>
				                <span>Price </span>
				                <p>Price You Decide</p>
				            </li>
				        </ul>
				    </div>
				    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum voluptatem.</p>
				    <a href="#" class="btn btn--primary btn--custom">Learn More About Pricing</a>
				<?php
		        break;

		        case Extrapage::ADMIN_PRODUCTS_CATEGORIES_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Categories Content</h3>
                        <h4>Category Identifier</h4>
                        <p> User defined free text field for unique identifier of the category. This works as a unique key for the system to identify a particular category.</p>
                        <h4>Parent Identifier</h4>
                        <p> Parent Identifier is used for categories that belong to a root/master category, essentially they are subcategories to root categories. For a category that is root/master category the parent identifier needs to be left blank.</p>
                        <h4>Name</h4>
                        <p> User defined name for the category.</p>
                        <h4>Description</h4>
                        <p>User defined description for the category.</p>
                        <h4>SEO Friendly URL</h4>
                        <p> User defined URL for the category for SEO purposes. Spaces cannot be used in the URL.</p>
                        <h4>Featured</h4>
                        <p> User defined field to mark a particular category as featured or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’.</p>
                        <h4>Active</h4>
                        <p> User defined field to mark a particular category as active in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’Yes’.</p>
                        <h4>Display Order</h4>
                        <p> User defined field to set priority on display order of root categories or sub-categories within a root category.</p>
                        <p>If more than one category has display order set to the same value then the system will display category that was added first. If you are unsure about this field add display order as ‘1’ to all the categories.</p>
                        <p>Deleted - User defined field to mark a particular category as deleted in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’No’ to display categories in the system.</p>
                        <h3>Categories Media</h3>
                        <h4>Category Identifier</h4>
                        <p> User defined unique identifier for the category. This field needs to be the same as Category Identifier defined in Categories Content sheet.</p>
                        <h4>Lang Code</h4>
                        <p> User defined field to link the category image for a particular language. ‘Universal’ is to be used as an option to link the media in all languages. Language codes can be looked up by clicking the language option in the top header. Language codes need to be used if the Category has different images for each language.</p>
                        <h4>Image Type</h4>
                        <p> User defined field with input options of ‘Category Icon’ &amp; ‘Category Banner’. Category icon option is to be used when uploading icon image for the category. Category banner option is to be used when uploading banner image for the category page.</p>
                        <h4>File Path</h4>
                        <p> File path needs to be a publically accessible URL for example URL’s from Google Drive, Dropbox etc. Images stored locally on your personal device/machine cannot be uploaded. Preferred image dimensions for Category Icon are 60*60 pixels. Preferred image dimensions for Category banner are 1050*340 pixels.</p>
                        <h4>File Name</h4>
                        <p> Name of the image file</p>
                        <h4>Display order</h4>
                        <p> When a category has multiple images then this field defines the order of display. If you are unsure about this field add display order as ‘1’ to all the categories.</p>
                    </div>
				<?php
		        break;

				case Extrapage::GENERAL_SETTINGS_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Multilingual</h3>
                        <p> Since Yo!Kart inherently is a multilingual platform all export-import functionality where ever available in the system will only work for the particular language exported or imported in. This means that a file that is exported in English will only update English values when imported back into the system. Same items in other languages will not be updated until the user exports the same CSV in other languages makes changes and imports it back to the system. </p>
                        <h3>Import/Export process</h3>
                        <p> As a practice it is always recommended to export the CSV first make changes to it and then import it back into the system. This practice will insure accuracy of the CSV file and minimize any errors during import. </p>
                        <h3>Images/Media Files</h3>
                        <p> Any type of images/media can only be imported into the system if the file is located at a public URL. For example the file should be hosted either on a server which is accessible publically or on online tools such as Dropbox/Google Drive etc. Please note that images saved on devices and desktops cannot be imported through the CSV. Once the media CSV is imported in to the system, a cron job is executed by the system to import and save the images on the server. This cron job is an automated script that the system runs after a set interval on its own and no intervention is required from the users end. The media/images imported into the system will not display immediately. </p>
                        <h3>Deleting Items</h3>
                        <p> Within Yo!Kart when an item is deleted, the system does not actually delete the item from the database rather it just hides the item from display. With the import functionality a user can restore a previously deleted item by changing the value of the deleted column from ‘Yes’ to ‘No’. </p>
                        <h3>Import Log File</h3>
                        <p> Yo!Kart will generate a CSV log file for every import action where it will log the column and row for the errors encountered during the import. If the import was successful then no log file will be generated. System will only allow importing the CSV if no errors are encountered. </p>
                        <h3>CSV</h3>
                        <p> To avoid errors it is absolutely recommended to not alter columns or its names in the CSV. Also to import bulk entries it is absolutely recommended to keep maximum entries to a count of 20,000 per sheet. It is absolutely recommended to make multiple sheets for data above 20,000. </p>
                    </div>
				<?php
		        break;

				case Extrapage::ADMIN_BRANDS_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Brands Content</h3>
                        <h4>Brand Identifier</h4>
                        <p>User defined unique identifier for the Brand. This works as a unique key for the system to identify a particular Brand.</p>
                        <h4>Name</h4>
                        <p>User defined name for the Brand in the system.</p>
                        <h4>Description</h4>
                        <p>User defined description for the Brand.</p>
                        <h4>SEO Friendly URL</h4>
                        <p>User defined URL for the Brand for SEO purposes. Spaces cannot be used in the URL.</p>
                        <p>Featured - User defined field to mark a particular Brand as featured or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’.</p>
                        <p>Active - User defined field to mark a particular category as active in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’Yes’.</p>
                        <h3>Brands Media</h3>
                        <h4>Brand Identifier</h4>
                        <p>User defined unique identifier for the Brand. This field needs to be the same as Brand Identifier defined in Brands Content sheet.</p>
                        <h4>Lang Code</h4>
                        <p>User defined field to link the brand image for a particular language. ‘Universal’ is to be used as an option to link the media in all languages. Language codes can be looked up by clicking the language option in the top header. Language codes need to be used if the Brand has different images for each language.</p>
                        <h4>File Path</h4>
                        <p>File path needs to be a publically accessible URL for example URL’s from Google Drive, Dropbox etc. Images stored locally on your personal device/machine cannot be uploaded. Preferred image dimensions are 192*82 pixels.</p>
                        <h4>File Name</h4>
                        <p>Name of the image file</p>
                        <h4>Display order</h4>
                        <p>When a brand has multiple images then this field defines the order of display. If you are unsure about this field add display order as ‘1’ to all the brands.</p>
                    </div>
				<?php
		        break;

				case Extrapage::ADMIN_OPTIONS_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Options Content</h3>
                        <h4>Option Identifier</h4>
                        <p>User defined unique identifier for the Option. This works as a unique key for the system to identify a particular Option.</p>
                        <h4>Option Name</h4>
                        <p>User defined name for the Option.</p>
                        <h4>Username</h4>
                        <p>For admin this field needs to be left blank. In case an option is added by a seller then seller username will be displayed in this field.</p>
                        <h4>Is separate image</h4>
                        <p>User defined input field to denote if the option would have a separate image. Useful for color options of the product. Possible inputs for this field are ‘Yes’ &amp; ‘No’. </p>
                        <p>Is color type - User defined input field to denote if option is a color. Possible inputs for this field are ‘Yes’ &amp; ‘No’.</p>
                        <p>Display in filters - User defined input field to denote if option is to be displayed in the filters on the product listing page. Possible inputs for this field are ‘Yes’ &amp; ‘No’.</p>
                        <p>Deleted - User defined field to mark a particular option as deleted in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’No’ to display categories in the system.</p>
                        <h3>Options Value</h3>
                        <h4>Option value identifier</h4>
                        <p>User defined unique identifier for the Option value. This works as a unique key for the system to identify a particular Option value.</p>
                        <h4>Option Identifier</h4>
                        <p>User defined unique identifier for the option. This field value needs to be the same as the Option Identifier defined in Options Content sheet. </p>
                        <h4>Option Value</h4>
                        <p>User defined value for the Option.</p>
                        <h4>Color code</h4>
                        <p>User defined Hexadecimal value for the color of the option. Only to be used if the option is a color. Leave this field blank if the option is not a color. Hexadecimal for a color can be searched on Google.</p>
                        <p>Display order - When an option has multiple option values then this field defines the order of display of the option value. If you are unsure about this field add display order as ‘1’.</p>
                    </div>
				    <?php
		        break;

				case Extrapage::ADMIN_TAGS_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Tags Content</h3>
                        <h4>Tag Identifier</h4>
                        <p>User defined unique identifier for the Tag. This works as a unique key for the system to identify a particular Tag.</p>
                        <h4>Username</h4>
                        <p>For admin this field needs to be left blank. In case a tag is added by a seller then seller username will be displayed in this field.</p>
                        <h4>Tag name</h4>
                        <p>User defined name for the Tag.</p>
                    </div>
				<?php
		        break;

				case Extrapage::ADMIN_COUNTRIES_MANAGEMENT_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <h3>Countries Content</h3>
                        <h4>Country Code</h4>
                        <p>User defined field for unique country code.</p>
                        <h4>Country Name</h4>
                        <p>User defined field for unique country name.</p>
                        <h4>Currency Code</h4>
                        <p>User defined field for unique currency code for the country.</p>
                        <h4>Language Code</h4>
                        <p>‘Universal’ is to be used as an option to link the media in all languages. </p>
                        <p>Language codes can be looked up by clicking the language option in the top header. Language codes need to be used if the Category has different images for each language.</p>
                        <h4>Active</h4>
                        <p>User defined field to mark a particular country as active in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’Yes’.</p>
                    </div>
				<?php
		        break;

				case Extrapage::ADMIN_STATE_MANAGEMENT_INSTRUCTIONS:
		        ?>
                <div class="container--cms">
                    <h3>States Content</h3>
                    <h4>State Identifier</h4>
                    <p>User defined unique identifier for the State. This works as a unique key for the system to identify a particular State.</p>
                    <h4>Country Code</h4>
                    <p>This field needs to be the same as country code defined in Countries Content sheet. </p>
                    <h4>State Name</h4>
                    <p>User defined field for unique state name.</p>
                    <h4>State Code</h4>
                    <p>User defined field for unique state code.</p>
                    <h4>Active</h4>
                    <p>User defined field to mark a particular state as active in the system or not. Possible inputs for this field are ‘Yes’ &amp; ‘No’. Default value should be set as ’Yes’.</p>
                </div>
				<?php
		        break;

				case Extrapage::ADMIN_CATALOG_MANAGEMENT_INSTRUCTIONS:
		        ?>
                    <div class="container--cms">
                        <ul>
                            <li>
                                <h3>Product Catalog Content</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This works as a unique key for the system to identify a particular Product.</p>
                                    </li>
                                    <li>
                                        <h5>Username</h5>
                                        <p>For admin this field needs to be left blank. In case an option is added by a seller then seller username will be displayed in this field.</p>
                                    </li>
                                    <li>
                                        <h5>Name</h5>
                                        <p>User defined field for product name.</p>
                                    </li>
                                    <li>
                                        <h5>Description</h5>
                                        <p>User defined field for product description.</p>
                                    </li>
                                    <li>
                                        <h5>Youtube video</h5>
                                        <p>User defined field for product Youtube video URL.</p>
                                    </li>
                                    <li>
                                        <h5>Category Identifier</h5>
                                        <p>User defined unique identifier for the category. This field needs to be the same as Category Identifier defined in Categories Content sheet.</p>
                                    </li>
                                    <li>
                                        <h5>Brand Identifier</h5>
                                        <p>User defined unique identifier for the Brand. This field needs to be the same as Brand Identifier defined in Brand Content sheet.</p>
                                    </li>
                                    <li>
                                        <h5>Product Type Identifier</h5>
                                        <p>User defined input field to denote the type of the Product. Possible inputs for this field are ‘Physical’ &amp; ‘Digital’.</p>
                                    </li>
                                    <li>
                                        <h5>Model</h5>
                                        <p>User defined field for product model.</p>
                                    </li>
                                    <li>
                                        <h5>Minimum selling price</h5>
                                        <p>User defined field for minimum selling price for the product.</p>
                                    </li>
                                    <li>
                                        <h5>Tax Category Identifier</h5>
                                        <p>User defined unique identifier for the Tax category. This field needs to be the same as Tax Category Identifier defined in the Admin console under the Sales Tax option page. </p>
                                    </li>
                                    <li>
                                        <h5>Length</h5>
                                        <p>User defined field for product package length.</p>
                                    </li>
                                    <li>
                                        <h5>Width</h5>
                                        <p>User defined field for product package width.</p>
                                    </li>
                                    <li>
                                        <h5>Height</h5>
                                        <p>User defined field for product package Height.</p>
                                    </li>				<li>
                                        <h5>Dimension Unit Identifier</h5>
                                        <p>User defined input field to denote the unit of the dimensions of the package. Possible inputs for this field are ‘Inch’, ‘Centimeter’ , ‘Feet’. </p>
                                    </li>
                                    <li>
                                        <h5>Weight</h5>
                                        <p>User defined field for product package Weight.</p>
                                    </li>
                                    <li>
                                        <h5>Weight Unit Identifier</h5>
                                        <p>User defined input field to denote the unit of the weight of the package. . Possible inputs for this field are ‘Gram’, ‘Kilogram’ , ‘Pound’. </p>
                                    </li>
                                    <li>
                                        <h5>Ean/upc Code</h5>
                                        <p>User defined field for EAN/UPC code of the product.</p>
                                    </li>
                                    <li>
                                        <h5>Shipping country Code</h5>
                                        <p>This field needs to be the same as country code defined in Countries Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Added On</h5>
                                        <p>User defined field for product add date to the system.</p>
                                    </li>
                                    <li>
                                        <h5>Free Shipping</h5>
                                        <p>User defined field to mark a particular Product is available for free shipping. Possible inputs for this field are ‘Yes’ , ‘No’.</p>
                                    </li>
                                    <li>
                                        <h5>COD Available</h5>
                                        <p>User defined field to mark a particular Product is available for Cash on Delivery or not. Possible inputs for this field are ‘Yes’ , ‘No’.</p>
                                    </li>
                                    <li>
                                        <h5>Featured</h5>
                                        <p>User defined field to mark a particular Product as featured or not. Possible inputs for this field are ‘Yes’ , ‘No’.</p>
                                    </li>
                                    <li>
                                        <h5>Approved</h5>
                                        <p>User defined field to mark a particular Product as Approved or not. Possible inputs for this field are ‘Yes’ , ‘No’. Default value should be set as ’Yes’ to display products in the system.</p>
                                    </li>
                                    <li>
                                        <h5>Active</h5>
                                        <p>User defined field to mark a particular Product as active in the system or not. Possible inputs for this field are ‘Yes’ , ‘No’. Default value should be set as ’Yes’.</p>
                                    </li>
                                    <li>
                                        <h5>Deleted</h5>
                                        <p>User defined field to mark a particular product as deleted in the system or not. Possible inputs for this field are ‘Yes’ , ‘No’. Default value should be set as ’No’ to display products in the system.</p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <h3>Product Option Content</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This field needs to be the same as Product Identifier defined in the Product Catalog Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Option Identifier</h5>
                                        <p>User defined unique identifier for the Option. This field needs to be the same as Option Identifier defined in Option Content sheet. </p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <h3>Product Tag Content</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This field needs to be the same as Product Identifier defined in the Product Catalog Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Tag Identifier</h5>
                                        <p>User defined unique identifier for the Tag. This field needs to be the same as Tag Identifier defined in Tag Content sheet. </p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <h3>Product Specification Content</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This field needs to be the same as Product Identifier defined in the Product Catalog Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Lang Code</h5>
                                        <p>User defined field to link the product specification for a particular language. Language codes can be looked up by clicking the language option in the top header.</p>
                                    </li>
                                    <li>
                                        <h5>Specification Name</h5>
                                        <p>User defined field for product specification name.</p>
                                    </li>
                                    <li>
                                        <h5>Specification Value</h5>
                                        <p>User defined field for product specification Value.</p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <h3>Product Shipping Content</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This field needs to be the same as Product Identifier defined in the Product Catalog Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Username</h5>
                                        <p>For admin this field needs to be left blank. In case an option is added by a seller then seller username will be displayed in this field.</p>
                                    </li>
                                    <li>
                                        <h5>Shipping Country Code</h5>
                                        <p>This field needs to be the same as country code defined in Countries Content sheet. This field can be left blank if the product has no restrictions on the countries it is shipped to.</p>
                                    </li>
                                    <li>
                                        <h5>Shipping Company Identifier</h5>
                                        <p>User defined unique identifier for the Shipping company identifier. This field needs to be the same as the Shipping Company Identifier defined in the Admin console>Shipping API>Shipping Companies page. </p>
                                    </li>
                                    <li>
                                        <h5>Shipping Duration Identifier</h5>
                                        <p>User defined unique identifier for the Shipping Duration identifier. This field needs to be the same as the Shipping Duration Identifier defined in the Admin console>Shipping API>Duration Labels page. </p>
                                    </li>
                                    <li>
                                        <h5>Cost</h5>
                                        <p>User defined field for product shipping cost.</p>
                                    </li>
                                    <li>
                                        <h5>Additional Item Cost</h5>
                                        <p>User defined field for additional shipping cost per product.</p>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <h3>Product Catalog Media</h3>
                            </li>
                            <li>
                                <ul>
                                    <li>
                                        <h5>Product Identifier</h5>
                                        <p>User defined unique identifier for the Product. This field needs to be the same as Product Identifier defined in the Product Catalog Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Lang Code</h5>
                                        <p>User defined field to link the product image for a particular language. ‘Universal’ is to be used as an option to link the media in all languages. Language codes can be looked up by clicking the language option in the top header. Language codes need to be used if the Product has different images for each language.</p>
                                    </li>
                                    <li>
                                        <h5>Option Identifier</h5>
                                        <p>User defined unique identifier for the option. This field value needs to be the same as the Option Identifier defined in Options Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>Option value Identifier</h5>
                                        <p>User defined unique identifier for the option value. This field value needs to be the same as the Option value Identifier defined in Options Value Content sheet. </p>
                                    </li>
                                    <li>
                                        <h5>File Path</h5>
                                        <p>File path needs to be a publically accessible URL for example URL’s from Google Drive, Dropbox etc. Images stored locally on your personal device/machine cannot be uploaded. Preferred image dimensions for the product images are greater than 500*500 pixels.</p>
                                    </li>
                                    <li>
                                        <h5>File Name</h5>
                                        <p>Name of the image file.</p>
                                    </li>
                                    <li>
                                        <h5>Display order</h5>
                                        <p>When a product has multiple images then this field defines the order of display. If you are unsure about this field add display order as ‘1’.</p>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
				    <?php
		        break;
		    }
		}
	?>
</div>
<!-- ] -->
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Content_Block_Setup',$adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <?php
                            if( $epageData['epage_content_for'] != Extrapage::CONTENT_IMPORT_INSTRUCTION )
                            { ?>
		                        <li>
									<a href="javascript:void(0);" onclick="addBlockForm(<?php echo $epage_id ?>);">
										<?php echo Labels::getLabel('LBL_General',$adminLangId); ?>
									</a>
								</li>
                        <?php } ?>
                        <?php
                            if ( $epage_id > 0 ) {
                            	foreach( $languages as $langId => $langName ){ ?>
                        			<li>
										<a class="<?php echo ($epage_lang_id == $langId)?'active':''?>" href="javascript:void(0);" onclick="addBlockLangForm(<?php echo $epage_id ?>, <?php echo $langId;?>);">
											<?php echo Labels::getLabel('LBL_'.$langName,$adminLangId);?>
										</a>
									</li>
                        <?php 	}
                            }
                            ?>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel">
                            <?php
                                echo $blockLangFrm->getFormTag();
                                echo $blockLangFrm->getFormHtml(false);
                                echo '</form>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
