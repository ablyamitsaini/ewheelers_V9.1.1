$(document).ready(function(){
    searchVolumeDiscountProducts(document.frmSearch);
});
(function() {
	var dv = '#listing';
	searchVolumeDiscountProducts = function(frm){

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).html( fcom.getLoader() );

		fcom.ajax(fcom.makeUrl('Seller','searchVolumeDiscountProducts'),data,function(res){
			$("#listing").html(res);
		});
	};
    clearSearch = function(){
		document.frmSearch.reset();
		searchVolumeDiscountProducts(document.frmSearch);
	};
    goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearchSpecialPricePaging;
		$(frm.page).val(page);
		searchVolumeDiscountProducts(frm);
	}

	reloadList = function() {
		var frm = document.frmSearch;
		searchVolumeDiscountProducts(frm);
	}
	addVolumeDiscount = function() {
		window.open(fcom.makeUrl('Seller','addVolumeDiscount'), '_blank');
	}
})();
