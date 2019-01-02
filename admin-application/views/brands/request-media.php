<?php 
defined('SYSTEM_INIT') or die('Invalid Usage.');
$brandMediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$brandMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$brandMediaFrm->developerTags['fld_default_col'] = 12; 	
$fld2 = $brandMediaFrm->getField('logo');	
$fld2->addFieldTagAttribute('class','btn btn--primary btn--sm');
$idFld = $brandMediaFrm->getField('brand_id');	
$idFld->addFieldTagAttribute('id','id-js');
$langFld = $brandMediaFrm->getField('brand_lang_id');	
$langFld->addFieldTagAttribute('class','language-js');

$preferredDimensionsStr = '<small class="text--small">'.sprintf(Labels::getLabel('LBL_Preferred_Dimesions',$adminLangId),'192*82').'</small>';

$htmlAfterField = $preferredDimensionsStr; 
$htmlAfterField .= '<div id="image-listing"></div>';
$fld2->htmlAfterField = $htmlAfterField;
?>

<section class="section">
	<div class="sectionhead">

		<h4><?php echo Labels::getLabel('LBL_Product_Brand_setup',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">	
<div class="col-sm-12">
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="brandRequestForm(<?php echo $brand_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php 
			$inactive = ( $brand_id == 0 ) ? 'fat-inactive' : '';	
			foreach($languages as $langId=>$langName){?>
				<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($brand_id>0){?> onclick="brandRequestLangForm(<?php echo $brand_id ?>, <?php echo $langId;?>);" <?php }?>><?php echo labels::getlabel("LBL_".$langName,$adminLangId);?></a></li>
			<?php } ?>
			<li><a class="active" href="javascript:void(0)" onclick="brandRequestMediaForm(<?php echo $brand_id ?>);"><?php echo Labels::getLabel('LBL_Media',$adminLangId); ?></a></li>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $brandMediaFrm->getFormHtml(); ?>			
			</div>
		</div>
	</div>
</div>
