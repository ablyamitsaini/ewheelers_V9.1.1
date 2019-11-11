(function() {
	var runningAjaxMsg = 'some requests already running or this stucked into runningAjaxReq variable value, so try to relaod the page and update the same to WebMaster. ';
	var runningAjaxReq = false;
	var dv = '#listing';

	checkRunningAjax = function(){
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};

	searchTestDriveRequest = function(frm){
		checkRunningAjax();
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('TestDrive','searchRequests'),data,function(res){
			runningAjaxReq = false;
			$(dv).html(res);
		});
	};
	
	tdCancelRequest = function(requestId){
		var data = 'requestId=' + requestId;
		fcom.updateWithAjax(fcom.makeUrl('TestDrive', 'cancel'), data, function(t) {
			searchTestDriveRequest();
		});
	};
	
	tdConfirmRequest = function(requestId){
		fcom.ajax(fcom.makeUrl('TestDrive', 'confirm', [requestId]), '', function(t) {
			$.facebox(t, 'faceboxWidth');
			// alert(t);
		});
	};
	
	submitTdFeedbackComment = function(frm){
		checkRunningAjax();
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('TestDrive','changeRequestStatus'),data,function(res){
			searchTestDriveRequest(frm);
			$.facebox.close();
		});
	};
	
	
	tdRequestInfo = function(requestId){
		
		fcom.ajax(fcom.makeUrl('TestDrive', 'requestInfo', [requestId]), '', function(t) {
			$.facebox(t, 'faceboxWidth');
			// alert(t);
		});
	};
	

	goToTestDriveSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page = 1;
		}
		var frm = document.frmTestDriveSearchPaging;
		$(frm.page).val(page);
		searchTestDriveRequest(frm);
	}


	clearSearch = function(){
		document.frmTestDriveRequest.reset();
		searchTestDriveRequest(document.frmTestDriveRequest);
	};
	
})();
