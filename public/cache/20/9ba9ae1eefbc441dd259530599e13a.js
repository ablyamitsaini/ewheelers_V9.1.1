$(document).ready(function() {
	relaodHeaderCartSummary();
	//$('#list_cart_summary').load(generateUrl('cart', 'cart_summary'));
});



(function() {
	relaodHeaderCartSummary = function(){
		
	}
	
})();

var cart = {
	add: function( selprod_id, quantity, isRedirectToCart ){
		isRedirectToCart = (typeof(isRedirectToCart) != 'undefined') ? true : false;
		var data = 'selprod_id=' + selprod_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1);
		fcom.updateWithAjax(fcom.makeUrl('Cart','add'), data ,function(ans){
			if (ans['redirect']) {
				location = ans['redirect'];
			}
			setTimeout(function () {
				$.mbsmessage.close();
			}, 3000);
			
			/* isRedirectToCart needed from product detail page */
			if( isRedirectToCart ){
				setTimeout(function () {
					window.location = fcom.makeUrl('Checkout');
				}, 300);
			} else {
				$('span.cartQuantity').html(ans.total);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('html').toggleClass("cart-is-active");
				$('.cart').toggleClass("cart-is-active");
				$('#cartSummary').load(fcom.makeUrl('cart', 'getCartSummary'));
			}
			
		});
	},
	
	remove: function (key, page){
		if(confirm( langLbl.confirmRemove )){
			var data = 'key=' + key ;
			if(page == 'checkout')
			{
				fcom.updateWithAjax(fcom.makeUrl('Cart','remove'), data ,function(ans){
					if( ans.status ){
						loadFinancialSummary();
						dv = $(".is-current").attr("id");
						if( dv=='address' ){
							loadAddressDiv();
						}
						if( dv=='shipping-summary' ){
							loadShippingSummaryDiv();
						}
						if(dv=='cart-review'){
							loadCartReviewDiv();
						}
						if(dv=='payment'){
							loadPaymentSummary();
						}
						/* setUpShippingApi($('form#frm_fat_id_frmShippingApi')); */
					}
					$.mbsmessage.close();
				});
			}
			else if(page=='cart')
			{
				fcom.updateWithAjax(fcom.makeUrl('Cart','remove'), data ,function(ans){
					if( ans.status ){
						listCartProducts();
						$('#cartSummary').load(fcom.makeUrl('cart', 'getCartSummary'));
					}
					$.mbsmessage.close();
				});
			}
			else
			{
				fcom.updateWithAjax(fcom.makeUrl('Cart','remove'), data ,function(ans){
						$('#cartSummary').load(fcom.makeUrl('cart', 'getCartSummary'));
						//$('#shipping-products').load(fcom.makeUrl('checkout', 'shippingSummary'));
						//listCartProducts();
					
					$.mbsmessage.close();
				});
			}
		}
	},
	
	update: function (key,loadDiv){
		var data = 'key=' + key + '&quantity=' + $("input[name='qty_" + key + "']").val();
		/* alert(data); */
		fcom.updateWithAjax(fcom.makeUrl('Cart','update'), data ,function(ans){
			if( ans.status ){
				
				if(loadDiv!=undefined){
					loadFinancialSummary();
					resetCheckoutDiv();
				}else{
					listCartProducts();
				}
			}
			// $.mbsmessage.close();
		});
	},
	
	updateGroup: function ( prodgroup_id ){
		$.systemMessage.close();
		var data = 'prodgroup_id=' + prodgroup_id + '&quantity=' + $("input[name='qty_" + prodgroup_id + "']").val();;
		fcom.updateWithAjax( fcom.makeUrl( 'Cart', 'updateGroup' ), data ,function( ans ){
			if( ans.status ){
				listCartProducts();
			}
		});
	},
	
	addGroup: function( prodgroup_id, isRedirectToCart ){
		isRedirectToCart = (typeof(isRedirectToCart) != 'undefined') ? true : false;
		var data = 'prodgroup_id=' + prodgroup_id;
		fcom.updateWithAjax(fcom.makeUrl('Cart','addGroup'), data ,function(ans){
			setTimeout(function () {
				$.mbsmessage.close();
			}, 3000);
			
			$(".cart-item-counts-js").html( ans.total );
			if( isRedirectToCart ){
				setTimeout(function () {
					window.location = fcom.makeUrl('Cart');
				}, 300);
			}
		});
	},
	
	removeGroup: function(prodgroup_id){
		if(confirm( langLbl.confirmRemove )){
			var data = 'prodgroup_id=' + prodgroup_id ;
			fcom.updateWithAjax(fcom.makeUrl('Cart','removeGroup'), data ,function(ans){
				if( ans.status ){
					listCartProducts();
				}
				$.mbsmessage.close();
			});
		}
	},
};