var pageContent = '.checkout-content-js';

var loginDiv = '#login-register';
var addressDiv = '#address';
var addressFormDiv = '#addressFormDiv';
var addressDivFooter = '#addressDivFooter';
var addressWrapper = '#addressWrapper';
var addressWrapperContainer = '.address-wrapper';
var alreadyLoginDiv = '#alreadyLoginDiv';
var shippingSummaryDiv = '#shipping-summary';
var cartReviewDiv = '#cart-review';
var paymentDiv = '#payment';
var financialSummary = '.summary-listing';

function checkLogin(){
	if( isUserLogged() == 0 ){
		loginPopUpBox();
		return false;
	}
}

function showLoginDiv()
{
	$('.step').removeClass("is-current");
	$(loginDiv).find('.step__body').show();
	$(loginDiv).find('.step__body').html(fcom.getLoader());
	fcom.ajax(fcom.makeUrl('Checkout', 'login'), '', function(ans) {
		$(loginDiv).find('.step__body').html(ans);
		$(loginDiv).addClass("is-current");
	});
}

function editCart(){
	checkLogin();
	$('.js-editCart').toggle();
}

function showAddressFormDiv()
{
	editAddress();
	setCheckoutFlow('BILLING');
}
function showAddressList()
{
	checkLogin();
	loadAddressDiv();
	setCheckoutFlow('BILLING');
	// resetShippingSummary();
	// resetPaymentSummary();
}
function resetAddress(){
	loadAddressDiv();
}
function showShippingSummaryDiv()
{
	return loadShippingSummaryDiv();
}
function showCartReviewDiv()
{
	return loadCartReviewDiv();
}
$("document").ready(function()
{
	//loadAddressDiv();
	loadFinancialSummary();
	// $('.step').removeClass("is-current");
	// if( !isUserLogged()){
	// 	$(loginDiv).find('.step__body').show();
	// 	$(loginDiv).find('.step__body').html(fcom.getLoader());
	// 	fcom.ajax(fcom.makeUrl('Checkout', 'login'), '', function(ans) {
	// 		$(loginDiv).find('.step__body').html(ans);
	//
	// 		$(loginDiv).addClass("is-current");
	// 		loadFinancialSummary();
	// 	});
	// } else {
	// 	$(alreadyLoginDiv).show();
	// 	loadAddressDiv();
	// 	loadFinancialSummary();
	// }
});


