<?php 
defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset($includeEditor) && $includeEditor == true ){
	$extendEditorJs	= 'true';
}else{
	$extendEditorJs	= 'false';
}
$commonHead1Data = array( 
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
	'jsVariables'		=>	$jsVariables,
	'extendEditorJs'		=>	$extendEditorJs,
	);
$this->includeTemplate( '_partial/header/commonHead1.php', $commonHead1Data,false); 
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
/* ] */
/* This is not included in common head, because, if we are adding any css/js from any controller then that file is not included[ */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
/* ] */
	
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
$this->includeTemplate( '_partial/header/commonHead2.php', $commonHead2Data,false);
?>
<div id="wrapper">
	<div class="header-seller">
		<div class="top-head">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
						<!--<div class="seller_nav-trigger"> <a class="seller_nav_toggle" href="javascript:void(0)"><span></span></a> </div>-->
						<div class="logo"><a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo FatUtility::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
						<div class="seller-login-trigger hide--desktop"> <a class="seller_login_toggle" href="javascript:void(0)"></a> </div>
						<?php $this->includeTemplate( '_partial/affiliate/affiliateHeaderLoginForm.php',$loginData,false); ?>
					</div>
				</div>
		</div>
	</div>
</div>