<?php if(isset($layoutTemplate) && $layoutTemplate != ''){ ?>
<link rel="stylesheet" href="<?php echo CommonHelper::generateUrl('ThemeColor', $layoutTemplate, array($layoutRecordId));?>">
<?php }
if( isset($socialShareContent) && !empty($socialShareContent) ){ ?>
	<!-- OG Product Facebook Meta [ -->
	<meta property="og:type" content="product" />
	<meta property="og:title" content="<?php echo $socialShareContent['title']; ?>" />
	<meta property="og:site_name" content="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId,FatUtility::VAR_STRING,''); ?>" />
	<meta property="og:image" content="<?php echo $socialShareContent['image']; ?>" />
	<meta property="og:url" content="<?php echo CommonHelper::getCurrUrl(); ?>" />
	<meta property="og:description" content="<?php echo $socialShareContent['description']; ?>" />
	<!-- ]   -->

	<!--Here is the Twitter Card code for this product  -->
	<?php if (!empty(FatApp::getConfig("CONF_TWITTER_USERNAME",FatUtility::VAR_STRING,''))){ ?>
	<meta name="twitter:card" content="product">
	<meta name="twitter:site" content="@<?php echo FatApp::getConfig("CONF_TWITTER_USERNAME",FatUtility::VAR_STRING,''); ?>">
	<meta name="twitter:title" content="<?php echo $socialShareContent['title']; ?>">
	<meta name="twitter:description" content="<?php echo $socialShareContent['description']; ?>">
	<meta name="twitter:image:src" content="<?php echo $socialShareContent['image']; ?>">
	<?php }; ?>
	<!-- End Here is the Twitter Card code for this product  -->
<?php }  if(isset($includeEditor) && $includeEditor){ ?>
<script language="javascript" type="text/javascript" src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/innovaeditor.js"></script>
<script src="<?php echo CONF_WEBROOT_URL; ?>innovas/scripts/common/webfont.js" type="text/javascript"></script>
<?php  }  ?>
</head>
<?php $bodyClass='';
if($controllerName=='Blog') $bodyClass = 'is--blog';
if($controllerName=='Checkout') $bodyClass = 'is-checkout';
if(isset($isUserDashboard) && $isUserDashboard) $bodyClass = 'is-dashboard sidebar-is-reduced';
?>
<body class="<?php echo $bodyClass; ?>">
	<!--div class="pageloader">
	  <div class="round-wrapper">
		<div class="round"></div>
		<div class="round"></div>
		<div class="round"></div>
	  </div>
	</div-->

	<?php
		$alertClass = '';
		if(Message::getInfoCount()>0) $alertClass = 'alert--info';
		elseif (Message::getErrorCount()>0) $alertClass = 'alert--danger';
		elseif (Message::getMessageCount()>0) $alertClass = 'alert--success';
	?>

	<div class="system_message alert alert--positioned-top-full <?php echo $alertClass; ?>" style="display:none">
		<div class="close"></div>
		<div class="content">
			<?php
			$haveMsg = false;
			if( Message::getMessageCount() || Message::getErrorCount() || Message::getDialogCount() || Message::getInfoCount() ){
				$haveMsg = true;
				echo html_entity_decode( Message::getHtml() );
			} ?>
		</div>
	</div>
	<?php if( $haveMsg ){ ?>
	<script type="text/javascript">
		$("document").ready(function(){
			if( CONF_AUTO_CLOSE_SYSTEM_MESSAGES == 1 ){
				var time = CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000;
				setTimeout(function(){
					$.systemMessage.close();
				}, time);
			}
		});
	</script>
	<?php } ?>
