<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="cards-header p-3">
	<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Product_Setup',$siteLangId); ?></h5>
</div>
<div class="cards-content p-3">
	<div class="tabs tabs--small   tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		<div class="form__content">
			<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
		</div>
	</div>
</div>
