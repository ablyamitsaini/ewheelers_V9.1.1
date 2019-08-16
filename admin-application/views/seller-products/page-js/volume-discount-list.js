$(document).ready(function(){
});
(function() {
    sellerProductVolumeDiscountForm = function( selprod_id, voldiscount_id ){
		if( typeof voldiscount_id == undefined || voldiscount_id == null ){
			voldiscount_id = 0;
		}
		$.facebox(function() {
			fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('SellerProducts', 'sellerProductVolumeDiscountForm', [selprod_id, voldiscount_id ]), '', function(t) {
				fcom.updateFaceboxContent(t);
			});
		});
	};

    deleteSellerProductVolumeDiscount = function( voldiscount_id ){
		var agree = confirm(langLbl.confirmDelete);
		if( !agree ){ return false; }
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'deleteSellerProductVolumeDiscount'), 'voldiscount_id=' + voldiscount_id, function(t) {
			location.reload();
		});
	}

    setUpSellerProductVolumeDiscount = function(frm){
		if (!$(frm).validate()) return;

		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'setUpSellerProductVolumeDiscount'), data, function(t) {
			$(document).trigger('close.facebox');
            location.reload();
		});
		return false;
	};
    updateVolumeDiscount = function(){
        if (typeof $(".selectItem--js:checked").val() === 'undefined') {
	        $.systemMessage(langLbl.atleastOneRecord, 'alert--danger');
	        return false;
	    }
		$("#frmVolDiscountListing").attr('action', fcom.makeUrl('SellerProducts','addVolumeDiscount')).submit();
	};
    deleteVolumeDiscount = function(){
        if (typeof $(".selectItem--js:checked").val() === 'undefined') {
	        $.systemMessage(langLbl.atleastOneRecord, 'alert--danger');
	        return false;
	    }
        var agree = confirm(langLbl.confirmDelete);
		if( !agree ){ return false; }
        var data = fcom.frmData(document.getElementById('frmVolDiscountListing'));
        fcom.ajax(fcom.makeUrl('SellerProducts', 'deleteVolumeDiscountArr'), data, function(t) {
            var ans = $.parseJSON(t);
            if( ans.status == 1 ){
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
            location.reload();
        });
	};
})();
