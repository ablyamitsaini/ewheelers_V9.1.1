<?php  
if( isset( $collections ) && count($collections) ){
	
	$counter = 1;
	
	foreach( $collections as $collection_id => $row ){
		
			/* category listing design [ */
			if( isset($row['shops']) && count( $row['shops'] ) ) { ?>
				<div class="section-head">
					<?php echo ($row['collection_name'] != '') ? ' <div class="section_heading">' . $row['collection_name'] .'</div>' : ''; ?>
					
					<?php if( count($row['shops']) > Collections::COLLECTION_LAYOUT4_LIMIT ){ ?>
						<div class="section_action"> <a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a> </div>
					<?php }  ?>
				</div>
			
			<?php include('shops-layout.php');  
		}
	}
}	/* ] */
			?>
		