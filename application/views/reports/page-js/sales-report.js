$(document).ready(function(){
	searchSalesReport(document.frmSalesReportSrch);
});

(function() {
	var runningAjaxReq = false;
	var dv = '#listingDiv';
	
	searchSalesReport = function(frm){
		$(dv).html( fcom.getLoader() );
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('Reports', 'searchSalesReport'), data, function(t) {			
			$(dv).html(t);
		});
	};
	
	goToSalesReportSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page = 1;
		}		
		var frm = document.frmSalesReportSrchPaging;		
		$( frm.page ).val( page );
		searchSalesReport( frm );
	}
	
	clearSearch = function(){
		document.frmSalesReportSrch.reset();
		searchSalesReport(document.frmSalesReportSrch);
	};
	
	exportSalesReport = function(){
	   var newForm = $('<form>', {'method': 'POST', 'action': fcom.makeUrl('Reports','exportSalesReport'), 'target': '_top'});
       var srchFrm = fcom.frmData(document.frmSalesReportSrchPaging);
       var srchFrmData = srchFrm.split('&');

       for (var i = 0; i < srchFrmData.length; i++) {
           var field = srchFrmData[i].split('=');
           newForm.append($('<input>', {'name': decodeURI(field[0]), 'value': field[1], 'type': 'hidden'}));
       }

      
       newForm.appendTo('body');
       newForm.submit();
       newForm.remove();
		
		
		
	};
	
	/* exportSalesReport = function(){
		document.frmSalesReportSrchPaging.action = fcom.makeUrl('Reports','exportSalesReport');
		document.frmSalesReportSrchPaging.submit();
	}; */
	
	/* redirectBack=function(redirecrt){
	var url=	SITE_ROOT_URL +''+redirecrt;
	window.location=url;
	} */
	
})();