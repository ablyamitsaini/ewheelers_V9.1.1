<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">

	<div class="section section--pagebar">
      <div class="container container--fixed">
        <div class="row align-items-center">
          <div class="col-md-8">
                <h1><?php echo Labels::getLabel('Lbl_Testimonials',$siteLangId); ?></h1>
                <div class="breadcrumbs">
				   <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
				</div>
          <div class="col-md-4 align--right"></div>
        </div>
      </div>
    </div>
    </div>



	<section class="section bg--white">
	  <div class="container">
		<div class="container--cms">
			<div class="list__all" id='listing'></div>
			<div id="loadMoreBtnDiv"></div>
			<?php echo FatUtility::createHiddenFormFromData ( array('page'=>1), array ('name' => 'frmSearchTestimonialsPaging') ); ?>
		</div>	
	  </div>
	</section>
	<div class="gap"></div>
</div>
