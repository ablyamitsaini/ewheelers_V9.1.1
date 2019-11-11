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
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		/* $(dv).html( fcom.getLoader() ); */
		/* alert(data); */
		fcom.ajax(fcom.makeUrl('TestDrive','searchRequests'),data,function(res){
			runningAjaxReq = false;
			$(dv).html(res);
		});
	};
	
	changeRequestStatus = function(frm){
		checkRunningAjax();
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('TestDrive','changeRequestStatus'),data,function(res){
			searchTestDriveRequest(frm);
			/* $.mbsmessage.close(); */
			/* alert(res); */
			$.facebox.close();
			
		});
	};
	
	
	tdRequestInfo = function(requestId){
		fcom.ajax(fcom.makeUrl('TestDrive', 'requestInfo', [requestId]), '', function(t) {
			$.facebox(t, 'faceboxWidth');
			// alert(t);
		});
	};
	
	tdDeliverRequest = function(requestId){
		var data = 'ptdr_id=' + requestId +'&ptdr_status=3&ptdr_comments=';
		fcom.updateWithAjax(fcom.makeUrl('TestDrive', 'changeRequestStatus'), data, function(t) {
			searchTestDriveRequest();
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
