(function() {
	setupOrderCancelRequest = function (frm){
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Buyer', 'setupOrderCancelRequest'), data, function(t) {
			document.frmOrderCancel.reset();			
			setTimeout(function() { fcom.makeUrl('Buyer', 'orderCancellationRequests') }, 1000);					
		});
	};
	
})();