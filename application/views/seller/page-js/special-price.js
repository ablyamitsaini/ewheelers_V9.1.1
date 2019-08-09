$(document).ready(function(){
    searchSpecialPriceProducts(document.frmSearch);
});
(function() {
	var dv = '#listing';
	searchSpecialPriceProducts = function(frm){

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).html( fcom.getLoader() );

		fcom.ajax(fcom.makeUrl('SellerProducts','searchSpecialPriceProducts'),data,function(res){
			$("#listing").html(res);
		});
	};
    clearSearch = function(){
		document.frmSearch.reset();
		searchSpecialPriceProducts(document.frmSearch);
	};
    goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearchSpecialPricePaging;
		$(frm.page).val(page);
		searchSpecialPriceProducts(frm);
	}

	reloadList = function() {
		var frm = document.frmSearch;
		searchSpecialPriceProducts(frm);
	}
	addSpecialPrice = function() {
		window.open(fcom.makeUrl('SellerProducts','addSpecialPrice'), '_blank');
	}
})();
