<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="box__head">
	<h4><?php echo Labels::getLabel('LBL_Product_Listing',$siteLangId); ?></h4>
</div>
<div class="box__body">	
	<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		
		<div class="form__content">
			
			<div class="form__subcontent">
				<?php
				$sellerproductLinkFrm->setFormTagAttribute('onsubmit','setUpSellerProductLinks(this); return(false);');
				$sellerproductLinkFrm->setFormTagAttribute('class','form form--horizontal');
				$sellerproductLinkFrm->developerTags['colClassPrefix'] = 'col-md-';
				$sellerproductLinkFrm->developerTags['fld_default_col'] = 8;
				echo $sellerproductLinkFrm->getFormHtml(); ?>
			</div>	
		</div>	
		
	</div>
</div>

<script type="text/javascript">
$("document").ready(function(){
	$('input[name=\'products_buy_together\']').autocomplete({
		'source': function(request, response) {
			/* fcom.ajax(fcom.makeUrl('brands', 'autoComplete'), {keyword:encodeURIComponent(request)}, function(json) {
				response($.map(json, function(item) {
						return { label: item['name'],	value: item['id']	};
					}));
			}); */
			$.ajax({
				url: fcom.makeUrl('seller', 'autoCompleteProducts'),
				data: {keyword:request,fIsAjax:1,selprod_id:selprod_id},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'] +'['+item['product_identifier'] +']',	value: item['id']	};
					}));
				},
			});
		},
		'select': function(item) {
			$('input[name=\'products_buy_together\']').val('');
			$('#productBuyTogether' + item['value']).remove();
			$('#buy-together-products').append('<li id="productBuyTogether' + item['value'] + '"><i class="remove_buyTogether remove_param fa fa-remove"></i> ' +item['label'] + '<input type="hidden" name="product_upsell[]" value="' + item['value'] + '" /></li>');
		}
	});
	$('#buy-together-products').delegate('.remove_buyTogether', 'click', function() {
	
		$(this).parent().remove();
	});
	$('input[name=\'products_related\']').autocomplete({
		'source': function(request, response) {
			/* fcom.ajax(fcom.makeUrl('brands', 'autoComplete'), {keyword:encodeURIComponent(request)}, function(json) {
				response($.map(json, function(item) {
						return { label: item['name'],	value: item['id']	};
					}));
			}); */
			$.ajax({
				url: fcom.makeUrl('seller', 'autoCompleteProducts'),
				data: {keyword: request,fIsAjax:1,selprod_id:selprod_id},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'] +'['+item['product_identifier'] +']',	value: item['id']	};
					}));
				},
			});
		},
		'select': function(item) {
			$('input[name=\'products_related\']').val('');
			$('#productRelated' + item['value']).remove();
			$('#related-products').append('<li id="productRelated' + item['value'] + '"><i class="remove_related remove_param fa fa-remove"></i> ' +item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></li>');
		}
	});
	$('#related-products').delegate('.remove_related', 'click', function() {
	
		$(this).parent().remove();
	});
	<?php foreach($upsellProducts as $key => $val){
		
		?>
	
       	$('#buy-together-products').append("<li id=\"productBuyTogether<?php echo $val['selprod_id'];?>\"><i class=\"remove_buyTogether remove_param fa fa-remove\"></i><?php echo $val['product_name'];?>[<?php echo $val['product_identifier'];?>]<input type=\"hidden\" name=\"product_upsell[]\" value=\"<?php echo $val['selprod_id'];?>\" /></li>");
    <?php } 
	foreach($relatedProducts as $key => $val){
		
		?>
	
       	$('#related-products').append("<li id=\"productRelated<?php echo $val['selprod_id'];?>\"><i class=\"remove_related remove_param fa fa-remove\"></i><?php echo $val['product_name'];?>[<?php echo $val['product_identifier'];?>]<input type=\"hidden\" name=\"product_related[]\" value=\"<?php echo $val['selprod_id'];?>\" /></li>");
    <?php } ?>
});
</script>