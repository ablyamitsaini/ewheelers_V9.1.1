$(document).ready(function(){
	searchBrandRequests(document.frmBrandReqSearch);
});
(function() {
	var currentPage = 1;
	var runningAjaxReq = false;

	goToSearchPage = function(page) {	
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmBrandReqSearchPaging;		
		$(frm.page).val(page);
		searchBrandRequests(frm);
	}

	reloadList = function() {
		var frm = document.frmBrandReqSearchPaging;
		searchBrandRequests(frm);
	}

	addBrandReqForm = function(id) {			
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('BrandRequests', 'form', [id]), '', function(t) {
				$.facebox(t,'faceboxWidth');
			});
		});
	};

	setupBrandReq = function(frm) {
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'setup'), data, function(t) {
			reloadList();
			if (t.langId>0) {
				addBrandReqLangForm(t.brandReqId, t.langId);
				return ;
			}
			$(document).trigger('close.facebox');
		});
	};

	addBrandReqLangForm = function(sBrandReqId, langId) {		
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('BrandRequests', 'langForm', [sBrandReqId, langId]), '', function(t) {
				$.facebox(t);
			});
		});
	};
	
	setupBrandReqLang = function(frm){ 
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'langSetup'), data, function(t) {
			reloadList();				
			if (t.langId>0) {
				addBrandReqLangForm(t.brandReqId, t.langId);
				return ;
			}
			$(document).trigger('close.facebox');
		});
	};

	searchBrandRequests = function(form){		
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		/*]*/
		$("#tagListing").html('Loading....');
		
		fcom.ajax(fcom.makeUrl('BrandRequests','search'),data,function(res){
			$("#tagListing").html(res);
		});
	};
	
	deleteBrandReqRecord = function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.ajax(fcom.makeUrl('BrandRequests','deleteRecord'),data,function(res){		
			reloadList();
		});
	};
	
	clearBrandReqSearch = function(){
		document.frmBrandReqSearch.reset();
		searchBrandRequests(document.frmBrandReqSearch);
	};
	
	updateBrandRequest= function(id){
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('BrandRequests', 'updateBrandRequestForm', [id]), '', function(t) {
				$.facebox(t,'faceboxWidth');
			});
		});
	}
	
	showHideCommentBox = function(val){
		if(val == 2){
			$('#div_comments_box').removeClass('hide');
			//supplierRequestFormValidator['comments']={"required":true};	
		}else{
			$('#div_comments_box').addClass('hide');
			//supplierRequestFormValidator['comments']={"required":false};
		}		
	};
	
	updateBrandRequest = function (frm){
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'updateBrandRequest'), data, function(t) {			
			reloadList();			
			$(document).trigger('close.facebox');
		});
	};
})();
