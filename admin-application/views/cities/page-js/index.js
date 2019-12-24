$(document).ready(function(){
	searchCities(document.frmStateSearch);
});

(function() {
	var runningAjaxReq = false;
	var dv = '#listing';
	
	goToSearchPage = function(page) {	
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmStateSearchPaging;		
		$(frm.page).val(page);
		searchCities(frm);
	}

	reloadList = function() {
		var frm = document.frmStateSearchPaging;
		searchCities(frm);
	};	
	
	searchCities = function(form){		
		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		   
		$(dv).html(fcom.getLoader());
		
		fcom.ajax(fcom.makeUrl('Cities','search'),data,function(res){
			$(dv).html(res);			
		});
	};
	
	addCityForm = function(id) {
		$.facebox(function() {
			cityForm(id);
		});	
	}
	
	cityForm = function(id) {
		fcom.displayProcessing();
		
		//$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Cities', 'form', [id]), '', function(t) {
				//$.facebox(t,'faceboxWidth');
				fcom.updateFaceboxContent(t);
			});
		//});
	};
	editCityFormNew = function(cityId){
		$.facebox(function() {
			editCityForm(cityId);
		});
	};
	
	
	editCityForm = function(cityId){
		fcom.displayProcessing();
		//$.facebox(function() {
            fcom.ajax(fcom.makeUrl('Cities', 'form', [cityId]), '', function(t) {
				//$.facebox(t,'faceboxWidth');
                fcom.updateFaceboxContent(t);
			});
		//});
	};
	
	setupCity = function (frm){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
        console.log(data);
		fcom.updateWithAjax(fcom.makeUrl('Cities', 'setup'), data, function(t) {
			reloadList();
            if (t.langId>0) {
				editCityLangForm(t.cityId, t.langId);
				return ;
			}
			$(document).trigger('close.facebox');
		});
	}
	
	editCityLangForm = function(cityId,langId){
		fcom.displayProcessing();
		//$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Cities', 'langForm', [cityId,langId]), '', function(t) {
				//$.facebox(t,'faceboxWidth');
				fcom.updateFaceboxContent(t);
			});
		//});
	};
	
	setupLangCity = function (frm){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Cities', 'langSetup'), data, function(t) {
			reloadList();			
			if (t.langId>0) {
				editCityLangForm(t.cityId, t.langId);
				return ;
			}			
			$(document).trigger('close.facebox');
		});
	};
	
	toggleStatus = function(e,obj,canEdit){
		if(canEdit == 0){
			e.preventDefault();
			return;
		}
		if(!confirm(langLbl.confirmUpdateStatus)){
			e.preventDefault();
			return;
		}
		var cityId = parseInt(obj.value);
		if(cityId < 1){
			fcom.displayErrorMessage(langLbl.invalidRequest);
			return false;
		}
		data='cityId='+cityId;
		fcom.ajax(fcom.makeUrl('Cities','changeStatus'),data,function(res){
		var ans =$.parseJSON(res);
			if( ans.status == 1 ){
				fcom.displaySuccessMessage(ans.msg);				
				$(obj).toggleClass("active");
			}
			else{
				fcom.displayErrorMessage(ans.msg);				
			}
		});
	};
	
	clearSearch = function(){
		document.frmSearch.reset();
		searchCities(document.frmSearch);
	};
    
    getCountryStates = function( countryId, stateId, dv ){
        fcom.ajax(fcom.makeUrl('Cities','getStates',[countryId,stateId]),'',function(res){
            $(dv).empty();
            $(dv).append(res);
        });
    }
    
    
})();	