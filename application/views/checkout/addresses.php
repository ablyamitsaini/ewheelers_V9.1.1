<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<h3><?php
	$heading = Labels::getLabel('LBL_Billing_Address', $siteLangId);
	if( $cartHasPhysicalProduct ){
		$heading = Labels::getLabel('LBL_Billing/Delivery_Address', $siteLangId);
	}  echo $heading; ?>
</h3>

<div id="addressWrapper" class="address-wrapper step__body">
<?php if($addresses) { ?>
	<div class="row">
	<?php foreach( $addresses as $address ){
				$selected_billing_address_id = (!$selected_billing_address_id && $address['ua_is_default']) ? $address['ua_id'] : $selected_billing_address_id; ?>
		<div class="col-lg-6 col-md-6 col-xs-12 address-<?php echo $address['ua_id'];?>">
			<label class="address <?php echo ($selected_billing_address_id == $address['ua_id']) ? 'is--selected' : ''; ?> ">
				<div class="address-inner">
					<span class="radio">
						<input <?php echo ($selected_billing_address_id == $address['ua_id']) ? 'checked="checked"' : ''; ?> name="billing_address_id" value="<?php echo $address['ua_id']; ?>" type="radio"><i class="input-helper"></i>
					</span>
					<p>
						<strong><?php echo ($address['ua_identifier'] != '') ? $address['ua_identifier'].': '.$address['ua_name'] : $address['ua_name']; ?></strong>
						<?php echo $address['ua_address1'];?><br>
						<?php echo (strlen($address['ua_address2'])>0)?$address['ua_address2'].'<br>':'';?>
						<?php echo (strlen($address['ua_city'])>0)?$address['ua_city'].',':'';?>
						<?php echo (strlen($address['state_name'])>0)?$address['state_name'].'<br>':'';?>
						<?php echo (strlen($address['country_name'])>0)?$address['country_name'].'<br>':'';?>
						<?php echo (strlen($address['ua_zip'])>0) ? Labels::getLabel('LBL_Zip:', $siteLangId).$address['ua_zip'].'<br>':'';?>
						<?php echo (strlen($address['ua_phone'])>0) ? Labels::getLabel('LBL_Phone:', $siteLangId).$address['ua_phone'].'<br>':'';?>
					</p>
					<div class="gap"></div>
					<?php if(!commonhelper::isAppUser()){ ?>
					<div class="">
						<a class="editLink action btn btn--primary btn--sm " href="javascript:void(0)" onClick="editAddress('<?php echo $address['ua_id']; ?>')"><?php echo Labels::getLabel('LBL_Edit', $siteLangId)?></a>
						<a title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId)?>" class="action btn btn--secondary btn--sm" onclick="removeAddress('<?php echo $address['ua_id']; ?>')" href="javascript:void(0)"> <?php echo Labels::getLabel('LBL_Delete', $siteLangId)?></a>
					</div>
					<?php } ?>
				</div>
			</label>
		</div>
		<?php } ?>
	</div>
	<div class="divider "></div>
<?php } ?>
	
	<div class="same-as">
		<?php if($addresses) { ?>
        <div class="same-delivery">
			<h3><?php echo Labels::getLabel('LBL_Shipping_Address', $siteLangId); ?></h3>
			<label class="checkbox">
				<input type="checkbox" <?php echo ($isShippingSameAsBilling) ? "checked='checked'" : ''; ?> name="isShippingSameAsBilling" value="1"><i class="input-helper"></i>
				<?php echo Labels::getLabel('LBL_Same_as_Billing_Address', $siteLangId); ?>
			</label>
		</div>
        <?php } ?>
		<p class="txt-where"><?php if( $cartHasPhysicalProduct ){ ?>
		<?php echo Labels::getLabel('LBL_Please_add_addresss_where_you_want_to_ship_your_product', $siteLangId);?>
		<?php }?>
		</p>
		<a onClick="showAddressFormDiv();" name="addNewAddress" class="btn btn--lg btn--primary-border ripplelink"> <?php echo Labels::getLabel('LBL_Add_New_Address', $siteLangId);?> </a>
	</div>
</div>




