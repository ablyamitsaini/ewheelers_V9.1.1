$(document).ready(function(){
	searchUserRequests();
});

(function() {
	var currentPage = 1;
	var transactionUserId = 0;
	var rewardUserId = 0;
	
	goToSearchPage = function(page) {	
		if(typeof page == undefined || page == null){
			page = 1;
		}		
		var frm = document.frmUserSearchPaging;		
		$(frm.page).val(page);
		searchUserRequests(frm);
	};
		
	searchUserRequests = function(form,page){
		if (!page) {
			page = currentPage;
		}
		currentPage = page;	
		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		/*]*/	
		
		$("#userRequestsListing").html(fcom.getLoader());
		
		fcom.ajax(fcom.makeUrl('Users','userRequestsSearch'),data,function(res){
			$("#userRequestsListing").html(res);
		});
	};
	
	reloadUserList = function() {
		searchUserRequests(document.frmUserSearchPaging, currentPage);
	};
	
	
	updateRequestStatus = function (reqId,reqStatus){
		if(!confirm(langLbl.confirmChangeRequestStatus)){return;}
		var data = 'reqId='+reqId+'&status='+reqStatus;
		fcom.updateWithAjax(fcom.makeUrl('Users', 'updateRequestStatus'), data, function(t) {					
			if(t.userReqId > 0) {
				searchUserRequests();
			}	
		});
	};
	
	deleteUserRequest = function (reqId,reqStatus){
		if(!confirm(langLbl.confirmChangeRequestStatus)){return;}
		var data = 'reqId='+reqId;
		fcom.updateWithAjax(fcom.makeUrl('Users', 'deleteUserRequest'), data, function(t) {			
			if(t.userReqId > 0) {
				searchUserRequests();
			}	
		});
	};
	
	truncateUserData = function (userId,userReqId){
		if(!confirm(langLbl.confirmTruncateUserData)){return;}
		var data = 'userId='+userId+'&userReqId='+userReqId;
		fcom.updateWithAjax(fcom.makeUrl('Users', 'truncateUserData'), data, function(t) {					
			if(t.userReqId > 0) {
				searchUserRequests();
			}	
		});
	};

	
})();