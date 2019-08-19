$(document).on('keyup', "input[name='product_name']", function(){
    var currObj = $(this);
    var selProdId = currObj.data('selprodid');
    var volDiscountId = currObj.data('voldiscountid');
    var selector = ".selProdId-"+selProdId+'-'+volDiscountId;
    if('' != currObj.val()){
        currObj.autocomplete({'source': function(request, response) {
        		$.ajax({
        			url: fcom.makeUrl('Seller', 'autoCompleteProducts'),
        			data: {keyword: request,fIsAjax:1,keyword:currObj.val()},
        			dataType: 'json',
        			type: 'post',
        			success: function(json) {
        				response($.map(json, function(item) {
        					return { label: item['name'], value: item['id']	};
        				}));
        			},
        		});
        	},
        	'select': function(item) {
        		$("input[name='voldiscount_selprod_id']"+selector).val(item['value']);
                currObj.val( item['label'] );
        	}
        });
    }else{
        $("input[name='voldiscount_selprod_id']"+selector).val('');
    }
});

$(document).on('blur', "input[name='voldiscount_percentage']", function(e){
    var selProdId = $(this).data('selprodid');
    var volDiscountId = $(this).data('voldiscountid');
    var selector = "#frmSellerProductVolumeDiscount-"+selProdId+'-'+volDiscountId;
    $(selector).submit();
});


(function() {
    updateVolumeDiscount = function(frm, selProdId, volDiscountId){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateVolumeDiscount'), data, function(t) {
            if(t.status == true){
                if (0 < selProdId) {
                    $('tr.selProdId-'+selProdId+'-'+volDiscountId).hide();
                } else {
                    $("input[name='voldiscount_selprod_id'].selProdId-"+selProdId+'-'+volDiscountId).val('');
                    frm.reset();
                }
                $("input[name='voldiscount_id'].selProdId-"+selProdId+'-'+volDiscountId).val('');
                $('table.volDiscount-'+selProdId+'-'+volDiscountId+'-js tbody').append(t.data);
            }
			$(document).trigger('close.facebox');
		});
		return false;
	};

    edit = function(obj, volDiscountId, selProdId){
        if (0 < $('tr.selProdId-0-0').length) {
            $.ajax({
                url: fcom.makeUrl('Seller', 'editVolumeDiscount'),
                data: {fIsAjax:1,voldiscount_id:volDiscountId},
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    var selectorClass = 'selProdId-0-0';
                    $("input[name='product_name']."+selectorClass).val(json.product_name);
                    $("input[name='voldiscount_min_qty']."+selectorClass).val(json.voldiscount_min_qty);
                    $("input[name='voldiscount_percentage']."+selectorClass).val(json.voldiscount_percentage);
                    $("input[name='voldiscount_selprod_id']."+selectorClass).val(json.voldiscount_selprod_id);
                    $("input[name='voldiscount_id']."+selectorClass).val(json.voldiscount_id);
                    $('tr.'+selectorClass).fadeIn();
                    $(document).trigger('close.facebox');
                },
            });
        } else {
            var selectorClass = 'selProdId-'+selProdId+'-'+volDiscountId;
            if (0 < $('tr.selProdId-'+selProdId+'-0').length) {
                var selectorClass = 'selProdId-'+selProdId+'-0';
            }

            $("input[name='voldiscount_id']."+selectorClass).val(volDiscountId);
            $('tr.'+selectorClass).fadeIn();
        }
        obj.parentsUntil('tr').parent().remove();
		return false;
    };

    remove = function(obj, volDiscountId, selProdId){
		if( !confirm(langLbl.confirmDelete) ){
            return false;
        }

        data = 'voldiscount_id=' + volDiscountId;
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteSellerProductVolumeDiscount'), data, function(t) {
            var selectorClass = 'selProdId-'+selProdId+'-'+volDiscountId;
            if (0 < $('tr.selProdId-0-0').length) {
                var selectorClass = 'selProdId-0-0';
                selProdId = 0;
            } else if (0 < $('tr.selProdId-'+selProdId+'-0').length) {
                var selectorClass = 'selProdId-'+selProdId+'-0';
            }
            var formSelector = "frmSellerProductVolumeDiscount-"+selProdId+'-'+volDiscountId;
            if (0 < $("#frmSellerProductVolumeDiscount-0-0").length) {
                formSelector = "frmSellerProductVolumeDiscount-0-0";
            } else if (0 < $("#frmSellerProductVolumeDiscount-"+selProdId+'-0').length) {
                formSelector = "frmSellerProductVolumeDiscount-"+selProdId+'-0';
            }
            document.getElementById(formSelector).reset();

            $('tr.'+selectorClass).fadeIn();
            obj.parentsUntil('tr').parent().remove();

			$(document).trigger('close.facebox');
		});
    };
})();
