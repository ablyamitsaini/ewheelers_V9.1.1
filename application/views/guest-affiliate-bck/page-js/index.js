(function() {
	setupAffiliateRegister = function(frm){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('GuestAffiliate', 'setupAffiliateRegister'), data, function(t) {
			if( t.affiliate_register_step_number ){
				callAffilitiateRegisterStep( t.affiliate_register_step_number,t.userAffilaiteData );
			}
		});
	};
	
	callAffilitiateRegisterStep = function( registeration_step_number, userAffilaiteData ){
		$("#register-form-div").html( fcom.getLoader() );
		fcom.ajax( fcom.makeUrl( 'GuestAffiliate', 'affiliateRegistrationStep', [registeration_step_number] ), 'userAffilaiteData='+userAffilaiteData, function(t){
			$("#register-form-div").html( t );
		});
	};
})();