<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body body--checkout" role="main">
 <section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 checkout--steps">
                <div class="checkout--steps__inner">
                    <!--<section class="section " id= "login"></section>-->
                    <section class="section" id ="cart-review">
                    </section>
                    <section class="section" id="payment">
                        <h3><?php echo Labels::getLabel('LBL_Make_Payment',$siteLangId); ?></h3>
                    </section>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
              <div class="order-summary">
                <div class="coupon">
                    <div class="summary-listing"></div>
                    <?php echo FatUtility::decodeHtmlEntities( nl2br($pageData['epage_content']) );?>
                </div>
              </div>
            </div>
        </div>
    </div>
 </section>
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