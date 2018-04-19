<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="after-header"></div>
<div id="body" class="body">
   <?php $haveBgImage =AttachedFile::getAttachment( AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId );
	$bgImageUrl = ($haveBgImage) ? "background-image:url(" . CommonHelper::generateUrl( 'Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, 'DEFAULT', AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE) ) . ")" : "background-image:url(".CONF_WEBROOT_URL."images/seller-bg.jpg);"; ?>
	<div  class="banner" style="<?php echo $bgImageUrl; ?>">
      <div class="fixed-container">
        <div class="row">
           <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12"> </div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			  <div class="seller-register-form" id="regFrmBlock">
				<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
			  </div>
			</div>
        </div>
      </div>
    </div>
 	<div class="gap"></div>
</div>
<?php if(!empty($postedData)) echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSellerAccount') );