<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmImportExportSettings');
//$frm->setFormTagAttribute('class','form');
$frm->developerTags['colClassPrefix'] = 'col-lg-8 col-md-8 col-sm-';
$frm->developerTags['fld_default_col'] = 8;
$fld = $frm->getField('csvfile');
$fld->developerTags['noCaptionTag'] = true;
$fld->addFieldTagAttribute('class','btn btn--primary');
$fld->htmlAfterField = ' <a class = "btn btn--primary-border" href="'.CommonHelper::generateUrl('seller','exportInventory').'">'.Labels::getLabel('LBL_Export_CSV_File',$siteLangId).'</a>';
echo $frm->getFormHtml();
