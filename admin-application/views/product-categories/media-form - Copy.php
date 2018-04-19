<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$prodCatMediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$prodCatMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$prodCatMediaFrm->developerTags['fld_default_col'] = 6;

$catImageHeadingFld = $prodCatMediaFrm->getField('cat_image_heading');	
$catImageHeadingFld->developerTags['col'] = 12;
$catImageHeadingFld->value = '<h2>'. Labels::getLabel('LBL_Category_Image_Management', $adminLangId) .'</h2>';

$catIconHeadingFld = $prodCatMediaFrm->getField('cat_icon_heading');	
$catIconHeadingFld->developerTags['col'] = 12;
$catIconHeadingFld->value = '<br/><br/><h2>'. Labels::getLabel('LBL_Category_Icon_Management', $adminLangId) .'</h2>';

$catBannerHeadingFld = $prodCatMediaFrm->getField('cat_banner_heading');	
$catBannerHeadingFld->developerTags['col'] = 12;
$catBannerHeadingFld->value = '<br/><br/><h2>'. Labels::getLabel('LBL_Category_Banner_Management', $adminLangId) .'</h2>';

foreach( $languages as $lang_id => $lang_name ){
	/* Category Image fld [ */
	$catImageFld = $prodCatMediaFrm->getField('cat_image_'.$lang_id);	
	$catImageFld->developerTags['col'] = 4;
	$catImageFld->addFieldTagAttribute('class','btn btn--primary btn--sm');
	$catImageFld->htmlAfterField = ' <br/><span class="uploadimage--info">This will be displayed in 268x202 on Home Page Collections, while displaying categories.</span>';
	
	$cat_image_display_div = $prodCatMediaFrm->getField('cat_image_display_div_'.$lang_id);
	$cat_image_display_div->value = '<div class="uploaded--image"><img src="'.CommonHelper::generateUrl('Category','image',array($prodcat_id,$lang_id,'THUMB?'.time()),CONF_WEBROOT_FRONT_URL).'"></div><br/>';
	
	if( AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_IMAGE, $prodcat_id, 0, $lang_id ) && $canEdit ){
		$cat_image_display_div->htmlAfterField = '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCatImage('.$prodcat_id.', '. $lang_id .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
	}
	/* ] */
	
	/* Category Icon fld [ */
	$catIconFld = $prodCatMediaFrm->getField('cat_icon_'.$lang_id);	
	$catIconFld->developerTags['col'] = 4;
	$catIconFld->addFieldTagAttribute('class','btn btn--primary btn--sm');
	$catIconFld->htmlAfterField = ' <br/><span class="uploadimage--info">This will be displayed in 60x60 on your store.</span>';
	
	$cat_icon_display_div = $prodCatMediaFrm->getField('cat_icon_display_div_'.$lang_id);
	$cat_icon_display_div->value = '<div class="uploaded--image"><img src="'.CommonHelper::generateUrl('Category','icon',array($prodcat_id,$lang_id,'THUMB?'.time()),CONF_WEBROOT_FRONT_URL).'"></div><br/>';
	
	if( AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_ICON, $prodcat_id, 0, $lang_id ) && $canEdit ){
		$cat_icon_display_div->htmlAfterField = '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCatIcon('.$prodcat_id.', '. $lang_id .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
	}
	/* ] */
	
	/* Category Banner fld [ */
	$catBannerFld = $prodCatMediaFrm->getField('cat_banner_'.$lang_id);	
	$catBannerFld->developerTags['col'] = 4;
	$catBannerFld->addFieldTagAttribute('class','btn btn--primary btn--sm');
	$catBannerFld->htmlAfterField = ' <br/><span class="uploadimage--info">Preferred Dimesnion: Width = 1050PX, Height = 340PX</span>';
	
	$cat_banner_display_div = $prodCatMediaFrm->getField('cat_banner_display_div_'.$lang_id);
	$cat_banner_display_div->value = '<div class="uploaded--image"><img src="'.CommonHelper::generateUrl('Category','banner',array($prodcat_id,$lang_id,'THUMB?'.time()),CONF_WEBROOT_FRONT_URL).'"></div><br/>';
	
	if( AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $prodcat_id, 0, $lang_id ) && $canEdit ){
		$cat_banner_display_div->htmlAfterField = '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCatBanner('.$prodcat_id.', '. $lang_id .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
	}
	/* ] */
}


// $prodCatMediaFrm->setFormTagAttribute('id', 'prodCate');
// $prodCatMediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');

/* [ */
// $cat_image_fld = $prodCatMediaFrm->getField('cat_image');
// $cat_image_fld->addFieldTagAttribute('class','btn btn--primary btn--sm');
// $htmlAfterField = '<span class="uploadimage--info">This will be displayed in 268x202 on Home Page Collections, while displaying categories.</span>';
// if( isset($catImages) && !empty($catImages) ){
	// $htmlAfterField .= '
	// <div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Category','image',array($prodcat_id,'THUMB'),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeCatImage('.$prodcat_id.')" class="remove--img"><i class="ion-close-round"></i></a></div>';
// }
// $cat_image_fld->htmlAfterField = $htmlAfterField;
/* ] */


/* [ */
// $fld = $prodCatMediaFrm->getField('cat_icon');	
// $fld->addFieldTagAttribute('class','btn btn--primary btn--sm');
// $htmlAfterField = '<span class="uploadimage--info">This will be displayed in 60x60 on your store.</span>';

// if( isset($catIcons) && !empty($catIcons) ){
	// $htmlAfterField .= '
	// <div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Category','icon',array($prodcat_id,'THUMB'),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeCatIcon('.$prodcat_id.')" class="remove--img"><i class="ion-close-round"></i></a></div>';
// }
// $fld->htmlAfterField = $htmlAfterField;
/* ] */

/* [ */
// $fld1 = $prodCatMediaFrm->getField('cat_banner');	
// $fld1->addFieldTagAttribute('class','btn btn--primary btn--sm');
// $htmlAfterField = '<span class="uploadimage--info">Preferred Dimesnion: Width = 1050PX, Height = 340PX</span>'; 
// if( isset($catBanners) && !empty($catBanners) ){
	// $htmlAfterField .= '<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Category','banner',array($prodcat_id,'THUMB'),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeCatBanner('.$prodcat_id.')" class="remove--img"><i class="ion-close-round"></i></a></div>';
// }
// $fld1->htmlAfterField = $htmlAfterField;
/* ] */
?>
<div class="col-sm-12">
	<h1>Product Category Media Setup</h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0);" onclick="categoryForm(<?php echo $prodcat_id ?>);">General</a></li>
			<?php 
			if ($prodcat_id > 0) {
				foreach($languages as $langId=>$langName){?>
					<li><a href="javascript:void(0);" onclick="categoryLangForm(<?php echo $prodcat_id ?>, <?php echo $langId;?>);"><?php echo $langName;?></a></li>
				<?php }
				}
			?>
			<li><a class="active" href="javascript:void(0);" <?php if($prodcat_id>0){?> onclick="categoryMediaForm(<?php echo $prodcat_id ?>);" <?php }?>>Media</a></li>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $prodCatMediaFrm->getFormHtml(); ?>
				<?php //echo $prodCatMediaFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>	
</div>
