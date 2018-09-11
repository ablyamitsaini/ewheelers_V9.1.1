<div class="box__head">
	<h4><?php echo Labels::getLabel('LBL_Product_Listing',$siteLangId); ?></h4>
</div>
<div class="box__body">
	<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		<div class="form__content">
			<div class="col-md-12">
				<?php require_once('sellerProductSeoTop.php');?>

				<div class="form__subcontent">
					<?php
					$productSeoForm->setFormTagAttribute('class', 'form form--horizontal');
					$productSeoForm->setFormTagAttribute('onsubmit', 'setupProductMetaTag(this); return(false);');
					$productSeoForm->developerTags['colClassPrefix'] = 'col-lg-8 col-md-8 col-sm-';
					$productSeoForm->developerTags['fld_default_col'] = 8;

					//$customProductFrm->getField('option_name')->setFieldTagAttribute('class','mini');
					echo $productSeoForm->getFormHtml();
					?>
				</div>
			</div>
		</div>
	</div>
</div>
