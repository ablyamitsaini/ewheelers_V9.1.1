<?php 
if(isset($includeEditor) && $includeEditor){ ?>

<script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
<script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>
<?php  }  ?></head>
<body class="<?php echo $bodyClass;?>">
<?php /* if (FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 1) && CommonHelper::demoUrl()) {  */
	//$this->includeTemplate('restore-system/top-header.php');
/* } */ ?>
<div class="page-container"></div>
