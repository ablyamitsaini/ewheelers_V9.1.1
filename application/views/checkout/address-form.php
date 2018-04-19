<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="check-login-wrapper">
	<?php 
		$addressFrm->developerTags['fld_default_col'] = 12;
		$addressFrm->developerTags['colClassPrefix'] = 'col-md-';
		$addressFrm->setFormTagAttribute('class', 'form form--normal');
		$addressFrm->setFormTagAttribute('onsubmit', 'setUpAddress(this); return(false);');
		
		$ua_identifierFld = $addressFrm->getField('ua_identifier');
		$ua_identifierFld->developerTags['col'] = 6;
		
		$ua_nameFld = $addressFrm->getField('ua_name');
		$ua_nameFld->developerTags['col'] = 6;
		
		$countryFld = $addressFrm->getField('ua_country_id');
		$countryFld->developerTags['col'] = 6;
		$countryFld->setFieldTagAttribute('id','ua_country_id');
		$countryFld->setFieldTagAttribute('onChange','getCountryStates(this.value, 0 ,\'#ua_state_id\')');
		
		$stateFld = $addressFrm->getField('ua_state_id');
		$stateFld->developerTags['col'] = 6;
		$stateFld->setFieldTagAttribute('id','ua_state_id');
		
		$zipFld = $addressFrm->getField('ua_zip');
		$zipFld->developerTags['col'] = 6;
		
		$phoneFld = $addressFrm->getField('ua_phone');
		$phoneFld->developerTags['col'] = 6; 
		$submitFld = $addressFrm->getField('btn_submit');
		$cancelFld = $addressFrm->getField('btn_cancel');
		$cancelFld->setFieldTagAttribute('onclick','resetAddress()');
		//$submitFld->attachField($cancelFld);
	?>
	<h6><?php echo $labelHeading; ?></h6>
	<?php echo $addressFrm->getFormHtml(); ?>
</div>
<script language="javascript">
	$(document).ready(function(){
		getCountryStates($( "#ua_country_id" ).val(),<?php echo $stateId ;?>,'#ua_state_id');
	});	
</script>