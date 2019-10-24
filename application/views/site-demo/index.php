<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<style>
	<?php include(CONF_THEME_PATH.'site-demo/page-css/index.css');
	?>
</style>

<div class="PageContainer">
	<main role="main" id="main">
		<div class="device-preview">
			<div class="device-preview__container"><iframe class="device-preview__iframe" src="<?php echo CommonHelper::generateFullUrl(); ?>" scrolling="yes" frameborder="0" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
				</iframe></div>
		</div>
	</main>
</div>