(function() {
	setUpLogin = function(frm, v) {
		v.validate();
		if ( !v.isValid() ) return;
		fcom.ajax(fcom.makeUrl('GuestUser', 'login'), fcom.frmData(frm), function(t) {
			var ans = JSON.parse(t);
			if(ans.notVerified==1)
			{
				var autoClose = false;
			}else{
				var autoClose = true;
			}
			if( ans.status == 1 ){
				$.mbsmessage(ans.msg, autoClose, 'alert--success');
				location.href = ans.redirectUrl;
				return;
			}
			$.mbsmessage(ans.msg, autoClose, 'alert--danger');
		});
		return false;
	};

	loadloginDiv = function(){
		fcom.ajax(fcom.makeUrl('Checkout', 'loadLoginDiv'), '', function(ans) {
			$(loginDiv).html(ans);
		});
	};

	loadFinancialSummary= function(){
		$(financialSummary).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Checkout', 'getFinancialSummary'), '', function(ans) {
			$(financialSummary).html(ans);
		});
	};

	setUpRegisteration = function( frm, v ){
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
	};

	removeAddress = function(id){
		checkLogin();
		var agree = confirm(langLbl.confirmDelete);
		if( !agree ){
			return false;
		}
		data='id='+id;
		fcom.updateWithAjax(fcom.makeUrl('Addresses','deleteRecord'),data,function(res){
			loadAddressDiv();
		});
	};

	editAddress = function( address_id ){
		checkLogin();
		if(typeof address_id == 'undefined'){
			address_id = 0;
		}
		fcom.ajax(fcom.makeUrl('Checkout', 'editAddress'), 'address_id=' + address_id , function( ans ) {
			$(pageContent).html(ans);
			setCheckoutFlow('BILLING');
			// $(addressFormDiv).html( ans ).show();
			// $(addressWrapper).hide();
			// $(addressWrapperContainer).hide();
			// $(addressWrapper).hide();
			// $(addressFormDiv).addClass("is-current");
		});
	};

	setUpAddress = function(frm){
		checkLogin();
		if ( !$(frm).validate() ) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Addresses', 'setUpAddress'), data, function(t) {
			if( t.status == 1 ){
				if($(frm.ua_id).val() == 0){
					loadAddressDiv();
					setTimeout(function(){ setDefaultAddress(t.ua_id) }, 1000);
				}else{
					showShippingSummaryDiv(t.ua_id);
					loadFinancialSummary();
				}
			}
		});
	};

	setDefaultAddress = function(id){
		/* if( !confirm(langLbl.confirmDefault) ){
			return false;
		}
		data='id='+id;
		alert(id);*/
		$('.address-billing').removeClass("is--selected");
		$("input[name='billing_address_id']").each(function() {
			$(this).removeAttr("checked");
		});
		$('#address_'+id+' input[name=billing_address_id]').attr('checked', 'checked');
		$('#address_'+id).addClass("is--selected");
		// $("#btn-continue-js").trigger("click");
		// setUpAddressSelection($('#btn-continue-js'));

		/* fcom.updateWithAjax(fcom.makeUrl('Addresses','setDefault'),data,function(res){
			$('.address-billing').removeClass("is--selected");
			$('.address_'+id).addClass("is--selected");
			// $("#btn-continue-js").trigger("click");
		});*/
	};

	setUpAddressSelection = function(elm){
		checkLogin();
		var shipping_address_id = $(elm).parent().parent().parent().find('input[name="shipping_address_id"]:checked').val();
		var billing_address_id = $(elm).parent().parent().parent().parent().find('input[name="billing_address_id"]:checked').val();
		var isShippingSameAsBilling = $('input[name="isShippingSameAsBilling"]:checked').val();
		var data = 'shipping_address_id='+shipping_address_id+'&billing_address_id='+billing_address_id+'&isShippingSameAsBilling='+isShippingSameAsBilling;
		fcom.updateWithAjax(fcom.makeUrl('Checkout', 'setUpAddressSelection'), data , function(t) {
			if( t.status == 1 ){
				if( t.loadAddressDiv ){
					loadAddressDiv();
				} else {
					if( t.hasPhysicalProduct ){
						$(shippingSummaryDiv).show();
						loadShippingSummaryDiv();
					} else {
						$(shippingSummaryDiv).hide();
						loadShippingAddress();
						loadCartReviewDiv();
					}
					loadFinancialSummary();
				}
			}
		});
	};

	setUpShippingApi = function(frm){
		checkLogin();
		var data = fcom.frmData(frm);
		$(shippingSummaryDiv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Checkout', 'setUpShippingApi'), data , function(ans) {
			$(shippingSummaryDiv).html( ans );
			/* fcom.scrollToTop("#shipping-summary"); */
			$(".sduration_id-Js").trigger("change");
		});
	};

	getProductShippingComment = function(el, selprod_id){
		var sduration_id = $(el).find(":selected").val();
		$(".shipping_comment_"+selprod_id).hide();
		$("#shipping_comment_"+selprod_id + '_' + sduration_id).show();
	};

	getProductShippingGroupComment = function(el, prodgroup_id){
		var sduration_id = $(el).find(":selected").val();
		$(".shipping_group_comment_"+prodgroup_id).hide();
		$("#shipping_group_comment_"+prodgroup_id + '_' + sduration_id).show();
	};

	setUpShippingMethod = function(){
		checkLogin();
		var data = $("#shipping-summary select").serialize();
		fcom.updateWithAjax(fcom.makeUrl('Checkout', 'setUpShippingMethod'), data , function(t) {
			if( t.status == 1 ){
				loadFinancialSummary();
				loadPaymentSummary();
				setCheckoutFlow('PAYMENT');
				//loadShippingSummary();
				//loadCartReviewDiv();
			}
		});
	};

	loadAddressDiv = function(ua_id){
		// $(addressDiv).html( fcom.getLoader());
		// fcom.ajax(fcom.makeUrl('Checkout', 'addresses'), '', function(ans) {
		// 	$(addressDiv).html(ans);
		// 	$('.section-checkout').removeClass('is-current');
		// 	$(addressDiv).addClass('is-current');
		// 	$(addressDiv).find(".address-"+ua_id +" label .radio").click();
		// });
		$(pageContent).html( fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Checkout', 'addresses'), '', function(ans) {
			$(pageContent).html(ans);
		});

	};

	loadShippingAddress  = function(){
		fcom.ajax(fcom.makeUrl('Checkout', 'loadBillingShippingAddress'), '' , function(t) {
			$(addressDiv).html(t);
			/* fcom.scrollToTop("#alreadyLoginDiv"); */
		});
	};

	resetShippingSummary = function(){
		resetCartReview();
		fcom.ajax(fcom.makeUrl('Checkout', 'resetShippingSummary'), '' , function(ans) {
			$(shippingSummaryDiv ).html( ans );

		});
	};

	removeShippingSummary = function(){
		resetCartReview();
		fcom.ajax(fcom.makeUrl('Checkout', 'removeShippingSummary'), '' , function(ans) {

		});
	};

	resetCartReview = function(){
		fcom.ajax(fcom.makeUrl('Checkout', 'resetCartReview'), '' , function(ans) {
			$(cartReviewDiv ).html( ans );

		});
	};

	loadShippingSummary = function(){
		$(shippingSummaryDiv).show();
		$(shippingSummaryDiv).html( fcom.getLoader());

		fcom.ajax(fcom.makeUrl('Checkout', 'loadShippingSummary'), '' , function(ans) {
			$(shippingSummaryDiv ).html( ans );
			/* fcom.scrollToTop("#shipping-summary"); */

		});
	};

	changeShipping = function(){
		checkLogin();
		loadShippingSummaryDiv();
		resetCartReview();
		resetPaymentSummary();
	};

	loadShippingSummaryDiv = function(){
		// $(shippingSummaryDiv).show();
		// $(addressDiv).html(fcom.getLoader() );
		// $(shippingSummaryDiv).append(fcom.getLoader() );
		// loadShippingAddress();
		// $('.section-checkout').removeClass('is-current');
		// $(shippingSummaryDiv).addClass('is-current');
		// $(shippingSummaryDiv + ".selected-panel-data").html( fcom.getLoader());
		// fcom.ajax(fcom.makeUrl('Checkout', 'shippingSummary'), '' , function(ans) {
		// 	$(shippingSummaryDiv ).html( ans );
		// 	$(".sduration_id-Js").trigger("change");
		// });
		$(pageContent).html( fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Checkout', 'shippingSummary'), '' , function(ans) {
		 	$(pageContent).html( ans );
		 	$(".sduration_id-Js").trigger("change");
			setCheckoutFlow('SHIPPING');
		});
	};

	viewOrder = function(){
		resetPaymentSummary();
		loadShippingSummary();
		loadCartReviewDiv();
	};

	resetPaymentSummary = function(){
		$(paymentDiv).removeClass('is-current');
		fcom.ajax(fcom.makeUrl('Checkout', 'resetPaymentSummary'), '', function(ans) {
			$(paymentDiv).html(ans);
		});
	};

	loadCartReviewDiv = function(){
		// $(cartReviewDiv).html( fcom.getLoader() );
		// $('.section-checkout').removeClass('is-current');
		// $(cartReviewDiv).addClass('is-current');
		// fcom.ajax(fcom.makeUrl('Checkout', 'reviewCart'), '', function(ans) {
		// 	$(cartReviewDiv).html(ans);
		// });
		$(pageContent).html( fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Checkout', 'reviewCart'), '', function(ans) {
			$(pageContent).html(ans);
		});
	};

	loadCartReview = function(){
		fcom.ajax(fcom.makeUrl('Checkout', 'loadCartReview'), '', function(ans) {
			$(cartReviewDiv).html(ans);
		});
	};

	loadPaymentSummary = function(){
		// loadCartReview();
		// $(paymentDiv).html( fcom.getLoader() );
		// $('.section-checkout').removeClass('is-current');
		// $(paymentDiv).addClass('is-current');
		// fcom.ajax(fcom.makeUrl('Checkout', 'PaymentSummary'), '', function(ans) {
		// 	$(paymentDiv).html(ans);
		// 	$("#payment_methods_tab  li:first a").trigger('click');
		// });
		$(pageContent).html( fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Checkout', 'PaymentSummary'), '', function(ans) {
			$(pageContent).html(ans);
			$(paymentDiv).addClass('is-current');
			setTimeout(function(){ $('#payment_methods_tab').find('li:first a')[0].click(); }, 500);
			//$("#payment_methods_tab li:first a").trigger('click');
		});
	};

	walletSelection = function(el){
		var wallet = ( $(el).is(":checked") ) ? 1 : 0;
		var data = 'payFromWallet=' + wallet;
		fcom.ajax(fcom.makeUrl('Checkout', 'walletSelection'), data, function(ans) {
			loadPaymentSummary();
		});
	};

	getPromoCode = function(){
		checkLogin();

		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Checkout','getCouponForm'), '', function(t){
				$.facebox(t,'faceboxWidth medium-fb-width');
				$("input[name='coupon_code']").focus();
			});
		});
	};

	applyPromoCode  = function(frm){
		checkLogin();
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);

		fcom.updateWithAjax(fcom.makeUrl('Cart','applyPromoCode'),data,function(res){
			$("#facebox .close").trigger('click');
			$.systemMessage.close();
			loadFinancialSummary();
			if($(paymentDiv).hasClass('is-current')){
				loadPaymentSummary();
			}
		});
	};

	triggerApplyCoupon = function(coupon_code){
		document.frmPromoCoupons.coupon_code.value = coupon_code;
		applyPromoCode(document.frmPromoCoupons);
		return false;
	};

	removePromoCode  = function(){
		fcom.updateWithAjax(fcom.makeUrl('Cart','removePromoCode'),'',function(res){
		loadFinancialSummary();
		if($(paymentDiv).hasClass('is-current')){
				loadPaymentSummary();
			}
		});
	};

	useRewardPoints  = function(frm){
		checkLogin();
		$.systemMessage.close();
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Checkout','useRewardPoints'),data,function(res){
			loadFinancialSummary();
			loadPaymentSummary();
		});
	};

	removeRewardPoints  = function(){
		checkLogin();
		$.systemMessage.close();
		fcom.updateWithAjax(fcom.makeUrl('Checkout','removeRewardPoints'),'',function(res){
			loadFinancialSummary();
			loadPaymentSummary();
		});
	};

	resetCheckoutDiv = function(){
		removeShippingSummary();
		resetPaymentSummary();
		loadShippingSummaryDiv();
	};

	setCheckoutFlow = function(type){
		var obj = $('.checkout-flow');
		obj.find('li').removeClass('completed');
		obj.find('li').removeClass('inprogress');
		obj.find('li').removeClass('pending');
		switch(type) {
		  case 'BILLING':
			obj.find('.billing-js').addClass('inprogress');
			obj.find('.shipping-js').addClass('pending');
			obj.find('.payment-js').addClass('pending');
			obj.find('.order-complete-js').addClass('pending');
		    break;
		  case 'SHIPPING': console.log(type);
			obj.find('.billing-js').addClass('completed');
			obj.find('.shipping-js').addClass('inprogress');
			obj.find('.payment-js').addClass('pending');
			obj.find('.order-complete-js').addClass('pending');
		    break;
		  case 'PAYMENT':
			  obj.find('.billing-js').addClass('completed');
			  obj.find('.shipping-js').addClass('completed');
			  obj.find('.payment-js').addClass('inprogress');
			  obj.find('.order-complete-js').addClass('pending');
		    break;
		  case 'COMPLETED':
			  obj.find('.billing-js').addClass('completed');
			  obj.find('.shipping-js').addClass('completed');
			  obj.find('.payment-js').addClass('completed');
			  obj.find('.order-complete-js').addClass('pending');
		    break;
		  default:
			  obj.find('li').addClass('pending');
		}
	}
})();
