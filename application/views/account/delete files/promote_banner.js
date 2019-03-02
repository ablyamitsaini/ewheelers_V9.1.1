$(document).ready(function() {
	promotionGeneralForm();	
	$('.time').datetimepicker({
			datepicker: false,
			format:'H:i',
			step: 30
	});
	
	$( "#promotion_budget_period,#promotion_start_date" ).change(function() {
		var new_date = AddDaysToDate($("#promotion_start_date").val(),$("#promotion_budget_period").val(),"-")
		$("#promotion_end_date").val(new_date);
	});
	
	$( "#promotion_banner_position" ).change(function() {
		if($(this).val()){
			$("#banner_position").html("<div class='banner_position_div'><img src="+ siteConstants.webroot +"images/banner-positions/"+$(this).val()+".jpg ></div>");
		}else{
			$("#banner_position").html('');
		}
	});
});

(function() {
	var runningAjaxReq = false;
	var dv = '#promotionFormBlock';
	var dvt = '#promotionFormChildBlock';
	
	promotionGeneralForm = function(promotionId = 0){
		// alert(promotionId);
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'promotionBannerForm',[promotionId]), '', function(t) {		
			 $(dv).html(t);
		});
	};
	
	promotionLangForm = function(promotionId , langId){
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'promoteBannerLangForm',[promotionId,langId]), '', function(t) {			
			$(dv).html(t);
			fcom.setEditorLayout(langId);	
			var frm = $(dv+' form')[0];
			var validator = $(frm).validation({errordisplay: 3});
			$(frm).submit(function(e) {
				e.preventDefault();
				if (validator.validate() == false) {	
					return ;
				}
				var data = fcom.frmData(frm);
				fcom.updateWithAjax(fcom.makeUrl('Account', 'setupPromotionLang'), data, function(t) {		
					runningAjaxReq = false; 
					$.mbsmessage.close();	
									
					if (t.langId > 0 && t.promotionId > 0) {
						promoteBannerLangForm(t.promotionId , t.langId);
						return;
					}
					shopForm();			
				});
			});	
		});
	}
	
})();
