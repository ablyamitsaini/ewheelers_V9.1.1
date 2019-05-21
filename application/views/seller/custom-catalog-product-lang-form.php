<?php require_once(CONF_THEME_PATH.'_partial/seller/customCatalogProductNavigationLinks.php'); ?>
<div class="cards-content pl-4 pr-4 ">
<div class="tabs__content form">
	<div class="form__content">
		<div class="col-md-12">
				<div class="tabs tabs-sm tabs--scroll clearfix">
					<ul>
						<li><a onClick="customCatalogProductForm(<?php echo $preqId;?>,<?php echo $preqCatId;?>)" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Basic', $siteLangId );?></a></li>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSellerProductForm( ".$preqId.",".$preqCatId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Inventory/Info', $siteLangId );?></a></li>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSpecifications( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId );?></a></li>
						<?php foreach($languages as $langId=>$langName){?>
						<li class="<?php if($langId == $product_lang_id) { echo 'is-active'; } ?>"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductLangForm( ".$preqId.",".$langId." );'" : ""; ?>><?php echo $langName;?></a></li>
						<?php } ?>
						<?php if(!empty($productOptions)){?>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customEanUpcForm( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_EAN/UPC_setup', $siteLangId );?></a></li>
						<?php }?>
						<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductImages( ".$preqId." );'" : ""; ?>><?php echo Labels::getLabel('Lbl_Product_Images',$siteLangId);?></a></li>
					</ul>
				</div>

			<div class="form__subcontent">
			<?php
				//$customProductLangFrm->setFormTagAttribute('onsubmit','setUpCustomSellerProductLang(this); return(false);');
				$customProductLangFrm->setFormTagAttribute('class','form form--horizontal layout--'.$formLayout);
				$customProductLangFrm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
				$customProductLangFrm->developerTags['fld_default_col'] = 4;

				$fld = $customProductLangFrm->getField('product_description');
				$fld->setWrapperAttribute('class','col-lg-8');
				$fld->developerTags['col'] = 8;
				echo $customProductLangFrm->getFormHtml(); ?>
		</div>
	</div>
</div>
</div>
</div>
