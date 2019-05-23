<div class="logo"><a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>

<div class="main-search">
	<a href="javascript:void(0)" class="toggle--search toggle--search-js"> <span class="icn"></span></a>
	<div class="form--search form--search-popup">
		<a id="close-search-popup-js" class="close-layer d-xl-none d-lg-none" href="javascript:void(0)"></a>
		<form name="frmSiteSearch" method="post" id="frm_fat_id_frmSiteSearch" class="main-search-form" autocomplete="off" onsubmit="submitSiteSearch(this); return(false);">			 
			<input class="search--keyword search--keyword--js no--focus" placeholder="What are you looking for..." id="header_search_keyword" onkeyup="animation(this)" title="What are you looking for..." data-fatreq="{&quot;required&quot;:false}" type="text" name="keyword" value="" autocomplete="off">	
			
							<input title="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="category" value="">			<input class="search--btn submit--js" title="" data-fatreq="{&quot;required&quot;:false}" type="submit" name="btnSiteSrchSubmit" value="Search">		</form>
		 	</div>
</div>

<div class="backto"><a href="#">Shop Yo!Kart</a></div>

<?php if(!empty($categoriesArr)){ /* CommonHelper::printArray($categoriesArr); die; */
	$noOfCharAllowedInNav = 60;
	$navLinkCount = 0;
	foreach( $categoriesArr as $cat ){
		if( !$cat ){ break;}
		$noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen($cat);
		if($noOfCharAllowedInNav < 0){
			break;
		}
		$navLinkCount++;
	} ?>
 
 

 
<?php }?>
