function pageRedirect() {
	window.location.replace(fcom.makeUrl('Buyer', 'Orders'));
}

(function() {
	setupOrderReturnRequest = function (frm){
		if (!$(frm).validate()) return;	
		$.mbsmessage(langLbl.processing,true,'alert--process alert');
		$.ajax({
		url: fcom.makeUrl('Buyer', 'setupOrderReturnRequest'),
		type: 'post',
		dataType: 'json',
		data: new FormData($(frm)[0]),
		cache: false,
		contentType: false,
		processData: false,
		
		success: function(ans) {
			if(ans.status == true){
				$.mbsmessage(ans.msg, true, 'alert--success');
				document.frmOrderReturnRequest.reset();
				setTimeout("pageRedirect()", 1000);
				/* window.location.href = fcom.makeUrl('Buyer' ,'Orders'); */
			}else{
				$.mbsmessage(ans.msg, true, 'alert--danger');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
		});
	};
	
})();