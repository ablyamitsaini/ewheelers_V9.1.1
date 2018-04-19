<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$mediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');

$fld1 = $mediaFrm->getField('banner_image');	
$fld1->addFieldTagAttribute('class','btn btn--primary btn--sm');

$preferredDimensionsStr = '<span class="uploadimage--info" >'.Labels::getLabel('LBL_Preferred_Dimensions_are',$adminLangId) .' Width : '.$bannerWidth . 'px & Height : ' . $bannerHeight . 'px .</span>';

$htmlAfterField = $preferredDimensionsStr; 
if( !empty($bannerImgArr) ){
	$htmlAfterField .= '<ul class="image-listing">';
	foreach($bannerImgArr as $bannerImg){
	$htmlAfterField .= '<li>'.$bannerTypeArr[$bannerImg['afile_lang_id']].'<br>'.$screenTypeArr[$bannerImg['afile_screen']].'<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Banner','Thumb',array($bannerImg['afile_record_id'],$bannerImg['afile_lang_id']),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeBanner('.$blocation_id.','.$bannerImg['afile_record_id'].','.$bannerImg['afile_lang_id'].','.$bannerImg['afile_screen'].')" class="remove--img"><i class="ion-close-round"></i></a></div>';
	}
	$htmlAfterField.='</li></ul>';
}
$fld1->htmlAfterField = $htmlAfterField;
?>
<div class="col-sm-12">
	<h1><?php echo Labels::getLabel('LBL_Banner_Image',$adminLangId); ?></h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="slideForm(<?php echo $slide_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php 
			$inactive = ($slide_id == 0)?'fat-inactive':'';	
			foreach($languages as $langId=>$langName){ ?>
				<li class="<?php echo $inactive; ?>"><a href="javascript:void(0);" 
				<?php if( $slide_id > 0 ){ ?> onclick="slideLangForm(<?php echo $slide_id ?>, <?php echo $langId;?>);" <?php }?>>
				<?php echo $langName;?></a></li>
			<?php } ?>
			<li><a class="active" href="javascript:void(0)" <?php if( $slide_id > 0 ){ ?> onclick="slideMediaForm(<?php echo $slide_id ?>);"<?php }?>><?php echo Labels::getLabel('LBL_Media',$adminLangId); ?></a></li>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $mediaFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>	
</div>