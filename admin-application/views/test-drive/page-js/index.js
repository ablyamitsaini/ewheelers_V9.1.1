$(document).ready(function(){
	searchTestDriveRequests();
});

$(document).ready(function(){
	searchTestDriveRequests(document.frmSearch);

	$('input[name=\'user_name\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: fcom.makeUrl('Users', 'autoCompleteJson'),
				data: {keyword: request, fIsAjax:1},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'] +'(' + item['username'] + ')', value: item['id'], name: item['username']	};
					}));
				},
			});
		},
		'select': function(item) {
			$("input[name='user_id']").val( item['value'] );
			$("input[name='user_name']").val( item['name'] );
		}
	});
});


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

	searchTestDriveRequests = function(frm){
		checkRunningAjax();

		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('TestDrive','search'),data,function(res){
			runningAjaxReq = false;
			$(dv).html(res);
		});
	};
	
	viewTestDriveDetails = function(requestId){
		fcom.ajax(fcom.makeUrl('TestDrive', 'viewTestDriveDetails', [requestId]), '', function(t) {
			$.facebox(t, 'faceboxWidth');
			// alert(t);
		});
	};
	
	completeRequest = function(requestId){
		var data = 'requestId=' + requestId;
		fcom.updateWithAjax(fcom.makeUrl('TestDrive', 'completeRequest'), data, function(t) {
			searchTestDriveRequests(document.frmSearch);
		});
	};
	
	goToTestDriveSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page = 1;
		}
		var frm = document.frmTestDriveSearchPaging;
		$(frm.page).val(page);
		searchTestDriveRequests(frm);
	}
	
	clearSearch = function(){
		document.frmSearch.reset();
		document.frmSearch.user_id.value = '';
		searchTestDriveRequests();

	};

	
})();
