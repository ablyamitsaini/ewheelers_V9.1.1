<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$collectionMediaFrm->setFormTagAttribute('class', 'web_form');
$collectionMediaFrm->developerTags['colClassPrefix'] = 'col-sm-';
$collectionMediaFrm->developerTags['fld_default_col'] = 6;

$collectionImageHeadingFld = $collectionMediaFrm->getField('collection_image_heading');
$collectionImageHeadingFld->developerTags['col'] = 12;
$collectionImageHeadingFld->value = '<h2>'.Labels::getLabel('LBL_Collection_Image_Management',$adminLangId).'</h2>';

$collectionImageDisplayDiv = $collectionMediaFrm->getField('collection_image_display_div');
$collectionImageDisplayDiv->developerTags['col'] = 12;


$collectionBgImageHeadingFld = $collectionMediaFrm->getField('collection_bg_image_heading');
$collectionBgImageHeadingFld->developerTags['col'] = 12;
$collectionBgImageHeadingFld->value = '<br/><br/><h2>'.Labels::getLabel('LBL_Collection_Background_Image_Management(If_any)',$adminLangId).'</h2>';

$collectionBgImageDisplayDiv = $collectionMediaFrm->getField('collection_bg_image_display_div');
$collectionBgImageDisplayDiv->developerTags['col'] = 12;

/* collection Images [ */
$imagesHtml = '<div class="row" style="border-bottom:solid 1px #ddd;">Universal<img src="'.CommonHelper::generateUrl('image','collectionReal',array( $collection_id,0, 'THUMB'),CONF_WEBROOT_FRONT_URL).'">';

if( AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_IMAGE, $collection_id, 0, 0, 0 ) ){
	$imagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionImage('.$collection_id.', '. 0 .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
}
$imagesHtml .= '</div>';

foreach( $languages as $langId => $langName ){
	$imagesHtml .= '<div class="row" style="border-bottom:solid 1px #ddd;">'.$langName;
	$imagesHtml .= '<img src="'.CommonHelper::generateUrl('image','collectionReal',array( $collection_id, $langId, 'THUMB'),CONF_WEBROOT_FRONT_URL).'">';

	if( AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_IMAGE, $collection_id, 0, $langId, false ) ){
		$imagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionImage('.$collection_id.', '. $langId .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
	}
	$imagesHtml .= '</div>';
}
$collectionImageDisplayDiv->value = $imagesHtml;
/* ] */


/* collection BG Images[ */
$bgImagesHtml = '<div class="row" style="border-bottom:solid 1px #ddd;">Universal<img src="'.CommonHelper::generateUrl('image','collectionBgReal',array( $collection_id, 0, 'THUMB'),CONF_WEBROOT_FRONT_URL).'">';

if( AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_BG_IMAGE, $collection_id, 0, 0, 0 ) ){
	$bgImagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionBGImage('.$collection_id.', '. 0 .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
}
$bgImagesHtml .= '</div>';

foreach( $languages as $langId => $langName ){
	$bgImagesHtml .= '<div class="row" style="border-bottom:solid 1px #ddd;">'.$langName;
	$bgImagesHtml .= '<img src="'.CommonHelper::generateUrl('image','collectionBgReal',array( $collection_id, $langId, 'THUMB'),CONF_WEBROOT_FRONT_URL).'">';

	if( AttachedFile::getAttachment( AttachedFile::FILETYPE_COLLECTION_BG_IMAGE, $collection_id, 0, $langId, false ) ){
		$bgImagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionBGImage('.$collection_id.', '. $langId .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
	}
	$bgImagesHtml .= '</div>';
}
$collectionBgImageDisplayDiv->value = $bgImagesHtml;
/* ] */



/* $collectionMediaFrm->setFormTagAttribute('id', 'collectionFrm');
$collectionMediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');

$fld = $collectionMediaFrm->getField('collection_image');
$fld->addFieldTagAttribute('class','btn btn--primary btn--sm');
if( isset($collectionImages) && !empty($collectionImages) ){
	$fld->htmlAfterField = '<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Image','Collection',array($collection_id,'THUMB'),CONF_WEBROOT_FRONT_URL).'"> <a href="javascript:void(0);" onClick="removeCollectionImage('.$collection_id.')" class="remove--img" ><i class="ion-close-round"></i></a></div>';
}

$fld = $collectionMediaFrm->getField('collection_bg_image');
$fld->addFieldTagAttribute('class','btn btn--primary btn--sm');
if( isset($collectionBgImages) && !empty($collectionBgImages) ){
	$fld->htmlAfterField = '<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('Image','CollectionBg',array($collection_id,'THUMB'),CONF_WEBROOT_FRONT_URL).'"> <a href="javascript:void(0);" onClick="removeCollectionBGImage('.$collection_id.')" class="remove--img" ><i class="ion-close-round"></i></a></div>';
} */

$collectionMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$collectionMediaFrm->developerTags['fld_default_col'] = 12;

?>
<section class="section">
	<div class="sectionhead">

		<h4><?php echo Labels::getLabel('LBL_Collection_Media_Setup',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">	<div class="col-sm-12">
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="editCollectionForm(<?php echo $collection_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php
			$inactive=($collection_id==0)?'fat-inactive':'';
			foreach($languages as $langId=>$langName){?>
				<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($collection_id>0){?> onclick="editCollectionLangForm(<?php echo $collection_id ?>, <?php echo $langId;?>);" <?php }?>><?php echo $langName;?></a></li>
			<?php } ?>
			<li><a class="active" href="javascript:void(0)" onclick="collectionMediaForm(<?php echo $collection_id ?>);"><?php echo Labels::getLabel('LBL_Media',$adminLangId); ?></a></li>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $collectionMediaFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var FILETYPE_COLLECTION_IMAGE = '<?php echo AttachedFile::FILETYPE_COLLECTION_IMAGE ?>';
	var FILETYPE_COLLECTION_BG_IMAGE = '<?php echo AttachedFile::FILETYPE_COLLECTION_BG_IMAGE ?>';
</script>
