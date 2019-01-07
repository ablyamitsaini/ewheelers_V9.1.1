$(document).ready(function(){
	searchOptions(document.frmOptionSearch);
});

(function() {
	var currentPage = 1;
	var runningAjaxReq = false;

	goToSearchPage = function(page) {	
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmOptionsSearchPaging;		
		$(frm.page).val(page);
		searchOptions(frm);
	}

	reloadList = function() {
		var frm = document.frmOptionsSearchPaging;
		searchOptions(frm);
	}
	
	optionForm = function(optionId){
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Seller', 'optionForm', [optionId]), '', function(t) {	
				try{
					res= jQuery.parseJSON(t);
					$.facebox(res.msg,'faceboxWidth');
				}catch (e){
					
					$.facebox(t,'faceboxWidth');
					addOptionForm(optionId);	
					optionValueListing(optionId);
				}
				fcom.resetFaceboxHeight();
			});
		});
	}
	
	addOptionForm = function(optionId){
		var dv = $('#loadForm');
		fcom.ajax(fcom.makeUrl('Seller', 'addOptionForm', [optionId]), '', function(t) {				
			dv.html(t);	
			fcom.resetFaceboxHeight();			
		});
	};
	
	optionValueListing = function(optionId){
		if(optionId == 0 ) { $('#showHideContainer').addClass('hide'); return ;}
		var dv =$('#optionValueListing');
		dv.html('Loading....');
		var data = 'option_id='+optionId;		
		fcom.ajax(fcom.makeUrl('OptionValues','search'),data,function(res){
			dv.html(res);
			/* fcom.resetFaceboxHeight();	 */
		});
	};
	
	optionValueForm = function (optionId,id){
		var dv = $('#loadForm');
		fcom.ajax(fcom.makeUrl('OptionValues', 'form', [optionId,id]), '', function(t) {				
			dv.html(t);		
			jscolor.installByClassName('jscolor');
			/* fcom.resetFaceboxHeight();	 */
		});
	};
	
	setUpOptionValues = function(frm) {
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'setup'), data, function(t) {						
			$.mbsmessage.close();
			if (t.optionId > 0 ) {
				optionValueListing(t.optionId);
				optionValueForm(t.optionId,0);
				fcom.resetFaceboxHeight();
				return ;
			}
			$(document).trigger('close.facebox');
		});
	};
	
	deleteOptionValue = function(optionId,id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id+'&option_id='+optionId;
		fcom.updateWithAjax(fcom.makeUrl('OptionValues','deleteRecord'),data,function(res){		
			$.mbsmessage.close();
			optionValueListing(optionId);
			optionValueForm(optionId,0);
			fcom.resetFaceboxHeight();
		});
	}
	
	optionValueSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmSearchOptionValuePaging;		
		$(frm.page).val(page);
		searchOptionValueListing(frm);
	};
	
	searchOptionValueListing = function(form){		
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		$("#optionValueListing").html('Loading....');
		fcom.ajax(fcom.makeUrl('OptionValues','search'),data,function(res){
			$("#optionValueListing").html(res);
			/* fcom.resetFaceboxHeight(); */
		});
	};
	
	showHideValues = function(obj){
		
		var type =obj.value; 
		var data ='optionType='+type;
		fcom.ajax(fcom.makeUrl('Options','canSetValue'),data,function(t){
			var res = $.parseJSON(t);
			if(res.hideBox == true){
				$('#showHideContainer').addClass('hide'); return ;
			}
			$('#showHideContainer').removeClass('hide');
		});
	};
	
	submitOptionForm=function(frm,fn){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupOptions'), data, function(t) {
			reloadList();
			$.mbsmessage.close();
			if(t.optionId > 0){ 
				optionForm(t.optionId); return;
			}
			fcom.resetFaceboxHeight();			
			$(document).trigger('close.facebox');
		});	
	};		

	searchOptions = function(form){
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		/*]*/
		$("#optionListing").html('Loading....');
		
		fcom.ajax(fcom.makeUrl('seller','searchOptions'),data,function(res){
			$("#optionListing").html(res);
			fcom.resetFaceboxHeight();
		});
	};
	
	deleteOptionRecord=function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.ajax(fcom.makeUrl('seller','deleteSellerOption'),data,function(t){
			var ans= jQuery.parseJSON(t);
			if(ans.status!=1){
				$.mbsmessage(ans.msg, true, 'alert--danger');
			}
			$.mbsmessage(ans.msg, true, 'alert--success');
			reloadList();		
			
		});
	};
	
	clearOptionSearch = function(){
		document.frmOptionSearch.reset();
		searchOptions(document.frmOptionSearch);
	};

})();
