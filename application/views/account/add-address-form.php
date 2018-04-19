<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$addressFrm->setFormTagAttribute('id', 'addressFrm');
$addressFrm->setFormTagAttribute('class','form');
$addressFrm->developerTags['colClassPrefix'] = 'col-md-';
$addressFrm->developerTags['fld_default_col'] = 8;
$addressFrm->setFormTagAttribute('onsubmit', 'setupAddress(this); return(false);');

$countryFld = $addressFrm->getField('ua_country_id');
$countryFld->setFieldTagAttribute('id','ua_country_id');
$countryFld->setFieldTagAttribute('onChange','getCountryStates(this.value,'.$stateId.',\'#ua_state_id\')');

$stateFld = $addressFrm->getField('ua_state_id');
$stateFld->setFieldTagAttribute('id','ua_state_id');
$cancelFld = $addressFrm->getField('btn_cancel');
$cancelFld->setFieldTagAttribute('onclick','searchAddresses()');

$submitFld = $addressFrm->getField('btn_submit');

?>
   <div class="cols--group">
	   <div class="panel__head">
		   <h2><?php echo Labels::getLabel('LBL_My_Addresses',$siteLangId);?></h2>		   
	   </div>	   
	   <div class="panel__body">		
		 <div class="box box--white box--space">
		   <div class="box__head">
			   <h4><?php echo Labels::getLabel('LBL_Address_Book',$siteLangId);?></h4>
		   </div>		   
			<div class="box__body" >
				<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
					<ul>
						<li ><a href="javascript:void(0);" onClick="searchAddresses()"><?php echo Labels::getLabel('LBL_My_Addresses',$siteLangId);?></a></li>
						<?php if( $ua_id > 0 ) {  ?>
						<li class="is-active"><a href="javascript:void(0);" onClick="addAddressForm(<?php echo $ua_id; ?>)"><?php echo Labels::getLabel('LBL_Update_Address',$siteLangId);?></a></li>
						<?php } else { ?>
						<li class="is-active"><a href="javascript:void(0);" onClick="addAddressForm(0)"><?php echo Labels::getLabel('LBL_Add_new_address',$siteLangId);?></a></li>
						<?php } ?>
					</ul>
				</div>
				 
				<div class="container--addresses">
					<?php echo $addressFrm->getFormHtml();?>
				</div>				 
			</div>			 
		</div>		 
   </div>  
</div>
<script language="javascript">
$(document).ready(function(){
	getCountryStates($( "#ua_country_id" ).val(),<?php echo $stateId ;?>,'#ua_state_id');
});	
</script>