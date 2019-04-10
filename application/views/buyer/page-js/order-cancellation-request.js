(function() {
	setupOrderCancelRequest = function (frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Buyer', 'setupOrderCancelRequest'), data, function(t) {
<<<<<<< HEAD
			document.frmOrderCancel.reset();
			setTimeout("pageRedirect()", 1000);
			/* window.location.href = fcom.makeUrl('Buyer', 'orderCancellationRequests'); */
=======
			document.frmOrderCancel.reset();			
			setTimeout(function() { window.location.href = fcom.makeUrl('Buyer', 'orderCancellationRequests'); }, 500);					
>>>>>>> task_61864_add_cost_price_in_seller_inventory
		});
	};

})();
