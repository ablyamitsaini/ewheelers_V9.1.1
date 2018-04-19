<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="top-space bg--white">
	  <div class="fixed-container">
		<div class="breadcrumb">
		   <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
		</div>
		<div class="row">
		  <div class="col-lg-12">
			<div class="heading3"><?php echo Labels::getLabel('Lbl_Testimonials',$siteLangId); ?></div>
		  </div>
		</div>
		<div class="container--cms">
			<div class="list__all" id='listing'></div>
			<div id="loadMoreBtnDiv"></div>
			<?php echo FatUtility::createHiddenFormFromData ( array('page'=>1), array ('name' => 'frmSearchTestimonialsPaging') ); ?>
		</div>
	  </div>
	</section>
	<div class="gap"></div>
</div>