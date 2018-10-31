<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if( !empty( $footer_navigation ) ){ ?>
		<?php foreach( $footer_navigation as $nav ){ ?>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			  <div class="f-links">
					<h3><?php echo $nav['parent']; ?></h3>
					<ul>
						<?php if( $nav['pages'] ){
							$getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;
							foreach( $nav['pages'] as $link ){
								$navUrl = CommonHelper::getnavigationUrl( $link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'] );
								$OrgnavUrl = CommonHelper::getnavigationUrl( $link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'], $getOrgUrl ); ?>
								<li><a target="<?php echo $link['nlink_target']; ?>" data-org-url="<?php echo $OrgnavUrl; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a></li>
							<?php }
						} ?>
					</ul>
				</div>
			</div>
	<?php } ?>
<?php } ?>
