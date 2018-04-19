<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="box__head box__head--large">
   <h4><?php echo Labels::getLabel('LBL_Request_Withdrawal',$siteLangId);?></h4>
</div>
<div class="box__body">
	<?php $frm->setFormTagAttribute('class','form');
	$frm->developerTags['colClassPrefix'] = 'col-md-';
	$frm->developerTags['fld_default_col'] = 8;
	$frm->setFormTagAttribute('onsubmit', 'setupWithdrawalReq(this); return(false);');
	
	if( User::isAffiliate() ){
		$paymentMethodFld = $frm->getField('uextra_payment_method');
		$paymentMethodFld->setOptionListTagAttribute( 'class', 'links--inline' );
		
		$checkPayeeNameFld = $frm->getField('uextra_cheque_payee_name');	
		$checkPayeeNameFld->setWrapperAttribute( 'class' , 'cheque_payment_method_fld');

		$bankNameFld = $frm->getField('ub_bank_name');	
		$bankNameFld->setWrapperAttribute( 'class' , 'bank_payment_method_fld');
		
		$bankAccountNameFld = $frm->getField('ub_account_holder_name');	
		$bankAccountNameFld->setWrapperAttribute( 'class' , 'bank_payment_method_fld');
		
		$bankAccountNumberFld = $frm->getField('ub_account_number');	
		$bankAccountNumberFld->setWrapperAttribute( 'class' , 'bank_payment_method_fld');

		$bankSwiftCodeFld = $frm->getField('ub_ifsc_swift_code');	
		$bankSwiftCodeFld->setWrapperAttribute( 'class' , 'bank_payment_method_fld');
		
		$bankAddressFld = $frm->getField('ub_bank_address');
		$bankAddressFld->setWrapperAttribute( 'class' , 'bank_payment_method_fld');

		$PayPalEmailIdFld = $frm->getField('uextra_paypal_email_id');	
		$PayPalEmailIdFld->setWrapperAttribute( 'class' , 'paypal_payment_method_fld');
	}

	$submitBtnFld = $frm->getField('btn_submit');
	$cancelBtnFld = $frm->getField('btn_cancel');
	$cancelBtnFld->setFieldTagAttribute('onClick','closeForm()');
	$submitBtnFld->attachField($cancelBtnFld);

	echo $frm->getFormHtml();?>
</div>

<?php if( User::isAffiliate() ){ ?>
<script type="text/javascript">
$("document").ready( function(){
	var AFFILIATE_PAYMENT_METHOD_CHEQUE = '<?php echo User::AFFILIATE_PAYMENT_METHOD_CHEQUE; ?>';
	var AFFILIATE_PAYMENT_METHOD_BANK = '<?php echo User::AFFILIATE_PAYMENT_METHOD_BANK; ?>';
	var AFFILIATE_PAYMENT_METHOD_PAYPAL = '<?php echo User::AFFILIATE_PAYMENT_METHOD_PAYPAL; ?>';
	
	var uextra_payment_method = '<?php echo $uextra_payment_method ?>';

	$("input[name='uextra_payment_method']").change(function(){
		if( $(this).val() == AFFILIATE_PAYMENT_METHOD_CHEQUE ){
			callChequePaymentMethod();
		}
		
		if( $(this).val() == AFFILIATE_PAYMENT_METHOD_BANK ){
			callBankPaymentMethod();
		}
		
		if( $(this).val() == AFFILIATE_PAYMENT_METHOD_PAYPAL ){
			callPayPalPaymentMethod();
		}
	});
	
	
	if( uextra_payment_method == AFFILIATE_PAYMENT_METHOD_CHEQUE ){
		callChequePaymentMethod();
	}
	if( uextra_payment_method == AFFILIATE_PAYMENT_METHOD_BANK ){
		callBankPaymentMethod();
	}
	if( uextra_payment_method == AFFILIATE_PAYMENT_METHOD_PAYPAL ){
		callPayPalPaymentMethod();
	}
	
} );

function callChequePaymentMethod(){
	$(".cheque_payment_method_fld").show();
	$(".bank_payment_method_fld").hide();
	$(".paypal_payment_method_fld").hide();
}

function callBankPaymentMethod(){
	$(".cheque_payment_method_fld").hide();
	$(".bank_payment_method_fld").show();
	$(".paypal_payment_method_fld").hide();
}

function callPayPalPaymentMethod(){
	$(".cheque_payment_method_fld").hide();
	$(".bank_payment_method_fld").hide();
	$(".paypal_payment_method_fld").show();
}
</script>
<?php } ?>