$(document).on('keyup', "input[name='product_name']", function(){
    var currObj = $(this);
    var selProdId = currObj.data('selprodid');
    var splPriceId = currObj.data('splpriceid');
    var selector = ".selProdId-"+selProdId+'-'+splPriceId;
    if('' != currObj.val()){
        currObj.autocomplete({'source': function(request, response) {
        		$.ajax({
        			url: fcom.makeUrl('SellerProducts', 'autoCompleteProducts'),
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
        		$("input[name='splprice_selprod_id']"+selector).val(item['value']);
                currObj.val( item['label'] );
        	}
        });
    }else{
        $("input[name='splprice_selprod_id']"+selector).val('');
    }
});

$(document).on('blur', "input[name='splprice_price']", function(){
    var selProdId = $(this).data('selprodid');
    var splPriceId = $(this).data('splpriceid');
    var selector = "#frmSellerProductSpecialPrice-"+selProdId+'-'+splPriceId;
    $(selector).submit();
});


(function() {
    updateSpecialPrice = function(frm, selProdId, splPriceId){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'updateSpecialPrice'), data, function(t) {
            if(t.status == true){
                if (0 < selProdId) {
                    $('tr.selProdId-'+selProdId+'-'+splPriceId).hide();
                } else {
                    $("input[name='splprice_selprod_id'].selProdId-"+selProdId+'-'+splPriceId).val('');
                    frm.reset();
                }
                $("input[name='splprice_id'].selProdId-"+selProdId+'-'+splPriceId).val('');
                $('table.splPrice-'+selProdId+'-'+splPriceId+'-js tbody').append(t.data);
            }
			$(document).trigger('close.facebox');
		});
		return false;
	};

    edit = function(obj, splPriceId, selProdId){
        if (0 < $('tr.selProdId-0-0').length) {
            $.ajax({
                url: fcom.makeUrl('SellerProducts', 'editSelProdSpecialPrice'),
                data: {fIsAjax:1,splprice_id:splPriceId},
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    var selectorClass = 'selProdId-0-0';
                    $("input[name='product_name']."+selectorClass).val(json.product_name);
                    $("input[name='splprice_price']."+selectorClass).val(json.splprice_price);
                    $("input[name='splprice_start_date']."+selectorClass).val(json.splprice_start_date);
                    $("input[name='splprice_end_date']."+selectorClass).val(json.splprice_end_date);
                    $("input[name='splprice_selprod_id']."+selectorClass).val(json.splprice_selprod_id);
                    $("input[name='splprice_id']."+selectorClass).val(json.splprice_id);
                    $('tr.'+selectorClass).fadeIn();
                    $(document).trigger('close.facebox');
                },
            });
        } else {
            var selectorClass = 'selProdId-'+selProdId+'-'+splPriceId;
            if (0 < $('tr.selProdId-'+selProdId+'-0').length) {
                var selectorClass = 'selProdId-'+selProdId+'-0';
            }

            $("input[name='splprice_id']."+selectorClass).val(splPriceId);
            $('tr.'+selectorClass).fadeIn();
        }
        obj.parentsUntil('tr').parent().remove();
		return false;
    };

    remove = function(obj, splPriceId, selProdId){
		if( !confirm(langLbl.confirmDelete) ){
            return false;
        }

        data = 'splprice_id=' + splPriceId;
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'deleteSellerProductSpecialPrice'), data, function(t) {
            var selectorClass = 'selProdId-'+selProdId+'-'+splPriceId;
            if (0 < $('tr.selProdId-0-0').length) {
                var selectorClass = 'selProdId-0-0';
                selProdId = 0;
            } else if (0 < $('tr.selProdId-'+selProdId+'-0').length) {
                var selectorClass = 'selProdId-'+selProdId+'-0';
            }
            var formSelector = "frmSellerProductSpecialPrice-"+selProdId+'-'+splPriceId;
            if (0 < $("#frmSellerProductSpecialPrice-0-0").length) {
                formSelector = "frmSellerProductSpecialPrice-0-0";
            } else if (0 < $("#frmSellerProductSpecialPrice-"+selProdId+'-0').length) {
                formSelector = "frmSellerProductSpecialPrice-"+selProdId+'-0';
            }
            console.log(formSelector);
            document.getElementById(formSelector).reset();

            $('tr.'+selectorClass).fadeIn();
            obj.parentsUntil('tr').parent().remove();

			$(document).trigger('close.facebox');
		});
    };
})();
