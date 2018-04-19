<?php  
if( isset( $sponsoredShops ) && count($sponsoredShops) ){
	
	
	
	
			/* category listing design [ */
			if( isset($sponsoredShops['shops']) && count( $sponsoredShops['shops'] ) ) {

					$row ['shops']	= $sponsoredShops['shops'] ;	
					$row ['rating']	= $sponsoredShops['rating'] ;	
					$track = true;
					?>
				<div class="section-head">
					 <div class="section_heading"><?php echo FatApp::getConfig('CONF_PPC_SHOPS_HOME_PAGE_CAPTION_'.$siteLangId,FatUtility::VAR_STRING,Labels::getLabel('LBL_SPONSORED_SHOPS',$siteLangId));?></div>
					
				</div>
				
<?php  include('shops-layout.php');  	/* ] */
			}	
	
}	?>
		