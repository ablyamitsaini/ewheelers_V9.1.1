<?php
defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frmProduct->setFormTagAttribute('class', 'web_form form_horizontal');
$frmProduct->developerTags['colClassPrefix'] = 'col-md-';
$frmProduct->developerTags['fld_default_col'] = 12; 
?>

<section class="section">
	<div class="sectionhead">

		<h4><?php echo Labels::getLabel('LBL_Coupon_Setup',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">	

<div class="col-sm-12">
	<h1><?php //echo Labels::getLabel('LBL_Coupon_Setup',$adminLangId);?></h1>
	<div class="tabs_nav_container responsive flat" style='min-height:380px;'>
		<ul class="tabs_nav">
			<li><a class="active" href="javascript:void(0)" onclick="couponLinkProductForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Products',$adminLangId);?></a></li>
			<li><a href="javascript:void(0)" onclick="couponLinkCategoryForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Categories',$adminLangId);?></a></li>
			<li><a href="javascript:void(0)" onclick="couponLinkUserForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Users',$adminLangId);?></a></li>
		</ul>
		
		<div class="tabs_panel_wrap" >
			<div class="tabs_panel">
				<?php echo $frmProduct->getFormHtml(); ?>
				<div id="coupon_products_list" class="col-xs-9 box--scroller"></div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</section>
<script type="text/javascript">
$("document").ready(function(){
	
	reloadCouponProduct(<?php echo $coupon_id; ?>);
	
	$('input[name=\'product_name\']').autocomplete({
		'source': function(request, response) {			
			$.ajax({
				url: fcom.makeUrl('Products', 'autoComplete'),
				data: {keyword: request,fIsAjax:1},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'],	value: item['id']	};
					}));
				},
			});
		},
		'select': function(item) {
			updateCouponProduct(<?php echo $coupon_id; ?>, item['value'] );
		}
	});
	
});
</script>