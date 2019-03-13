<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header  row justify-content-between mb-3">
		<div class="content-header-left col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Seller_Options',$siteLangId); ?></h2>
		</div>
	</div>

  <div class="content-body">
		<div class="cards">
      <div class="cards-header p-3">
                        <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Manage_Seller_Options',$siteLangId); ?></h5>
                        <div class="action"><a href="#modal-popup" class="modaal-inline-content link" onclick="optionForm(0)"><?php echo Labels::getLabel('LBL_Add_Option',$siteLangId);?></a></div>
      </div>
      <div class="cards-content p-3">
           <div id="optionListing"></div></div>
		</div>
	</div>


  </div>
</main>
