$(document).ready(function(){
	searchTestDriveReport(document.frmTestDriveReportSearch);
});
(function() {
	var currentPage = 1;
	var runningAjaxReq = false;
	var dv = '#listing';

	goToSearchPage = function(page) {	
		if(typeof page == undefined || page == null){
			page =1;
		}
		var frm = document.frmTestDriveReportSearchPaging;		
		$(frm.page).val(page);
		searchTestDriveReport(frm);
	};
	redirectBack=function(redirecrt){

	var url= SITE_ROOT_URL +''+redirecrt;
	window.location=url;
	}
	reloadList = function() {
		var frm = document.frmTestDriveReportSearchPaging;
		searchTestDriveReport(frm);
	};
	
	searchTestDriveReport = function(form){
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		
		$(dv).html(fcom.getLoader());
		
		fcom.ajax(fcom.makeUrl('TestDriveReport','search'),data,function(res){
			$(dv).html(res);
		});
	};
	
	exportReport = function(){
		var url =  fcom.makeUrl('TestDriveReport','export');
		document.frmTestDriveReportSrch.action = url;
		document.frmTestDriveReportSrch.submit();		
	}
	
	clearSearch = function(){
		document.frmTestDriveReportSrch.reset();
		searchTestDriveReport(document.frmTestDriveReportSrch);
	};
})();	