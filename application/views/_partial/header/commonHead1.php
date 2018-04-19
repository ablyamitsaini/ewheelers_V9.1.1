<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
//$_SESSION['geo_location'] = true;	
if( $controllerName != 'GuestUser' && $controllerName != 'Error' ){
	$_SESSION['referer_page_url'] = CommonHelper::getCurrUrl(); 
} 
?><!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
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
		if( CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES <= 0  ){
			CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES = 3;
		}
	</script>' . "\r\n";
?>