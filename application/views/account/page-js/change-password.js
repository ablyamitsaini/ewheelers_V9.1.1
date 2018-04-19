$(document).ready(function(){
	changePasswordForm();		
});

(function() {
	var runningAjaxReq = false;
	var dv = '#changePassFrmBlock';
	
	checkRunningAjax = function(){
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};
	
	changePasswordForm = function(){				
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'changePasswordForm'), '', function(t) {			
			$(dv).html(t);
		});
	};
	
	updatePassword = function (frm){
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updatePassword'), data, function(t) {						
			changePasswordForm();			
		});	
	};
	
})();