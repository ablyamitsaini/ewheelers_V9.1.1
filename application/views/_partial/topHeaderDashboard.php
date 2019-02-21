<div class="wrapper">
	<header id="header-dashboard" class="header-dashboard no-print" role="header-dashboard">
		<div class="header-icons-group">
			<div class="c-header-icon messages">
				<a href="#">
					<i class="icn"><svg class="svg">
							<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message"></use>
						</svg>
					</i>
					<span class="h-badge"><span class="heartbit"></span>5</span></a>
			</div>
			<?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
			<?php $this->includeTemplate('_partial/headerUserArea.php',array('controllerName'=>$controllerName)); ?>
		</div>
	</header>







