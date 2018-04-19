<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
 <div id="body" class="body">
    <div class="fixed-container">
      <div class="row ">
        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
          <!--<section class="section " id= "login"></section>-->
          <section class="section " id ="review">

          </section>
          <section class="section" id="payment">
            <div class="section-head">2. <?php echo Labels::getLabel('LBL_Make_Payment',$siteLangId); ?></div>
          </section>
		  <div class="gap"></div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
          <div class="order-summary">
			<div class="coupon">
				<div class="summary-listing"></div>
				<?php echo FatUtility::decodeHtmlEntities( nl2br($pageData['epage_content']) );?>
			</div>
          </div>
        </div>
      </div>
    </div>
    <div class="gap"></div>
  </div>
<script type="text/javascript">
$("document").ready(function(){	
	$(document).on("click",".toggle--collapseable-js",function(e){	
		var prodgroup_id = $(this).attr('data-prodgroup_id');
		$(this).toggleClass("is--active");
		$("#prodgroup_id_" + prodgroup_id ).slideToggle();
	});
});
</script>