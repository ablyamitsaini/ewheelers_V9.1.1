<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
//$_SESSION['geo_location'] = true;	
if( $controllerName != 'GuestUser' && $controllerName != 'Error' ){
	$_SESSION['referer_page_url'] = CommonHelper::getCurrUrl(); 
} 
?><!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
<style>
	:root {
		--first-color:#<?php echo $themeDetail['tcolor_first_color']; ?>;
		--second-color:#<?php echo $themeDetail['tcolor_second_color']; ?>;
		--third-color:#<?php echo $themeDetail['tcolor_third_color']; ?>;
		--txt-color:#<?php echo $themeDetail['tcolor_text_color']; ?>;
		--txt-color-light:#<?php echo $themeDetail['tcolor_text_light_color']; ?>;
		--border-color:#<?php echo $themeDetail['tcolor_border_first_color']; ?>;
		--border-color-second:#<?php echo $themeDetail['tcolor_border_second_color']; ?>;
		--second-btn-color:#<?php echo $themeDetail['tcolor_second_btn_color']; ?>;
		--header-txt-color:#<?php echo $themeDetail['tcolor_header_text_color']; ?>;
	}
</style>
<meta charset="utf-8">
<meta name="author" content="">
<!-- Mobile Specific Metas ===================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<!-- favicon ================================================== -->

<!--<link rel="shortcut icon" href="">-->
<link rel="shortcut icon" href="<?php echo CommonHelper::generateUrl('Image','favicon', array($siteLangId)); ?>">
<link rel="apple-touch-icon" href="<?php echo CommonHelper::generateUrl('Image','appleTouchIcon', array($siteLangId)); ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo CONF_WEBROOT_URL; ?>images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo CONF_WEBROOT_URL; ?>images/apple-touch-icon-114x114.png">
<link rel="canonical" href="<?php echo CommonHelper::generateFullUrl($controllerName,FatApp::getAction(),!empty(FatApp::getParameters())?FatApp::getParameters():array());?>" /> 
<?php 


echo $str = '<script type="text/javascript">
		var langLbl = ' . json_encode(
			$jsVariables 
		) . ';
		var CONF_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 0) . ';
		var CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = ' . FatApp::getConfig("CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES", FatUtility::VAR_INT, 3) . ';
		var extendEditorJs = ' . $extendEditorJs . ';
		var themeActive = ' . $themeActive . ';
		var currencySymbolLeft = "' . $currencySymbolLeft . '";
		var currencySymbolRight = "' . $currencySymbolRight . '";
		if( CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES <= 0  ){
			CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = 3;
		}
	</script>' . "\r\n";
?>