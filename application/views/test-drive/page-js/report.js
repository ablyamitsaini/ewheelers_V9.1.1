$(document).ready(function(){
	searchTestDriveReport(document.frmTestDriveReportSrch);
});

(function() {
	var runningAjaxReq = false;
	var dv = '#listingDiv';
	
	searchTestDriveReport = function(frm){
		$(dv).html( fcom.getLoader() );
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('TestDrive', 'searchReport'), data, function(t) {			
			$(dv).html(t);
		});
	};
	
	goToTestDriveReportSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page = 1;
		}		
		var frm = document.frmTestDriveReportSrchPaging;		
		$( frm.page ).val( page );
		searchTestDriveReport( frm );
	}
	
	clearSearch = function(){
		document.frmTestDriveReportSrch.reset();
		searchTestDriveReport(document.frmTestDriveReportSrch);
	};
	
	exportReport = function(){
		document.frmTestDriveReportSrch.action = fcom.makeUrl('TestDrive','exportReport');
		document.frmTestDriveReportSrch.submit();
	};
	
	/* redirectBack=function(redirecrt){
	var url=	SITE_ROOT_URL +''+redirecrt;
	window.location=url;
	} */
	
})();