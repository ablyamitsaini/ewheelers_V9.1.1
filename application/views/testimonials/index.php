<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="section bg--white">
	  <div class="container">
		<div class="breadcrumbs">
		   <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
		</div>
		<section class="section">
		<div class="row">
		  <div class="col-lg-12">
			<h3><?php echo Labels::getLabel('Lbl_Testimonials',$siteLangId); ?></h3>
		  </div>
		</div>
		<div class="container--cms">
			<div class="list__all" id='listing'></div>
			<div id="loadMoreBtnDiv"></div>
			<?php echo FatUtility::createHiddenFormFromData ( array('page'=>1), array ('name' => 'frmSearchTestimonialsPaging') ); ?>
		</div>	</section>
	  </div>
	</section>
	<div class="gap"></div>
</div>
