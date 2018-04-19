	<thead>
				<tr>
				<td colspan="2" class="nopadding"><table id="shipping" class="table">
		<thead>
		<tr>
		<th width="17%"><?php echo Labels::getLabel('LBL_Ships_To',$siteLangId)?></th>
		<th width="17%"><?php echo Labels::getLabel('LBL_Shipping_Company',$siteLangId)?></th>
		<th width="17%"><?php echo Labels::getLabel('LBL_Processing_Time',$siteLangId)?></th>
		<th width="25%"><?php echo Labels::getLabel('LBL_Cost',$siteLangId) .' ['.commonHelper::getDefaultCurrencySymbol().']';?></th>
		<th width="20%"><?php echo Labels::getLabel('LBL_Each_Additional_Item',$siteLangId).' ['.commonHelper::getDefaultCurrencySymbol().']';?> </th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
			if(!empty($shipping_rates) && count($shipping_rates)>0){
			$shipping_row = 0;
			foreach ($shipping_rates as $shipping) { ?>
				 
				<tr id="shipping-row<?php echo $shipping_row; ?>">
				<td><input type="hidden" name="product_shipping[<?php echo $shipping_row; ?>][pship_id]" value="<?php echo $shipping['pship_id']; ?>" />
				<input type="text" name="product_shipping[<?php echo $shipping_row; ?>][country_name]" value="<?php echo $shipping["pship_country"]!="-1"?$shipping["country_name"]:"&#8594;".Labels::getLabel('LBL_EveryWhere_Else',$siteLangId);?>" placeholder="<?php echo Labels::getLabel('LBL_Shipping',$siteLangId)?>" /><input type="hidden" name="product_shipping[<?php echo $shipping_row; ?>][country_id]" value="<?php echo $shipping["pship_country"]?>" /></td>
				<td>
				<input type="text" name="product_shipping[<?php echo $shipping_row; ?>][company_name]" value="<?php echo isset($shipping["scompany_name"]) ? $shipping["scompany_name"] : ''; ?>" placeholder="<?php echo Labels::getLabel('LBL_Company',$siteLangId)?>" /><input type="hidden" name="product_shipping[<?php echo $shipping_row; ?>][company_id]" value="<?php echo $shipping["pship_company"]?>" /></td>
				<td>
				<input type="text" name="product_shipping[<?php echo $shipping_row; ?>][processing_time]" value="<?php echo isset($shipping['sduration_days_or_weeks']) ? ShippingDurations::getShippingDurationTitle($shipping,$siteLangId) : ''?>" placeholder="<?php echo Labels::getLabel('LBL_Processing_Time',$siteLangId)?>" /><input type="hidden" name="product_shipping[<?php echo $shipping_row; ?>][processing_time_id]" value="<?php echo isset($shipping['pship_duration']) ? $shipping['pship_duration'] : ''?>" /></td>
				<td><input type="text" name="product_shipping[<?php echo $shipping_row; ?>][cost]" value="<?php echo isset($shipping["pship_charges"]) ? $shipping["pship_charges"] : '';?>" placeholder="<?php echo Labels::getLabel('LBL_Cost',$siteLangId)?>" /></td>
				<td>
				<input type="text" name="product_shipping[<?php echo $shipping_row; ?>][additional_cost]" value="<?php echo isset($shipping["pship_additional_charges"]) ? $shipping["pship_additional_charges"] : ''; ?>" placeholder="<?php echo Labels::getLabel('LBL_Each_Additional_Item',$siteLangId)?>" /></td>
				<td><button type="button" onclick="$('#shipping-row<?php echo $shipping_row; ?>').remove();" class="btn btn--secondary ripplelink" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId)?>"  ><i class="fa fa-minus"></i></button>
				<!--<a class="button red medium" onclick="$('#shipping-row<?php echo $shipping_row; ?>').remove();"  title="Remove">Remove</a>--></td>
				</tr>
		<?php $shipping_row++; ?>
		<?php }
			} else { $shipping_row = 1; ?>
				<input type="hidden" name="product_shipping[0][pship_id]" value="" />
				<tr id="shipping-row0">
				<td>
				<input type="text" name="product_shipping[0][country_name]" value="" placeholder="<?php echo Labels::getLabel('LBL_Ships_To',$siteLangId)?>" /><input type="hidden" name="product_shipping[0][country_id]" value="" /></td>
				<td>
				<input type="text" name="product_shipping[0][company_name]" value="" placeholder="<?php echo Labels::getLabel('LBL_Shipping_Company',$siteLangId)?>" /><input type="hidden" name="product_shipping[0][company_id]" value="" /></td>
				<td>
				<input type="text" name="product_shipping[0][processing_time]" value="" placeholder="<?php echo Labels::getLabel('LBL_Processing_Time',$siteLangId)?>" /><input type="hidden" name="product_shipping[0][processing_time_id]" value="" /></td>
				<td><input type="text" name="product_shipping[0][cost]" value="" placeholder="<?php echo Labels::getLabel('LBL_Cost',$siteLangId)?>" /></td>
				<td>
				<input type="text" name="product_shipping[0][additional_cost]" value="" placeholder="<?php echo Labels::getLabel('LBL_Each_Additional_Item',$siteLangId)?>" /></td>
				<td></tr>
			<?php } ?>
		</tbody>
		<tfoot>
		<tr>
		<td colspan="5"></td>
		<td ><button type="button" class="btn btn--secondary ripplelink" title="<?php echo Labels::getLabel('LBL_Shipping',$siteLangId)?>" onclick="addShipping();" ><i class="fa fa-plus"></i></button></td>
		</tr>
		</tfoot>
		<script >
		var shipping_row = <?php echo $shipping_row;?>;
		addShipping = function(){
		
			html  = '<tr id="shipping-row' + shipping_row + '">';
			html += '  <td><input type="text" name="product_shipping[' + shipping_row + '][country_name]" value="" placeholder="<?php echo Labels::getLabel('LBL_Ships_To',$siteLangId)?>" /><input type="hidden" name="product_shipping[' + shipping_row + '][country_id]" value="" /></td>';
			html += '  <td><input type="text" name="product_shipping[' + shipping_row + '][company_name]" value="" placeholder="<?php echo Labels::getLabel('LBL_Shipping_Company',$siteLangId)?>" /><input type="hidden" name="product_shipping[' + shipping_row + '][company_id]" value="" /></td>';
			html += '  <td><input type="text" name="product_shipping[' + shipping_row + '][processing_time]" value="" placeholder="<?php echo Labels::getLabel('LBL_Processing_Time',$siteLangId)?>" /><input type="hidden" name="product_shipping[' + shipping_row + '][processing_time_id]" value="" /></td>';
			html += '  <td>';
			html += '<input type="text" name="product_shipping[' + shipping_row + '][cost]" value="" placeholder="<?php echo Labels::getLabel('LBL_Cost',$siteLangId)?>" />';
			html += '</td>';
			html += '<td>';
			html += '<input type="text" name="product_shipping[' + shipping_row + '][additional_cost]" value="" placeholder="<?php echo Labels::getLabel('LBL_Each_Additional_Item',$siteLangId)?>" />';
			html += '</td>';
			html += '  <td><button type="button" class="btn btn--secondary ripplelink" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId)?>" onclick="$(\'#shipping-row' + shipping_row + '\').remove();" ><i class="fa fa-minus"></i></button></td>';
			html += '</tr>';
			$('#shipping tbody').append(html);
			shippingautocomplete(shipping_row);
			shipping_row++;
			
	}	

	$('#shipping tbody tr').each(function(index, element) {
		shippingautocomplete(index);
	});
		</script>