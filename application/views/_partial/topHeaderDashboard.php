<div class="wrapper">
	<header id="header-dashboard" class="header-dashboard no-print" role="header-dashboard">
		<div class="header-icons-group">
			<div class="c-header-icon messages">
                <?php $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false; ?>
				<a data-org-url="<?php echo CommonHelper::generateUrl('Account','Messages',array(),'',null,false,$getOrgUrl); ?>" href="<?php echo CommonHelper::generateUrl('Account','Messages'); ?>">
					<i class="icn"><svg class="svg">
							<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#message"></use>
						</svg>
					</i>
					<?php if($todayUnreadMessageCount > 0) { ?>
					<span class="h-badge"><span class="heartbit"></span><?php echo ($todayUnreadMessageCount < 9) ? $todayUnreadMessageCount : '9+' ; ?></span></a>
					<?php } ?>
			</div>
			<div class="short-links">
				<ul>
				<?php $this->includeTemplate('_partial/headerLanguageArea.php'); ?>
				<?php $this->includeTemplate('_partial/headerUserArea.php',array('isUserDashboard'=>$isUserDashboard)); ?>
				</ul>
			</div>
		</div>
	</header>
