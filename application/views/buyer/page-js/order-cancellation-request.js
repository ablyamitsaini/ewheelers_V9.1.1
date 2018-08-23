$("document").ready(function(){
	//
});
function pageRedirect() {
	window.location.replace(fcom.makeUrl('Buyer', 'orderCancellationRequests'));
}
(function() {
	setupOrderCancelRequest = function (frm){
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Buyer', 'setupOrderCancelRequest'), data, function(t) {
			document.frmOrderCancel.reset();    
			setTimeout("pageRedirect()", 1000);
			/* window.location.href = fcom.makeUrl('Buyer', 'orderCancellationRequests'); */
		});
	};
	
})();