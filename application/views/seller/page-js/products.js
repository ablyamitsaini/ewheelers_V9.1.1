$(document).ready(function(){
	loadSellerProducts(document.frmSearchSellerProducts);
});

$(document).delegate('.selprodoption_optionvalue_id','change',function(){
	var frm = document.frmSellerProduct;
	var selprodId = $( frm.selprod_id ).val();
	$( frm.selprod_id ).val('');
	var data = fcom.frmData(frm);
	fcom.ajax(fcom.makeUrl('Seller', 'checkSellProdAvailableForUser'), data, function(t) {
		var ans = $.parseJSON(t);
		$( frm.selprod_id ).val(selprodId);
		if( ans.status == 0 ){
			$.mbsmessage( ans.msg,false,'alert alert--danger');
			return;
		}
		$.mbsmessage.close();
	});
});

(function() {
	var runningAjaxReq = false;
	//var dv = '#sellerProductsForm';
	var dv = '#listing';
	
	checkRunningAjax = function(){
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};
	
	loadSellerProducts = function(frm){
		sellerProducts($( frm.product_id ).val());
	};
	
	sellerProducts = function(product_id){
		$('#listing').html(fcom.getLoader());
		/* if product id is not passed, then it will become or will fetch custom products of that seller. */
		if( typeof product_id == undefined || product_id == null ){
			product_id = 0;
		}
		var data = fcom.frmData(document.frmSearch);
		fcom.ajax(fcom.makeUrl('Seller', 'sellerProducts', [ product_id ]), data, function(t) {
			$('#listing').html(t);
		});
	}
	
	goToSellerProductSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearch;		
		$(frm.page).val(page);
		loadSellerProducts(frm);
	}
	sellerProductForm = function(product_id, selprod_id){
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'sellerProductForm', [ product_id, selprod_id ]), '', function(t) {
			$(dv).html(t);
		});
	}; 
	sellerProductDelete=function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.updateWithAjax(fcom.makeUrl('Seller','sellerProductDelete'),data,function(res){		
			loadSellerProducts(document.frmSearchSellerProducts);
		});
	};
	
	sellerProductCloneForm = function(product_id, selprod_id){
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Seller', 'sellerProductCloneForm', [ product_id, selprod_id ]), '', function(t) {
				$.facebox(t,'faceboxWidth');
			});
		});
	};
	
	setUpSellerProductClone = function(frm){
		if (!$(frm).validate()) return;
		runningAjaxReq = true;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpSellerProductClone'), data, function(t) {
			runningAjaxReq = false;
			$("#facebox .close").trigger('click');
			loadSellerProducts(document.frmSearchSellerProducts);
			/* if(t.selprod_id > 0){
				$(frm.splprice_selprod_id).val(t.selprod_id);
			}	 */	
		});
	};
	
	
	toggleSellerProductStatus = function(e,obj){
		if(!confirm(langLbl.confirmUpdateStatus)){
			e.preventDefault();
			return;
		}
		var selprodId = parseInt(obj.value);
		if( selprodId < 1 ){
			return false;
		}
		data='selprodId='+selprodId;
		fcom.ajax(fcom.makeUrl('Seller','changeProductStatus'),data,function(res){
			var ans = $.parseJSON(res);
			if( ans.status == 1 ){
				$.mbsmessage(ans.msg, true, 'alert alert--success');
			} else {
				$.mbsmessage(ans.msg, true, 'alert alert--danger');
			}
			/* loadSellerProducts(document.frmSearchSellerProducts); */
		}); 
	};
	
	clearSearch = function(){
		document.frmSearch.reset();
		loadSellerProducts(document.frmSearchSellerProducts);
	};
	
})();	