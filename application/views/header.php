<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

if (isset($includeEditor) && $includeEditor == true) {
    $extendEditorJs = 'true';
} else {
    $extendEditorJs = 'false';
}

if (CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'])) {
    $themeActive = 'true';
} else {
    $themeActive = 'false';
}

array_walk($jsVariables, function (&$item1, $key) {
    $item1 = html_entity_decode($item1, ENT_QUOTES, 'UTF-8');
});
$commonHead1Data = array(
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'canonicalUrl' => isset($canonicalUrl)?$canonicalUrl:'',
);

$this->includeTemplate('_partial/header/commonHead1.php', $commonHead1Data, false);
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
/* ] */
?>
<style>
    :root {
        --first-color: #<?php echo $themeDetail['tcolor_first_color']; ?>;
        --second-color: #<?php echo $themeDetail['tcolor_second_color']; ?>;
        --third-color: #<?php echo $themeDetail['tcolor_third_color']; ?>;
        --txt-color: #<?php echo $themeDetail['tcolor_text_color']; ?>;
        --txt-color-light: #<?php echo $themeDetail['tcolor_text_light_color']; ?>;
        --border-color: #<?php echo $themeDetail['tcolor_border_first_color']; ?>;
        --border-color-second: #<?php echo $themeDetail['tcolor_border_second_color'];?>;
        --second-btn-color: #<?php echo $themeDetail['tcolor_second_btn_color'];  ?>;
        --header-txt-color: #<?php echo $themeDetail['tcolor_header_text_color']; ?>;
        --body-color: #525252;
        --gray-light: #f8f8f8;
    }
</style>
<?php
echo $str = '<script type="text/javascript">
    var langLbl = ' . json_encode($jsVariables) . ';
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

if (FatApp::getConfig("CONF_ENABLE_ENGAGESPOT_PUSH_NOTIFICATION", FatUtility::VAR_STRING, '')) {
    echo FatApp::getConfig("CONF_ENGAGESPOT_PUSH_NOTIFICATION_CODE", FatUtility::VAR_STRING, '');
    if (UserAuthentication::getLoggedUserId(true) > 0) { ?>
        <script type="text/javascript">
            Engagespot.init()
            Engagespot.identifyUser('YT_<?php echo UserAuthentication::getLoggedUserId(); ?>');
        </script>
        <?php
    }
}
?>
<?php
/* This is not included in common head, because, if we are adding any css/js from any controller then that file is not included[ */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
/* ] */

$commonHead2Data = array(
    'siteLangId' => $siteLangId,
    'controllerName' => $controllerName,
    'action' => $action,
    'isUserDashboard' => $isUserDashboard,
);
if (isset($layoutTemplate) && $layoutTemplate != '') {
    $commonHead2Data['layoutTemplate'] = $layoutTemplate;
    $commonHead2Data['layoutRecordId'] = $layoutRecordId;
}
if (isset($socialShareContent) && $socialShareContent != '') {
    $commonHead2Data['socialShareContent'] = $socialShareContent;
}
if (isset($includeEditor) && $includeEditor == true) {
    $commonHead2Data['includeEditor'] = $includeEditor;
}
$this->includeTemplate('_partial/header/commonHead2.php', $commonHead2Data, false);

if (isset($isUserDashboard) && $isUserDashboard) {
    $this->includeTemplate('_partial/topHeaderDashboard.php', $commonHead2Data, false);
    $exculdeMainHeaderDiv = true;
}

if (!isset($exculdeMainHeaderDiv)) {
    $this->includeTemplate('_partial/topHeader.php', array('siteLangId'=>$siteLangId), false);
}

if (!$isAppUser) {
    $controllerName = strtolower($controllerName);
    switch ($controllerName) {
        case 'checkout':
        case 'walletpay':
        case 'subscriptioncheckout':
            $this->includeTemplate('_partial/header/checkout-header.php', array('siteLangId'=>$siteLangId,'headerData'=>$headerData,'controllerName'=>$controllerName), false);
            break;
    }
}
