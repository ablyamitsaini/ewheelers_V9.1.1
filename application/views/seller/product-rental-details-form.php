<div class="tabs tabs--small   tabs--scroll clearfix">
    <?php require_once('sellerCatalogProductTop.php');?>
</div>
<div class="cards">
	<div class="cards-content pt-3 pl-4 pr-4 ">		
		<div class="tabs__content form">
			<div class="row">
				<div class="col-md-12">
					<div class="form__subcontent">
						<?php
							$productRentalForm->setFormTagAttribute('class', 'form form--horizontal');
							$productRentalForm->setFormTagAttribute('onsubmit', 'setupProductRentalDetails(this); return(false);');
							$productRentalForm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
							$productRentalForm->developerTags['fld_default_col'] = 4;
							echo $productRentalForm->getFormHtml();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
