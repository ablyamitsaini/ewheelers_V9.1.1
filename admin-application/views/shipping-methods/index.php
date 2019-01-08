<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>

<div class='page'>
	<div class='container container-fluid'>
		<div class="row">
			<div class="col-lg-12 col-md-12 space">
				<div class="page__title">
					<div class="row">
						<div class="col--first col-lg-6">
							<span class="page__icon">
							<i class="ion-android-star"></i></span>
							<h5><?php echo Labels::getLabel('LBL_Manage_Shipping_Methods',$adminLangId); ?> </h5>
							<?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
						</div>
					</div>
				</div>              
				<section class="section">
					<div class="sectionhead">
						<h4><?php echo Labels::getLabel('LBL_Shipping_Methods_List',$adminLangId); ?> </h4>
					</div>
					<div class="sectionbody">
						<div class="tablewrap">
							<div id="sMethodListing">
								<?php echo Labels::getLabel('LBL_Processing...',$adminLangId); ?>
							</div>
						</div>
					</div>
				</section>
		 
			</div>
		</div>
	</div>
</div>