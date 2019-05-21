<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>
<?php require_once(CONF_THEME_PATH.'_partial/seller/customProductNavigationLinks.php'); ?>
<div class="cards-content pl-4 pr-4 ">
<div class="tabs tabs--small tabs--scroll clearfix">
	<?php require_once(CONF_THEME_PATH.'seller/sellerCustomProductTop.php');?>
</div>
<div class="tabs__content">
	<div class="form__content row">
	  <div class="col-md-12">
		<?php
			$customProductOptionFrm->setFormTagAttribute('class', 'form form--horizontal');
			$customProductOptionFrm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-';
			$customProductOptionFrm->developerTags['fld_default_col'] = 6;
			$fld1=$customProductOptionFrm->getField('option_name');

			$fld = $customProductOptionFrm->getField('product_name');
			$fld->setWrapperAttribute('class','col-lg-12');
			$fld->developerTags['col'] = 12;
			/* $fld1->fieldWrapper = array('<div class="row">', '</div>'); */
			echo $customProductOptionFrm->getFormHtml();
		?>
	  </div>
	</div>
</div>
</div>
<script>
	$('input[name=\'option_name\']').autocomplete({
		'source': function(request, response) {

			$.ajax({
				url: fcom.makeUrl('seller', 'autoCompleteOptions'),
				data: {keyword: request,fIsAjax:1},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {

						return {
							label: item['name'] + ' (' + item['option_identifier'] + ')',
							value: item['id']
							};
					}));
				},
			});
		},
		'select': function(item) {

			updateProductOption(<?php echo $product_id;?>,item['value']);

		}
	});
</script>
