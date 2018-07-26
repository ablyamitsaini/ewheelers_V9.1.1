$("document").ready(function(){
	searchSavedSearchesList();
});

(function() {
	var dv = '#SearchesListingDiv';
	searchSavedSearchesList = function(page){
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account','savedSearchesSearch'), 'page=' + page, function(res){
			$(dv).html(res);
		}); 
	};
	
	deleteSavedSearch = function( pssearch_id ){
		var agree = confirm( langLbl.confirmDelete );
		if( !agree ){ return false; };
		fcom.updateWithAjax(fcom.makeUrl('Account', 'deleteSavedSearch'), 'pssearch_id=' + pssearch_id, function(ans) {
			if( ans.status ){
				searchSavedSearchesList();
			}
		});
	};
	
	proceedToSearchPage = function( pssearch_id ){
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateSearchdate'), 'pssearch_id=' + pssearch_id, function(ans) {
			if( ans.status ){
				searchSavedSearchesList();
			}
		});
	};
	
	goToProductSavedSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page =1;
		}
		searchSavedSearchesList(page);
	}
	
})();