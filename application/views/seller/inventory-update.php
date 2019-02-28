<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header content-header row justify-content-between mb-3">
		<div class="col-md-auto">
						<h2 class="content-header-title"><?php echo Labels::getLabel('Lbl_Update_Products_Inventory',$siteLangId);?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header p-3">
				<h5 class="cards-title "><?php echo Labels::getLabel('Lbl_Update_Products_Inventory',$siteLangId);?></h5>
			</div>
			<div class="cards-content p-3">
        <div id="productInventory">
           <?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
         </div>
			</div>
		</div>
	</div>
  </div>
</main>
