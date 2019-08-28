$(document).ready(function(){
    searchSpecialPriceProducts(document.frmSearch);
    $('.start_date_js').datepicker('option', {minDate: new Date()});
    $('.end_date_js').datepicker('option', {minDate: new Date()});
});
$(document).on('keyup', "#frmAddSpecialPrice input[name='product_name']", function(){
    var currObj = $(this);
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
        		$("input[name='splprice_selprod_id']").val(item['value']);
                currObj.val( item['label'] );
        	}
        });
    }else{
        $("input[name='splprice_selprod_id']").val('');
    }
});

$(document).on('click', 'table.splPriceList-js tr td .js--editCol', function(){
    $(this).hide();
    var input = $(this).siblings('input[type="text"]');
    var value = input.val();
    input.fadeIn();
    input.val('').focus().val(value);
});

$(document).on('blur', ".js--splPriceCol", function(){
    var currObj = $(this);
    var value = currObj.val();
    var oldValue = currObj.attr('data-val');
    var attribute = currObj.attr('name');
    var id = currObj.data('id');
    var selProdId = currObj.data('selprodid');
    if ('' != value && value != oldValue) {
        var data = 'attribute='+attribute+"&splprice_id="+id+"&selProdId="+selProdId+"&value="+value;
        fcom.ajax(fcom.makeUrl('SellerProducts', 'updateSpecialPriceColValue'), data, function(t) {
            var ans = $.parseJSON(t);
            if( ans.status != 1 ){
                $.systemMessage(ans.msg, 'alert--danger');
                value = oldValue;
            } else {
                value = ans.data.value;
                currObj.attr('data-val', value);
            }
            currObj.val(value);
            showElement(currObj, value);
        });
    } else {
        showElement(currObj, oldValue);
        currObj.val(oldValue);
    }
    return false;
});
(function() {
    showElement = function(currObj, value){
        currObj.siblings('div').text(value).fadeIn();
        currObj.hide();
    };

	var dv = '#listing';
	searchSpecialPriceProducts = function(frm){

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).html( fcom.getLoader() );

		fcom.ajax(fcom.makeUrl('SellerProducts','searchSpecialPriceProducts'),data,function(res){
			$("#listing").html(res);
		});
	};
    clearSearch = function(){
		document.frmSearch.reset();
		searchSpecialPriceProducts(document.frmSearch);
	};
    goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearchSpecialPricePaging;
		$(frm.page).val(page);
		searchSpecialPriceProducts(frm);
	}

	reloadList = function() {
		var frm = document.frmSearch;
		searchSpecialPriceProducts(frm);
	}
    deleteSellerProductSpecialPrice = function( splPrice_id ){
		var agree = confirm(langLbl.confirmDelete);
		if( !agree ){
			return false;
		}
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'deleteSellerProductSpecialPrice'), 'splprice_id=' + splPrice_id, function(t) {
            $('tr#row-'+splPrice_id).remove();
		});
	}
    deleteSpecialPriceRows = function(){
        if (typeof $(".selectItem--js:checked").val() === 'undefined') {
	        $.systemMessage(langLbl.atleastOneRecord, 'alert--danger');
	        return false;
	    }
        var agree = confirm(langLbl.confirmDelete);
		if( !agree ){ return false; }
        var data = fcom.frmData(document.getElementById('frmSplPriceListing'));
        fcom.ajax(fcom.makeUrl('SellerProducts', 'deleteSpecialPriceRows'), data, function(t) {
            var ans = $.parseJSON(t);
			if( ans.status == 1 ){
				$.systemMessage(ans.msg, 'alert--success');
                $('.formActionBtn-js').addClass('formActions-css');
			} else {
                $.systemMessage(ans.msg, 'alert--danger');
			}
            searchSpecialPriceProducts(document.frmSearch);
        });
	};
    updateSpecialPrice = function(frm, selProd_id){
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('SellerProducts', 'updateSpecialPrice'), data, function(t) {
            if(t.status == true){
                if ((1 > frm.addMultiple.value && 1 > frm.lastRow.value) || 0 < selProd_id) {
                    if (1 > selProd_id) {
                        $("input[name='splprice_selprod_id']").val('');
                    }
                    frm.reset();
                }
                document.getElementById('frmSplPriceListing').reset()
                $('table.splPriceList-js tbody').prepend(t.data);
            }
			$(document).trigger('close.facebox');
            if (0 < $('.defaultForm.hidden').length && 0 < frm.lastRow.value) {
                $('.defaultForm.hidden').removeClass('defaultForm hidden');
            }
            if (0 < frm.addMultiple.value && 1 > selProd_id) {
                var splPriceRow = $("#"+frm.id).parent().parent();
                splPriceRow.siblings('.divider:first').remove();
                splPriceRow.remove();
            }
		});
		return false;
	};
})();
