<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="wrapper">
  <div class="header-checkout">
    <div class="container">
        <div class="header-checkout-inner">
        <div class="logo zoomIn"> <a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a> </div>
      <div class="right-info">
        <?php echo FatUtility::decodeHtmlEntities( $headerData['epage_content'] );?>
      </div>
    </div>
</div>
  </div>
  <div class="after-header"></div>
