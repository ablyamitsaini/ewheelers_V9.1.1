(function() {
	var runningAjaxReq = false;
	setUpShopSpam = function(frm){
		if ( !$(frm).validate() ) return;
		if( runningAjaxReq == true ){
			console.log(langLbl.requestProcessing);
			return;
		}
		runningAjaxReq = true;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Shops', 'setUpShopSpam'), data, function(t) {
			runningAjaxReq = false;
			if( t.status ){
				/* window.location.href = fcom.makeUrl('Shops', 'view', [frm.elements["shop_id"].value]); */
				document.frmShopReportSpam.reset();
			}
		});
		return false;
	}
})();