<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit','searchProductsInventoryStockStatus(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
$frmSrch->developerTags['fld_default_col'] = 6;

$keyFld = $frmSrch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
 ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
 <main id="main-area" class="main" role="main">
 	<div class="content-wrapper content-space">
 		<div class="content-header row justify-content-between mb-3">
 			<div class="col-md-auto">
 				<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
 				<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report',$siteLangId);?></h2>
 			</div>
 		</div>
 		<div class="content-body">
 			<div class="cards">
 				<div class="cards-header p-3">
 					<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report',$siteLangId);?></h5>
 				</div>
 				<div class="cards-content p-3">
					<div class="grids--profile">
 					 <div class="bg-gray-light p-3 pb-0"> <?php echo $frmSrch->getFormHtml(); ?> </div>

 						 
 							 <div id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?> </div>


 				 </div>
 				</div>
 			</div>
 		</div>
 	</div>
 </main>
