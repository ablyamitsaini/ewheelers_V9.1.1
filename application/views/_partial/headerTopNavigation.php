<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php if($top_header_navigation && count($top_header_navigation) ){ ?>
	<?php foreach($top_header_navigation as $nav){ ?>
		<?php if( $nav['pages'] ){
			foreach( $nav['pages'] as $link ){
					$navUrl = CommonHelper::getnavigationUrl( $link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'] ); ?>
					<li><a target="<?php echo $link['nlink_target']; ?>" href="<?php echo $navUrl;?>"><?php echo $link['nlink_caption']; ?></a></li>
				<?php }
			}
		 }
	} ?>
