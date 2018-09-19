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
})();
