$(document).ready(function(){
	searchBuyerDownloads(document.frmSrch);
});

(function() {
	var dv = "#listing";
	searchBuyerDownloads = function(frm){
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Buyer','downloadSearch'), data, function(res){
			$(dv).html(res);
		}); 
	};
	
	searchBuyerDownloadLinks = function(frm){
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Buyer','downloadLinksSearch'), data, function(res){
			$(dv).html(res);
		}); 
	};
	
	goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSrchPaging;		
		$(frm.page).val(page);
		searchBuyerDownloads(frm);
	};
	
	goToLinksSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSrchPaging;		
		$(frm.page).val(page);
		searchBuyerDownloadLinks(frm);
	};
	
	clearSearch = function(){
		document.frmSrch.reset();
		searchBuyerDownloads(document.frmSrch);
	};
	
})();