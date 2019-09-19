<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
//$_SESSION['geo_location'] = true;
if ($controllerName != 'GuestUser' && $controllerName != 'Error') {
    $_SESSION['referer_page_url'] = CommonHelper::getCurrUrl();
}
$htmlClass = '';
$actionName = FatApp::getAction();
if ($controllerName == 'Products' && $actionName == 'view') {
	$htmlClass = 'product-view';
}
?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" class="<?php echo $htmlClass;?>">
<head>

    <meta charset="utf-8">
    <meta name="author" content="">
    <!-- Mobile Specific Metas ===================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <!-- favicon ================================================== -->

    <!--<link rel="shortcut icon" href="">-->
    <link rel="shortcut icon" href="<?php echo CommonHelper::generateUrl('Image', 'favicon', array($siteLangId)); ?>">
    <link rel="apple-touch-icon" href="<?php echo CommonHelper::generateUrl('Image', 'appleTouchIcon', array($siteLangId)); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo CommonHelper::generateUrl('Image', 'appleTouchIcon', array($siteLangId,'MINI')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo CommonHelper::generateUrl('Image', 'appleTouchIcon', array($siteLangId,'SMALL')); ?>">

    <?php
    if ($canonicalUrl == '') {
        $canonicalUrl = CommonHelper::generateFullUrl($controllerName, FatApp::getAction(), !empty(FatApp::getParameters())?FatApp::getParameters():array());
    }
    ?>
    <link rel="canonical" href="<?php echo $canonicalUrl;?>" />
    
