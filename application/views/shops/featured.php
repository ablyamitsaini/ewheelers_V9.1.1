<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	<div class="bg--second pt-3 pb-3">
      <div class="container container--fixed">
        <div class="row align-items-center">
          <div class="col-md-8">
                <h1><?php echo Labels::getLabel('Lbl_Featured_Shops' , $siteLangId); ?></h1>
          </div>
          <div class="col-md-4 align--right"></div>
        </div>
      </div>
    </div>
    


	<section class="section">
		<div class="container">
			
			<div id="listing"> </div>
			<div id="loadMoreBtnDiv"></div>
		</div>
	</section>
</div>
<?php echo $searchForm->getFormHtml();?>
