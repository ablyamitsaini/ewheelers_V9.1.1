<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">

	<div class="bg--second pt-3 pb-3">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">               
               <div class="section-head section--white--head mb-0">
            <div class="section__heading">
                  <h2 class="mb-0"><?php echo Labels::getLabel('Lbl_Testimonials',$siteLangId); ?></h2>
                <div class="breadcrumbs">
				   <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
				</div>
            </div>
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
