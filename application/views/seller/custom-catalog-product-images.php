<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$imagesFrm->setFormTagAttribute('id', 'frmCustomCatalogProductImage');
$imagesFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$imagesFrm->developerTags['fld_default_col'] = 12;
$optionFld = $imagesFrm->getField('option_id');	
$optionFld->addFieldTagAttribute('class','option-js');
$langFld = $imagesFrm->getField('lang_id');	
$langFld->addFieldTagAttribute('class','language-js');
$img_fld = $imagesFrm->getField('prod_image');
$img_fld->setFieldTagAttribute( 'onchange','setupCustomCatalogProductImages(); return false;');
?>

<?php if($displayLinkNavigation == true){?>
<div class="tabs tabs--small   tabs--scroll clearfix">
	<?php require_once(CONF_THEME_PATH.'seller/seller-custom-catalog-product-top.php');?>
</div>
<?php }?>
<div class="tabs__content form">		
	<div class="form__content">
		<div class="col-md-12">
			<?php if($displayLinkNavigation == true){?>
			 
				<div class="tabs tabs-sm tabs--scroll clearfix">
					<ul>
						<li><a onClick="customCatalogProductForm(<?php echo $preqId;?>,<?php echo $preqCatId;?>)" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Basic', $siteLangId );?></a></li>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSellerProductForm( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Inventory/Info', $siteLangId );?></a></li>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSpecifications( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId );?></a></li>
						<?php foreach($languages as $langId=>$langName){?>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductLangForm( ".$preqId.",".$langId." );'" : ""; ?>><?php echo $langName;?></a></li>				
						<?php } ?>
						<?php if(!empty($productOptions)){?>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customEanUpcForm( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_EAN/UPC_setup', $siteLangId );?></a></li>
						<?php } ?>
						<li class="is-active"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductImages( ".$preqId." );'" : ""; ?>><?php echo Labels::getLabel('Lbl_Product_Images',$siteLangId);?></a></li>
					</ul>	
				</div>
			 
			<?php }?>
			<div class="form__subcontent">
			  <?php 
				$imagesFrm->developerTags['colClassPrefix'] = 'col-md-';
				$imagesFrm->developerTags['fld_default_col'] = 6;
				echo $imagesFrm->getFormHtml(); 
				?>
				<div class="col-lg-12 col-md-12">
				  <div id="imageupload_div">							
				  </div>						  
				</div>
		</div>
	</div>
</div>
</div>