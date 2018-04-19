function listPages(p){
	$('body').prepend('<form id="form-paging" method="POST" style="display: none;" ><input type="hidden" name="page" /></form>');
	$('#form-paging input[name=\'page\']').val(p);
	$('#form-paging').submit();
}
$(document).ready(function(){
	searchPromotions(document.frmSearchPromotions);
});
(function() {
	var runningAjaxReq = false;
	var dv = '#promotions';
	
	var runningAjaxReq = false;
	
	var productId =0;
	checkRunningAjax = function(){
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};
	
	searchPromotions = function(frm,el){
		checkRunningAjax();
		var data = fcom.frmData(frm);
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account','searchPromotions'),data,function(res){
			runningAjaxReq = false;
			$(dv).html(res);
			$(el).parent().siblings().removeClass('is-active');
			$(el).parent().addClass('is-active');
		});
	};
	
	goToPromotionSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page = 1;
		}
		var frm = document.frmPromotionSearchPaging;		
		$(frm.page).val(page);
		searchPromotions(frm);
	};
	
	promotionGeneralForm = function(promotionId = 0,el = '',type = 0){
		// alert(promotionId);
		$(dv).html(fcom.getLoader());
		if(type == 1)
		{
			fcom.ajax(fcom.makeUrl('Account', 'promotionProductForm',[promotionId]), '', function(t) {		
			 $(dv).html(t);
			 $(el).parent().siblings().removeClass('is-active');
			 $(el).parent().addClass('is-active');
			});
		}
		else if(type == 2)
		{
			fcom.ajax(fcom.makeUrl('Account', 'promotionShopForm',[promotionId]), '', function(t) {		
			 $(dv).html(t);
			 $(el).parent().siblings().removeClass('is-active');
			 $(el).parent().addClass('is-active');
			});
		}
		else
		{
			fcom.ajax(fcom.makeUrl('Account', 'promotionBannerForm',[promotionId]), '', function(t) {		
			 $(dv).html(t);
			 $(el).parent().siblings().removeClass('is-active');
			 $(el).parent().addClass('is-active');
			});
		}
	};
	
	setupPromotionForm = function(frm){
		
		if (!$(frm).validate()) return;
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
		addingNew = ($(frm.promotion_id).val() == 0);
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setupPromotionForm'), (data), function(t) {
			runningAjaxReq = false;
			$.mbsmessage.close();
			if (addingNew) {
				promotionLangForm(t.promotionId, t.langId);
				return ;
			}
			promotionId =  t.promotion_id;
		});
	}
	
	
	promotionLangForm = function(promotionId , langId){
		$(dv).html(fcom.getLoader());
		fcom.resetEditorInstance();
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
					fcom.resetEditorInstance();					
					if (t.langId > 0 && t.promotionId > 0) {
						promotionLangForm(t.promotionId , t.langId);
						return;
					}	
				});
			});	
		});
	}
	
	promotionMediaForm = function (promotionId){
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'promotionMediaForm',[promotionId]), '', function(t) {			
			$(dv).html(t);
		});
	};
	
	removePromotionMedia = function( promotionId,afileId ){
		var agree = confirm( langLbl.confirmRemove );
		if( !agree ){
			return false;
		}
		fcom.updateWithAjax(fcom.makeUrl('Account', 'removePromotionMedia',[promotionId,afileId]), '', function(t) {
			promotionMediaForm( promotionId );
		});
	};
	
	$(document).on('click','.shopFile-Js',function(){
		var node = this;
		$('#form-upload').remove();
		var frmName = $(node).attr('data-frm');
		var fileType = $(node).attr('data-file_type');	
		var fileId = $(node).attr('data-id');	
		/* if('frmPromotionMedia' == frmName){
			var lang_id = document.frmPromotionMedia.lang_id.value;
		} */
		var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
		frm = frm.concat('<input type="file" name="file" />'); 
		frm = frm.concat('<input type="hidden" name="promotion_id" value="' + fileId + '">');
		frm = frm.concat('<input type="hidden" name="file_type" value="'+fileType+'"></form>'); 
		$('body').prepend(frm);
		$('#form-upload input[name=\'file\']').trigger('click');
		if (typeof timer != 'undefined') {
			clearInterval(timer);
		}	
		timer = setInterval(function() {
			if ($('#form-upload input[name=\'file\']').val() != '') {
				clearInterval(timer);
				$val = $(node).val();
				$.ajax({
					url: fcom.makeUrl('Account', 'uploadPromotionMedia'),
					type: 'post',
					dataType: 'json',
					data: new FormData($('#form-upload')[0]),
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$(node).val('Loading');
					},
					complete: function() {
						$(node).val($val);
					},
					success: function(ans) {
						$.mbsmessage(ans.msg, true, 'alert alert--success');
						$('.text-danger').remove();
						$('#input-field'+fileType).html(ans.msg);						
						if(ans.status == true){
							$('#input-field'+fileType).removeClass('text-danger');
							$('#input-field'+fileType).addClass('text-success');
							promotionMediaForm( ans.promotionId );
						}else{
							$('#input-field'+fileType).removeClass('text-success');
							$('#input-field'+fileType).addClass('text-danger');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
					});			
			}
		}, 500);
	});
})();