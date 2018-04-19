<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$imagesFrm->setFormTagAttribute('id', 'frmCustomProductImage');
$img_fld = $imagesFrm->getField('prod_image');
$img_fld->setFieldTagAttribute( 'onchange','setupCustomProductImages(); return false;');
?>

<div class="popup-title">
  <h3><?php echo Labels::getLabel('LBL_Product_Images', $siteLangId); ?></h3>
</div>
<div class="divider"> </div>
<?php 
		$imagesFrm->developerTags['colClassPrefix'] = 'col-md-';
		$imagesFrm->developerTags['fld_default_col'] = 6;
	echo $imagesFrm->getFormHtml(); ?>
<div class="row">
<div class="col-lg-12 col-md-12">
  <div id="imageupload_div">
    
  </div>
  </li>
</div>