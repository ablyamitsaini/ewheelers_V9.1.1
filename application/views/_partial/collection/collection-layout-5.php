<?php  
if( isset( $collections ) && count($collections) ){
	
	$counter = 1;
	
	foreach( $collections as $collection_id => $row ){ 	/* category listing design [ */
			if( isset($row['categories']) && count( $row['categories'] ) ) { ?>

		<div class="padd40"> <?php echo ($row['collection_name'] != '') ? ' <div class="unique-heading-sub">' . $row['collection_name'] .'</div>' : ''; ?>
		  <div class="trending-list">
			<ul>
			  <?php $i=0; foreach( $row['categories'] as $category ){	?>
			  <li> <a href="<?php echo CommonHelper::generateUrl('Category', 'View', array($category['prodcat_id'] )); ?>"> <i class="svg"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('Category', 'Icon', array($category['prodcat_id'] , $siteLangId, 'collection_page')), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt= "<?php echo $category['prodcat_name']; ?> " title= "<?php echo $category['prodcat_name']; ?> "></i><span class="caption"><?php echo $category['prodcat_name']; ?></span> </a> </li>
			  <?php 
				$i++;
				/* if($i==Collections::COLLECTION_LAYOUT5_LIMIT) break;*/ }  ?>
			</ul>
			<?php if( count($row['categories']) > Collections::COLLECTION_LAYOUT5_LIMIT ){ ?>
				<a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a>
			<?php }  ?>
		  </div>
		</div>
		<?php } 
		}
}
?>
