<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset($includeEditor) && $includeEditor == true ){
	$extendEditorJs	= 'true';
}else{
	$extendEditorJs	= 'false';
}
$commonHead1Data = array(
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
	'jsVariables'		=>	$jsVariables,
	'extendEditorJs'	=>	$extendEditorJs,
	);
$this->includeTemplate( '_partial/header/commonHead1.php', $commonHead1Data,false); 
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
/* ] */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
	
$commonHead2Data = array(
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
);
	
if( isset($layoutTemplate) && $layoutTemplate != '' ){
	$commonHead2Data['layoutTemplate']	= $layoutTemplate;
	$commonHead2Data['layoutRecordId']	= $layoutRecordId;
}
if( isset($socialShareContent) && $socialShareContent != '' ){
	$commonHead2Data['socialShareContent']	= $socialShareContent;
}
$this->includeTemplate('_partial/header/commonHead2.php', $commonHead2Data,false);
?>

<div id="wrapper">
  <div class="header-seller" id="header">
	<div class="top_bar">
	  <div class="fixed-container">
		<div class="row">
		  <div class="col-lg-6 col-xs-6 hide--mobile ">
			<div class="slogan"><?php echo Labels::getLabel('L_Instant_Multi_Vendor_eCommerce_System_Builder',$siteLangId); ?></div>
		  </div>
		  <div class="col-lg-6 col-xs-12">
			<div class="short-links">
			  <ul>
				<?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
			  </ul>
			</div>
		  </div>
		</div>
	  </div>
	</div>
    <div class="top-head">
      <div class="fixed-container">
        <div class="row">
          <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
            <?php if(!empty($seller_navigation_left)) { ?>
				<div class="seller_nav-trigger"> <a class="seller_nav_toggle" href="javascript:void(0)"><span></span></a> </div>
			<?php }?>
            <div class="logo header-login-logo zoomIn"> <a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
          </div>
          <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 yk-login--wrapper">
			<div class="seller-login-trigger hide--desktop"> <a class="seller_login_toggle" href="javascript:void(0)"></a> </div>
             <?php $this->includeTemplate( '_partial/seller/sellerHeaderLoginForm.php',$loginData,false); ?>
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
      </div>
    </div>
    <div class="bottom-head">
      <div class="fixed-container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="short-nav">
              <?php $this->includeTemplate( '_partial/seller/sellerNavigationLeft.php'); ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="short-nav align--right hide--mobile hide--tab">
              <?php $this->includeTemplate( '_partial/seller/sellerNavigationRight.php'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>