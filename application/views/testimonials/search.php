<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( !empty($list) ){
	foreach( $list as $listItem ){ 
	//CommonHelper::printArray($listItem);
	?>
	<div class="row testimonial-blocks">
	  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 from">
	  <img src="<?php echo CommonHelper::generateFullUrl('Image','testimonial',array($listItem['testimonial_id'],0,'THUMB')); ?>" class="avatar" alt="<?php echo $listItem['testimonial_user_name'];?>">
		<div class="name"> <?php echo $listItem['testimonial_user_name']; ?> <!--<span> Gurgaon, India </span>--></div>
	  </div>
	  <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 description"> <?php echo $listItem['testimonial_text']; ?></div>
	</div>
<?php }
} else {
	echo 'No records';
}