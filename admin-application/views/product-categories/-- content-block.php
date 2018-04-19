<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$blockCatFrm->setFormTagAttribute('id', 'prodCate');
$blockCatFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$blockCatFrm->setFormTagAttribute('onsubmit', 'setupCategoryBlock(this); return(false);');
?>
<div class="col-sm-12">
	<h1>Category Block Setup</h1>
	<div class="tabs_nav_container responsive flat">		
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $blockCatFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>
