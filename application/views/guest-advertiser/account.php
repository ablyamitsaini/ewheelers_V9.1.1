<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="after-header"></div>
<div id="body" class="body">
    <?php $haveBgImage =AttachedFile::getAttachment( AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId );
	$bgImageUrl = ($haveBgImage) ? "background-image:url(" . CommonHelper::generateUrl( 'Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, 'DEFAULT', AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE) ) . ")" : "background-image:url(".CONF_WEBROOT_URL."images/seller-bg.jpg);"; ?>
	<div  class="banner" style="<?php echo $bgImageUrl; ?>">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <div class="seller-slogan">
              <div class="seller-slogan-txt">
                <?php echo FatUtility::decodeHtmlEntities( nl2br($slogan['epage_content']) );?> 
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="seller-register-form affiliate-register-form" id="regFrmBlock">
				<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="gap"></div>
</div>
<!-- <script type="text/javascript" src="js/seller-functions.js"></script>  -->