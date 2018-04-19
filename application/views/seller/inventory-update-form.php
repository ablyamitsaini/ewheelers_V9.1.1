<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmImportExportSettings');
//$frm->setFormTagAttribute('class','form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 8;
$fld = $frm->getField('csvfile');	
$fld->addFieldTagAttribute('class','btn btn--secondary btn--sm');
$fld->htmlAfterField = ' <a class = "btn btn--primary btn--sm" href="'.CommonHelper::generateUrl('seller','exportInventory').'">'.Labels::getLabel('LBL_Export_CSV_File',$siteLangId).'</a>';
echo $frm->getFormHtml();