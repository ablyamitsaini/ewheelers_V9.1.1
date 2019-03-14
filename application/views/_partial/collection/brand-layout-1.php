<?php  
if( isset( $collections ) && count($collections) ){
	

	$counter = 1;

	foreach( $collections as $collection_id => $row ){ 	/* brand listing design [ */
			if( isset($row['brands']) && count( $row['brands'] ) ) { ?>

		<section class="section">
			<div class="container">
				<div class="section-head  section--head--center">
				 <?php echo ($row['collection_name'] != '') ? ' <div class="section__heading">' . $row['collection_name'] .'</div>' : ''; ?>
				</div>
                <div class="trending-list">
                    <ul>
                      <?php $i=0; foreach( $row['brands'] as $brand ){	?>
                      <li> <a href="<?php echo CommonHelper::generateUrl('brands', 'View', array($brand['brand_id'] )); ?>"> <i class="svg"><img data-ratio="1:1 (500x500)" src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'brand', array($brand['brand_id'] , $siteLangId, 'collection_page')), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt= "<?php echo $brand['brand_name']; ?> " title= "<?php echo $brand['brand_name']; ?> "></i><span class="caption"><?php echo $brand['brand_name']; ?></span> </a> </li>
                      <?php
                        $i++;
                        /* if($i==Collections::COLLECTION_LAYOUT5_LIMIT) break;*/ }  ?>
                    </ul>
                    <?php if( count($row['brands']) > Collections::LIMIT_BRAND_LAYOUT1 ){ ?>
                        <a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a>
                    <?php }  ?>
                </div>
			</div>
		</section>
		<?php }
		}
}
?>
