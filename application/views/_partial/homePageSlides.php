<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<section class="yk-slides">
	<?php foreach($slides as $slide){
		$desktop_url = '';
		$tablet_url = '';
		$mobile_url = '';
		$haveUrl = ( $slide['slide_url'] != '' ) ? true : false;
		
		$slideArr = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_HOME_PAGE_BANNER, $slide['slide_id'], 0, $siteLangId );	
		
		// CommonHelper::printArray($att);
		if( !$slideArr ){
			/* echo $slide['slide_id']; */
			/* die('image not found'); */
			continue;
		}else{
			foreach($slideArr as $slideScreen){
				
				switch($slideScreen['afile_screen']){
					case applicationConstants::SCREEN_MOBILE:
						$mobile_url = '<736:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Image','slide',array($slide['slide_id'], applicationConstants::SCREEN_MOBILE, $siteLangId)),CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
					case applicationConstants::SCREEN_IPAD:
						$tablet_url = ' >768:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Image','slide',array($slide['slide_id'], applicationConstants::SCREEN_IPAD, $siteLangId)),
						CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
					case applicationConstants::SCREEN_DESKTOP:
						$desktop_url = ' >1025:' .FatCache::getCachedUrl(CommonHelper::generateUrl('Image','slide',array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP, $siteLangId)),CONF_IMG_CACHE_TIME, '.jpg').",";
						break;
				}
			}
		}
	
		$out = '<div class="item">';
		if($haveUrl){
			if($slide['promotion_id']>0){
				$slideUrl =  CommonHelper::generateUrl('slides','track',array($slide['slide_id']));
			}else{
				$slideUrl = CommonHelper::processUrlString($slide['slide_url']);
			}
		}
		if( $haveUrl ){ $out .= '<a target="'.$slide['slide_target'].'" href="'.$slideUrl.'">'; }
		$out .= '<img data-src-base="" data-src-base2x="" data-src="' . $mobile_url . $tablet_url  . $desktop_url . '" title="'.$slide['slide_title'].'" src="' . FatCache::getCachedUrl(CommonHelper::generateUrl('Image','slide',array($slide['slide_id'], applicationConstants::SCREEN_DESKTOP,$siteLangId)),CONF_IMG_CACHE_TIME, '.jpg') . '" alt="'.$slide['slide_title'].'" />';
		if( $haveUrl ){ $out .= '</a>'; }
		$out .= '</div>';
		echo $out;
		if(isset($slide['promotion_id']) && $slide['promotion_id']>0){
			Promotion::updateImpressionData($slide['promotion_id']);
		}			
	} ?>
</section>