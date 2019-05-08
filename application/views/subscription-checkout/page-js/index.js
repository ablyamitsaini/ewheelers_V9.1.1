var loginDiv = '#login';
var sCartReviewDiv = '#cart-review';
var paymentDiv = '#payment';
var financialSummary = '.summary-listing';

$("document").ready(function(){
	//$('.step').removeClass("is-current");
	
	if( !isUserLogged() ){
		
		$(loginDiv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'login'), '', function(ans) {
			$(loginDiv).html(ans);
			
			$(loginDiv).addClass("is-current");
		});
	} else {
		loadSubscriptionCartReviewDiv();
		loadFinancialSummary();
	}
});

(function() {
	setUpLogin = function(frm, v) {
		v.validate();
		if ( !v.isValid() ) return;
		fcom.updateWithAjax(fcom.makeUrl('GuestUser', 'login'), fcom.frmData(frm), function(t) {
			if( t.status == 1 ){
				loadAddressDiv();
			}
		});
	};
	
	/* setUpRegisteration = function( frm, v ){
		v.validate();
		if ( !v.isValid() ) return;
		fcom.updateWithAjax(fcom.makeUrl('GuestUser', 'register'), fcom.frmData(frm), function(t) {
			
			if( t.status == 1 ){
				if(t.needLogin){
					window.location.href=t.redirectUrl;
					return;
				}
				else{
					loadAddressDiv();
				}
			}
		});
	}; */
	
	
	
	
	
	
	loadSubscriptionCartReviewDiv = function(){
	
		
		$(loginDiv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'loginDetails'), '', function(ans) {
			$(loginDiv).html(ans);
			//$(loginDiv).show();
			
		});
		$(sCartReviewDiv).html( fcom.getLoader() );
		
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'reviewScart'), '', function(ans) {
			$(sCartReviewDiv).html(ans);
			//$('.step').removeClass("is-current");
			$(sCartReviewDiv).addClass("is-current");
		});
	};
	getReviewSCart= function(){
		
		
		$(sCartReviewDiv).find('.section-head').attr('onClick','loadCartReviewDiv()');
		$(sCartReviewDiv).html( fcom.getLoader());
		$(paymentDiv).html('<div class="selected-panel">4. Make payment</div>');
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'getReviewScart'), '', function(ans) {
			$(sCartReviewDiv).html(ans);
			
		});
	};
	$(document).on('click',".confirmReview",function(){
		getReviewSCart();
		$(sCartReviewDiv).removeClass("is-current");
		loadPaymentSummary();
	});
	$(document).on('click',".reviewOrder",function(){
		loadSubscriptionCartReviewDiv();
		loadPaymentBlankDiv();
	});
	loadPaymentBlankDiv = function(){
		$(paymentDiv).html( fcom.getLoader() );
		
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'PaymentBlankDiv'), '', function(ans) {
			$(paymentDiv).html(ans);
			$(paymentDiv).removeClass("is-current");
		});
	}
	loadPaymentSummary = function(){
		
		
		$(paymentDiv).html( fcom.getLoader() );
		
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'PaymentSummary'), '', function(ans) {
			$(paymentDiv).html(ans);
			
			$(paymentDiv).addClass("is-current");
		});
	};
	loadFinancialSummary= function(){
		
		
		$(financialSummary).html( fcom.getLoader() );
		
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'getFinancialSummary'), '', function(ans) {
			$(financialSummary).html(ans);
			
			
		});
	}
	walletSelection = function(el){
		var wallet = ( $(el).is(":checked") ) ? 1 : 0;
		var data = 'payFromWallet=' + wallet;
		fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'walletSelection'), data, function(ans) {
			loadPaymentSummary();
		});
	};
	useRewardPoints  = function(frm){
		$.systemMessage.close();
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout','useRewardPoints'),data,function(res){
			loadPaymentSummary();
			loadFinancialSummary();
		});
	}; 
	
	removeRewardPoints  = function(){
		$.systemMessage.close();
		fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout','removeRewardPoints'),'',function(res){
			loadPaymentSummary();
			loadFinancialSummary();
		});
	};
	applyPromoCode  = function(frm){
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		
		fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout','applyPromoCode'),data,function(res){
			$("#facebox .close").trigger('click');
			loadFinancialSummary();			
			if($(paymentDiv).hasClass('is-current')){
				loadPaymentSummary();
			}else{
				loadPaymentBlankDiv();
				loadSubscriptionCartReviewDiv();
			}
		});
	 };
	 
	triggerApplyCoupon = function(coupon_code){
		document.frmPromoCoupons.coupon_code.value = coupon_code;
		applyPromoCode(document.frmPromoCoupons);
		return false;
	}
	 
	 removePromoCode  = function(){
		fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout','removePromoCode'),'',function(res){
		$("#facebox .close").trigger('click');
		loadFinancialSummary();	
		if($(paymentDiv).hasClass('is-current')){

				loadPaymentSummary();
			}else{
				loadPaymentBlankDiv();
				loadSubscriptionCartReviewDiv();
			}
		});
	 };
	$(document).on('click','.coupon-input',function(){
		if( isUserLogged() == 0 ){
			$.mbsmessage(langLbl.userNotLogged,true,'alert--danger alert');
		}else {
			$.facebox(function() {
				fcom.ajax(fcom.makeUrl('SubscriptionCheckout','getCouponForm'), '', function(t){	
					$.facebox(t,'faceboxWidth');
					$("input[name='coupon_code']").focus();
				});
			});
		}
	});
	
})();
