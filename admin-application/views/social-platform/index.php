<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class='page'>
	<div class='container container-fluid'>
		<div class="row">
			<div class="col-lg-12 col-md-12 space">
				<div class="page__title">
					<div class="row">
						<div class="col--first col-lg-6">
							<span class="page__icon"><i class="ion-android-star"></i></span>
							<h5><?php echo Labels::getLabel('LBL_Manage_Social_Platforms',$adminLangId); ?> </h5>
							<?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
						</div>
					</div>
				</div>

<!--<div class="row">
	<div class="col-sm-12"> -->
		<h1><?php //echo Labels::getLabel('LBL_Manage_Social_Platforms',$adminLangId); ?> </h1>			
		<section class="section" id="listing">  <?php echo Labels::getLabel('LBL_Processing....',$adminLangId); ?> 	</section>
	</div>		
</div>
</div></div>
