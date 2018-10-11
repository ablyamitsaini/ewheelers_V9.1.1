<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$bCount = 1; 

if( $bannerLayout1['blocation_active']){ ?>
 <section class="banners clearfix">
	<?php foreach($bannerLayout1['banners'] as $val){
		if($bCount%2==0)
		{
			$bannerClass="banners_right";
		}
		else
		{
			$bannerClass="banners_left";
		}
		$desktop_url = '';
		$tablet_url = '';
		$mobile_url = '';
		
		if( !AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId ) ){
			continue;
		}else{
			$slideArr = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId );
			foreach($slideArr as $slideScreen){
				switch($slideScreen['afile_screen']){
					case applicationConstants::SCREEN_MOBILE:
						$mobile_url = '<480:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterFirstLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
					case applicationConstants::SCREEN_IPAD:
						$tablet_url = ' <768:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterFirstLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)).','.'  <1024:' .CommonHelper::generateUrl('Banner','HomePageAfterFirstLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)), CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
					case applicationConstants::SCREEN_DESKTOP:
						$desktop_url = ' >1024:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterFirstLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)), CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
				}
			}
		}
	
		if($val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC){
			Promotion::updateImpressionData($val['banner_record_id']);	
		}/* else{
			Banner::updateImpressionData($val['banner_id']);
		} */
	?>
	<div class="<?php echo $bannerClass;?>"> <a  target="<?php echo $val['banner_target'];?>" href="<?php echo CommonHelper::generateUrl('Banner','url',array($val['banner_id']));?>" title="<?php echo $val['banner_title'];?>"><img data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url . $tablet_url  . $desktop_url; ?>" src="<?php echo CommonHelper::generateUrl('Banner','HomePageAfterFirstLayout',array($val['banner_id'],$siteLangId,applicationConstants::SCREEN_DESKTOP));?>" alt="<?php echo $val['banner_title'];?>"> </a> </div>
<?php $bCount++; } ?>
	</section>
<?php } 	?>
<section class="clearfix"></section>
<script>
/* alert($( window ).width()); */
</script>