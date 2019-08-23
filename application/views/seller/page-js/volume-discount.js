$(document).ready(function(){
    searchVolumeDiscountProducts(document.frmSearch);
});
$(document).on('keyup', "#frmAddVolumeDiscount input[name='product_name']", function(){
    var currObj = $(this);
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
        		$("input[name='voldiscount_selprod_id']").val(item['value']);
                currObj.val( item['label'] );
        	}
        });
    }else{
        $("input[name='voldiscount_selprod_id']").val('');
    }
});

$(document).on('click', 'table.volDiscountList-js tr td .js--editCol', function(){
    $(this).hide();
    var input = $(this).siblings('input[type="text"]');
    var value = input.val();
    input.fadeIn();
    input.val('').focus().val(value);
});

$(document).on('blur', ".js--volDiscountCol", function(){
    var currObj = $(this);
    var value = currObj.val();
    var oldValue = currObj.attr('data-val');
    var attribute = currObj.attr('name');
    var id = currObj.data('id');
    var selProdId = currObj.data('selprodid');
    if ('' != value && parseFloat(value) != parseFloat(oldValue)) {
        var data = 'attribute='+attribute+"&voldiscount_id="+id+"&selProdId="+selProdId+"&value="+value;
        fcom.ajax(fcom.makeUrl('Seller', 'updateVolumeDiscountValue'), data, function(t) {
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
	searchVolumeDiscountProducts = function(frm){

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).html( fcom.getLoader() );

		fcom.ajax(fcom.makeUrl('Seller','searchVolumeDiscountProducts'),data,function(res){
			$("#listing").html(res);
		});
	};
    clearSearch = function(){
		document.frmSearch.reset();
		searchVolumeDiscountProducts(document.frmSearch);
	};
    goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearchSpecialPricePaging;
		$(frm.page).val(page);
		searchVolumeDiscountProducts(frm);
	}

	reloadList = function() {
		var frm = document.frmSearch;
		searchVolumeDiscountProducts(frm);
	}
	addVolumeDiscount = function() {
		window.open(fcom.makeUrl('Seller','addVolumeDiscount'), '_blank');
	}
    deleteSellerProductVolumeDiscount = function( voldiscount_id ){
		var agree = confirm(langLbl.confirmDelete);
		if( !agree ){
			return false;
		}
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteSellerProductVolumeDiscount'), 'voldiscount_id=' + voldiscount_id, function(t) {
            $('tr#row-'+voldiscount_id).remove();
		});
	}
    deleteVolumeDiscount = function(){
        if (typeof $(".selectItem--js:checked").val() === 'undefined') {
	        $.systemMessage(langLbl.atleastOneRecord, 'alert--danger');
	        return false;
	    }
        var agree = confirm(langLbl.confirmDelete);
		if( !agree ){ return false; }
        var data = fcom.frmData(document.getElementById('frmVolDiscountListing'));
        fcom.ajax(fcom.makeUrl('Seller', 'deleteVolumeDiscountArr'), data, function(t) {
            var ans = $.parseJSON(t);
			if( ans.status == 1 ){
				$.systemMessage(ans.msg, 'alert--success');
                $('.formActionBtn-js').addClass('formActions-css');
			} else {
                $.systemMessage(ans.msg, 'alert--danger');
			}
            searchVolumeDiscountProducts(document.frmSearch);
        });
	};
    updateVolumeDiscount = function(frm){
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateVolumeDiscount'), data, function(t) {
            if(t.status == true){
                $("input[name='voldiscount_selprod_id']").val('');
                frm.reset();
                document.getElementById('frmVolDiscountListing').reset()
                $('table.volDiscountList-js tbody').prepend(t.data);
            }
			$(document).trigger('close.facebox');
		});
		return false;
	};

    setUpSellerProductVolumeDiscount = function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpSellerProductVolumeDiscount'), data, function(t) {
			$(document).trigger('close.facebox');
            searchVolumeDiscountProducts(document.frmSearch);
		});
		return false;
	};
})();
