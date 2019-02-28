<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="box__head">
   <h4><?php echo Labels::getLabel('LBL_Product_Listing',$siteLangId); ?></h4>
</div>
<div class="box__body">
	<div class="tabs tabs--small   tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		
		<div class="form__content">
			<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
		</div>

	</div>
</div>
