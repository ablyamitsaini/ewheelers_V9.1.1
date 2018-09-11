<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>
<?php require_once(CONF_THEME_PATH.'_partial/seller/customProductNavigationLinks.php'); ?>

<div class="box__body">
  <div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
    <?php require_once('sellerCustomProductTop.php');?>
  </div>
  <div class="tabs__content">
    <div class="form__content row ">
      <div class="col-md-12">
        <?php
			$customProductOptionFrm->setFormTagAttribute('class', 'form form--horizontal');
			$customProductOptionFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
			$customProductOptionFrm->developerTags['fld_default_col'] = 12;
			echo $customProductOptionFrm->getFormHtml();
		?>
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
</div>
