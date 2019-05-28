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

<div class="backto"><a href="#">Shop Yo!Kart <svg class="icn-arrow" x="0px" y="0px" viewBox="0 0 31.49 31.49" style="enable-background:new 0 0 31.49 31.49;" xml:space="preserve" width="512px" height="512px">
	<path d="M21.205,5.007c-0.429-0.444-1.143-0.444-1.587,0c-0.429,0.429-0.429,1.143,0,1.571l8.047,8.047H1.111  C0.492,14.626,0,15.118,0,15.737c0,0.619,0.492,1.127,1.111,1.127h26.554l-8.047,8.032c-0.429,0.444-0.429,1.159,0,1.587  c0.444,0.444,1.159,0.444,1.587,0l9.952-9.952c0.444-0.429,0.444-1.143,0-1.571L21.205,5.007z" />
</svg></a></div>

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
