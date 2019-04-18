$(document).ready(function(){
	listCartProducts();
});
(function() {
	listCartProducts = function(){
		$('#cartList').html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Cart','listing'),'',function(res){
			$("#cartList").html(res);
		});
	};

	applyPromoCode  = function(frm){
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Cart','applyPromoCode'),data,function(res){
			listCartProducts();
		});
	};

	removePromoCode  = function(){
		fcom.updateWithAjax(fcom.makeUrl('Cart','removePromoCode'),'',function(res){
			listCartProducts();
		});
	};

	moveToWishlist = function( selprod_id, event, key ){
		event.stopPropagation();
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}

		fcom.ajax(fcom.makeUrl('Account','moveToWishList', [selprod_id]),'',function( resp ){
			removeFromCart( key );
		});
	};

	addToFavourite = function( key, product_id ){
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}
		var data = 'product_id='+product_id;
		$.mbsmessage.close();
		fcom.updateWithAjax(fcom.makeUrl('Account', 'toggleProductFavorite'), data, function(ans) {
			if( ans.status ){
				removeFromCart( key );
			}
		});
	};

})();
