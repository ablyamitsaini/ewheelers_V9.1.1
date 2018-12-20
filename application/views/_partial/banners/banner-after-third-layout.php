<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
$bCount = 1; 

if(isset($bannerLayout2) && $bannerLayout2['blocation_active']){ ?>
	
	<?php foreach($bannerLayout2['banners'] as $val){
		if($bCount > $bannerLayout2['blocation_banner_count']){ 
			break; 
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
						$mobile_url = '<736:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterThirdLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
					case applicationConstants::SCREEN_IPAD:
						$tablet_url = ' >768:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterThirdLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD))).",";
						break;
					case applicationConstants::SCREEN_DESKTOP:
						$desktop_url = ' >1025:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Banner','HomePageAfterThirdLayout',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)), CONF_IMG_CACHE_TIME, '.jpg').",";
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
	<div class="store-banner"> <a  target="<?php echo $val['banner_target'];?>" href="<?php echo CommonHelper::generateUrl('Banner','url',array($val['banner_id']));?>" title="<?php echo $val['banner_title'];?>"><img data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url . $tablet_url . $desktop_url; ?>" src="<?php echo CommonHelper::generateUrl('Banner','HomePageAfterThirdLayout',array($val['banner_id'],$siteLangId,applicationConstants::SCREEN_DESKTOP));?>" alt="<?php echo $val['banner_title'];?>"> </a> </div>
		 <!--<div class="store-banner" style="background-image:url(<?php echo CommonHelper::generateUrl('Banner','HomePageAfterThirdLayout',array($val['banner_id'],$siteLangId));?>)"></div>
      <div></div>-->						
	
<?php $bCount++; } ?>

<?php } ?>