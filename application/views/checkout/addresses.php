<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="section-head step__head">2. <?php
	$heading = Labels::getLabel('LBL_Billing_Address', $siteLangId);
	if( $cartHasPhysicalProduct ){
		$heading = Labels::getLabel('LBL_Billing/Delivery_Address', $siteLangId);
	}  echo $heading; ?>
</div>
<div class="address-wrapper" id="addressWrapper">
  <?php if($addresses) { ?>
	<div class="row">
		<?php foreach( $addresses as $address ){
				$selected_billing_address_id = (!$selected_billing_address_id && $address['ua_is_default']) ? $address['ua_id'] : $selected_billing_address_id; ?>
				<div class="col-lg-6 col-md-6 col-xs-12  address-<?php echo $address['ua_id'];?>">
					<label class="address">
						<div class="address-inner">
						<span class="radio">
							<input <?php echo ($selected_billing_address_id == $address['ua_id']) ? 'checked="checked"' : ''; ?> name="billing_address_id" value="<?php echo $address['ua_id']; ?>" type="radio"><i class="input-helper"></i>
				    	</span>
						<?php if(!commonhelper::isAppUser()){?>
						<div class="btn-action">
							<a class="editLink action ripplelink" href="javascript:void(0)" onClick="editAddress('<?php echo $address['ua_id']; ?>')" title="<?php echo Labels::getLabel('LBL_Edit', $siteLangId)?>" tabindex="0"><i class="icon"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="528.899px" height="528.899px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;" xml:space="preserve">
						  <g>
							<path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
				c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
				C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
				L27.473,390.597L0.3,512.69z"/>
						  </g>
						  </svg> </i>
					  </a>
							<a title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId)?>" class="action ripplelink" onclick="removeAddress('<?php echo $address['ua_id']; ?>')" href="javascript:void(0)" tabindex="0"><i class="icon"> <svg xml:space="preserve" style="enable-background:new 0 0 482.428 482.429;" viewBox="0 0 482.428 482.429" height="482.429px" width="482.428px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" >
							  <g>
								<g>
								  <path d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098
					c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117
					h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828
					C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879
					C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096
					c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266
					c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979
					V115.744z"/>
								  <path d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07
					c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z"/>
								  <path d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07
					c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z"/>
								  <path d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07
					c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z"/>
								</g>
							  </g>
							  </svg> </i>
							</a>
						</div> <?php }?>
						<!-- <div class="address-type"></div> -->
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
					</div>
					</label>
				</div>
		<?php } ?>
	</div>
  <?php } ?>
  <div class="gap"></div>
  <div class="align--center"> <a onClick="showAddressFormDiv();" name="addNewAddress" class="btn btn--lg btn--secondary ripplelink"> <?php echo Labels::getLabel('LBL_Add_New_Address', $siteLangId);?> </a> </div>
  <div class="gap"></div>
  <?php if( $cartHasPhysicalProduct ){ ?>
	<p><?php echo Labels::getLabel('LBL_Please_add_addresss_where_you_want_to_ship_your_product', $siteLangId);?></p>
  <?php }?>

<?php if( $cartHasPhysicalProduct && $addresses ){ ?>


</div>

<div class="divider "></div>

<div class="address-wrapper">

    	<h4><?php echo Labels::getLabel('LBL_Shipping_Address', $siteLangId); ?></h4>
		<label class="checkbox">
			<input type="checkbox" <?php echo ($isShippingSameAsBilling) ? "checked='checked'" : ''; ?> name="isShippingSameAsBilling" value="1"><i class="input-helper"></i>
			<?php echo Labels::getLabel('LBL_Same_as_Billing_Address', $siteLangId); ?>
		</label>

		<div class="gap"></div>

			<div class="row" id="shippingAddressContainer">
			  <?php foreach( $addresses as $address ){
						$selected_shipping_address_id = (!$selected_shipping_address_id && $address['ua_is_default']) ? $address['ua_id'] : $selected_shipping_address_id; ?>
						<div class="col-lg-6 col-md-6 col-xs-12" >


								<label class="address">
										<div class="address-inner">
									<span class="radio">
										<input <?php echo ($selected_shipping_address_id == $address['ua_id']) ? 'checked="checked"' : ''; ?> name="shipping_address_id" value="<?php echo $address['ua_id']; ?>" type="radio"><i class="input-helper"></i>
									</span>
									<div class="btn-action">
										<a class="editLink action ripplelink" href="javascript:void(0)" onClick="editAddress('<?php echo $address['ua_id']; ?>')" title="<?php echo Labels::getLabel('LBL_Edit', $siteLangId)?>" tabindex="0"><i class="icon"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="528.899px" height="528.899px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;" xml:space="preserve">
											  <g>
												<path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981
									c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611
									C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069
									L27.473,390.597L0.3,512.69z"/>
											  </g>
											  </svg> </i>
										</a>
										<a title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId)?>" class="action ripplelink" onclick="removeAddress('<?php echo $address['ua_id']; ?>')" href="javascript:void(0)" tabindex="0"><i class="icon"> <svg xml:space="preserve" style="enable-background:new 0 0 482.428 482.429;" viewBox="0 0 482.428 482.429" height="482.429px" width="482.428px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" >
											  <g>
												<g>
												  <path d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098
									c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117
									h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828
									C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879
									C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096
									c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266
									c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979
									V115.744z"/>
												  <path d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07
									c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z"/>
												  <path d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07
									c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z"/>
												  <path d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07
									c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z"/>
												</g>
											  </g>
											  </svg> </i>
										 </a>
									</div>
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
									</div>
								</label>



						</div>
			  <?php } ?>
			</div>

            <div class="gap"></div>

		<?php } ?>
  <?php if($addresses) { ?>
	<div class="row"><div class="col-md-12 text-right">
		<a href="javascript:void(0)" onClick="setUpAddressSelection(this);" class="btn btn--secondary"><?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?></a>
	</div> </div> 	<div class="gap"></div>

<?php } ?>
	</div>


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