<?php if( $cartHasPhysicalProduct && $addresses ){ ?>
<div class="divider "></div>
<div class="address-wrapper step__body">
	<div class="row" id="shippingAddressContainer">
	  <?php foreach( $addresses as $address ){
				$selected_shipping_address_id = (!$selected_shipping_address_id && $address['ua_is_default']) ? $address['ua_id'] : $selected_shipping_address_id; ?>
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label class="address <?php echo ($selected_shipping_address_id == $address['ua_id']) ? 'is--selected' : ''; ?>">
						<div class="address-inner">
							<span class="radio">
								<input <?php echo ($selected_shipping_address_id == $address['ua_id']) ? 'checked="checked"' : ''; ?> name="shipping_address_id" value="<?php echo $address['ua_id']; ?>" type="radio"><i class="input-helper"></i>
							</span>
							<div class="address-type"><?php echo ($address['ua_identifier'] != '') ? $address['ua_identifier'].': '.$address['ua_name'] : $address['ua_name']; ?></div>

							<p><strong><?php echo $address['ua_name'];?></strong>
							<?php echo $address['ua_address1'];?><br>
							<?php echo (strlen($address['ua_address2'])>0)?$address['ua_address2'].'<br>':'';?>
							<?php echo (strlen($address['ua_city'])>0)?$address['ua_city'].',':'';?>
							<?php echo (strlen($address['state_name'])>0)?$address['state_name'].'<br>':'';?>
							<?php echo (strlen($address['country_name'])>0)?$address['country_name'].'<br>':'';?>
							<?php echo (strlen($address['ua_zip'])>0) ? Labels::getLabel('LBL_Zip:', $siteLangId).$address['ua_zip'].'<br>':'';?>
							<?php echo (strlen($address['ua_phone'])>0) ? Labels::getLabel('LBL_Phone:', $siteLangId).$address['ua_phone'].'<br>':'';?>
							</p>
							<div class="gap"></div>
							<div class="">
								<a class="editLink action btn btn--primary btn--sm " href="javascript:void(0)" onClick="editAddress('<?php echo $address['ua_id']; ?>')"><?php echo Labels::getLabel('LBL_Edit', $siteLangId)?></a>
								<a title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId)?>" class="action btn btn--secondary btn--sm" onclick="removeAddress('<?php echo $address['ua_id']; ?>')" href="javascript:void(0)"> <?php echo Labels::getLabel('LBL_Delete', $siteLangId)?></a>
							</div>
				
						</div>
					</label>
				</div>
	  <?php } ?>
	</div>	
	<?php if($addresses) { ?>
	<div class="row"><div class="col-md-12 text-right">
		<a href="javascript:void(0)" onClick="setUpAddressSelection(this);" class="btn btn--primary"><?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?></a>
	</div> </div> 	<div class="gap"></div>

	<?php } ?>
	</div>
<?php } ?>

<div id="addressFormDiv" style="display:none">
<?php $tplDataArr = array(
		'siteLangId' => $siteLangId,
		'addressFrm' => $addressFrm,
		'labelHeading' => Labels::getLabel('LBL_Add_New_Address', $siteLangId),
		'stateId'	=>	$stateId,
	); ?>
<?php $this->includeTemplate( 'checkout/address-form.php', $tplDataArr,false);    ?>
</div>

<script type="text/javascript">

	$("input[name='isShippingSameAsBilling']").change(function(){

		if( $(this).is(":checked") ){

			$("#shippingAddressContainer").hide();


			var billing_address_id = $("input[name=billing_address_id]:checked").val();
			if( billing_address_id ){
				$("input[name='shipping_address_id']").each(function(){
					$(this).removeAttr("checked");
				});

				$("input[name='shipping_address_id']").each(function(){
					if( $(this).val() == billing_address_id ){
						$(this).parent().parent().trigger("click");
						//$(this).attr( "checked", true );
					}
				});
			}
		} else {

			$("#shippingAddressContainer").show();
		}
	});

	$("input[name='billing_address_id']").change(function(){

		$("input[name='isShippingSameAsBilling']").change();
	});

	$("input[name='billing_address_id']").change(); // trigger change event of billing address radio button

</script>
