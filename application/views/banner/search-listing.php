<?php 
if(!empty($bannerListing)){
	foreach($bannerListing as $val){
		?>
		<div class="grids__item"><a href="<?php echo $val['banner_url'];?>" target="<?php echo $val['banner_target'];?>" title="<?php echo $val['banner_title'];?>" class="advertise__block"><img src="<?php echo CommonHelper::generateUrl('Banner','SearchPage',array($val['banner_id'],$siteLangId));?>" alt="<?php echo $val['banner_title'];?>"></a></div>	
		<?php
	}
}
?>

