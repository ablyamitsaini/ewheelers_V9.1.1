<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$collectionMediaFrm->setFormTagAttribute('class', 'web_form');
$collectionMediaFrm->developerTags['colClassPrefix'] = 'col-sm-';
$collectionMediaFrm->developerTags['fld_default_col'] = 6;

$collectionImageDisplayDiv = $collectionMediaFrm->getField('collection_image_display_div');
$collectionImageDisplayDiv->developerTags['col'] = 12;

$fld = $collectionMediaFrm->getField('app_collection_image');
$preferredDimensionsStr = '<small class="text--small">'.sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $adminLangId), '640*480').'</small>';
$fld->htmlAfterField = $preferredDimensionsStr;

/* collection Images [ */
$fileType = (AttachedFile::getAttachment(AttachedFile::FILETYPE_APP_COLLECTION_IMAGE, $collection_id, 0, 0, 0)) ? AttachedFile::FILETYPE_APP_COLLECTION_IMAGE : '';
$imagesHtml = '<div class="row" style="border-bottom:solid 1px #ddd;">Universal<img src="'.CommonHelper::generateUrl('image', 'collectionReal', array( $collection_id,0, 'THUMB', $fileType), CONF_WEBROOT_FRONT_URL).'">';

if (!empty($fileType)) {
    $imagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionImage('.$collection_id.', '. 0 .')">'.Labels::getLabel('LBL_Remove', $adminLangId).'</a>';
}
$imagesHtml .= '</div>';

foreach ($languages as $langId => $langName) {
    $fileType = (AttachedFile::getAttachment(AttachedFile::FILETYPE_APP_COLLECTION_IMAGE, $collection_id, 0, $langId, false)) ? AttachedFile::FILETYPE_APP_COLLECTION_IMAGE : '';

    $imagesHtml .= '<div class="row" style="border-bottom:solid 1px #ddd;">'.$langName;
    $imagesHtml .= '<img src="'.CommonHelper::generateUrl('image', 'collectionReal', array( $collection_id, $langId, 'THUMB', $fileType), CONF_WEBROOT_FRONT_URL).'">';

    if (!empty($fileType)) {
        $imagesHtml .= '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeCollectionImage('.$collection_id.', '. $langId .')">'.Labels::getLabel('LBL_Remove', $adminLangId).'</a>';
    }
    $imagesHtml .= '</div>';
}
$collectionImageDisplayDiv->value = $imagesHtml;
/* ] */

$collectionMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$collectionMediaFrm->developerTags['fld_default_col'] = 12;

?> <section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Collection_App_Image_Management', $adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a href="javascript:void(0)" onclick="editCollectionForm(<?php echo $collection_id ?>);"><?php echo Labels::getLabel('LBL_General', $adminLangId); ?></a></li>
                        <?php $inactive=($collection_id==0)?'fat-inactive':'';
                        foreach ($languages as $langId => $langName) { ?>
                                <li class="<?php echo $inactive; ?>">
                                    <a href="javascript:void(0);"
                                    <?php if ($collection_id>0) { ?>
                                        onclick="editCollectionLangForm(<?php echo $collection_id ?>, <?php echo $langId; ?>);"
                                    <?php } ?>>
                                    <?php echo $langName; ?>
                                </a>
                                </li>
                        <?php } ?>
                            <li><a class="active" href="javascript:void(0)" onclick="collectionAppMediaForm(<?php echo $collection_id ?>);"><?php echo Labels::getLabel('LBL_App_Media', $adminLangId); ?></a></li>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel"> <?php echo $collectionMediaFrm->getFormHtml(); ?> </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                var FILETYPE_COLLECTION_IMAGE = '<?php echo AttachedFile::FILETYPE_APP_COLLECTION_IMAGE ?>';
                var APP_COLLECTION_IMAGE = 1;
            </script>
