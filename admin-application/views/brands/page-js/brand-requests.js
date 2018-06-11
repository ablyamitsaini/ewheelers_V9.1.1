$(document).ready(function(){
	searchProductBrands(document.frmSearch);					   
});
$(document).delegate('.language-js','change',function(){
	var lang_id = $(this).val();
	var brand_id = $("input[name='brand_id']").val();
	brandImages(brand_id,lang_id);
});
(function() {
	var currentPage = 1;
	var runningAjaxReq = false;

	goToSearchPage = function(page) {	
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmBrandSearchPaging;		
		$(frm.page).val(page);
		searchProductBrands(frm);
	}

	reloadList = function() {
		var frm = document.frmBrandSearchPaging;
		searchProductBrands(frm);
	}

	

	setupBrand = function(frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('brands', 'setupRequest'), data, function(t) {
			reloadList();
			if (t.langId>0) {
				brandRequestLangForm(t.brandId, t.langId);
				return ;
			}
			if (t.openMediaForm)
			{
				brandRequestMediaForm(t.brandId);
				return;
			}
			/* $(document).trigger('close.facebox'); */
		});
	};

	brandRequestLangForm = function(brandId, langId) {
	fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('brands', 'requestLangForm', [brandId, langId]), '', function(t) {
				fcom.updateFaceboxContent(t);
			});
			};
	
	setupBrandLang=function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('brands', 'langSetup'), data, function(t) {
			reloadList();				
			if (t.langId>0) {
				brandRequestLangForm(t.brandId, t.langId);
				return ;
			}
			if (t.openMediaForm)
			{
				brandRequestMediaForm(t.brandId);
				return;
			}
			/* $(document).trigger('close.facebox'); */
		});
	};

	searchProductBrands = function(form){
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		$("#listing").html('Loading....');
		fcom.ajax(fcom.makeUrl('brands','searchBrandRequests'),data,function(res){
			$("#listing").html(res);
		});
	};
	
	brandRequestMediaForm = function(brandId){
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('brands', 'requestMedia', [brandId]), '', function(t) {
			brandImages(brandId);
			fcom.updateFaceboxContent(t);
		});
	};
	
	brandImages = function(brandId,lang_id){
		fcom.ajax(fcom.makeUrl('Brands', 'images', [brandId,lang_id]), '', function(t) {
			$('#image-listing').html(t);
			fcom.resetFaceboxHeight();
		});
	};
	
	deleteRecord = function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.ajax(fcom.makeUrl('brands','deleteRecord'),data,function(res){		
			reloadList();
		});
	};
	
	clearSearch = function(){
		document.frmSearch.reset();
		searchProductBrands(document.frmSearch);
	};
	
	deleteImage = function( brandId, langId ){
		if(!confirm(langLbl.confirmDeleteLogo)){return;}
		fcom.updateWithAjax(fcom.makeUrl('brands', 'removeBrandLogo',[brandId, langId]), '', function(t) {
			brandImages(brandId,langId);
			reloadList();
		});
	};

	addBrandRequestForm= function(id){

		$.facebox(function() {brandRequestForm(id)
			
		});
	}
	brandRequestForm = function(id) {
		fcom.displayProcessing();
		var frm = document.frmBrandSearchPaging;			
			fcom.ajax(fcom.makeUrl('brands', 'requestForm', [id]), '', function(t) {
				fcom.updateFaceboxContent(t);
		});
	};
	
	showHideCommentBox = function(val){
		if(val == 2){
			$('#div_comments_box').removeClass('hide');
		}else{
			$('#div_comments_box').addClass('hide');
		}		
	};

})();

$(document).on('click','.uploadFile-Js',function(){
	var node = this;
	$('#form-upload').remove();	
	/* var brandId = document.frmProdBrandLang.brand_id.value;
	var langId = document.frmProdBrandLang.lang_id.value; */
	
	var brandId = $(node).attr( 'data-brand_id' );	
	var langId = document.frmBrandMedia.brand_lang_id.value;
	
	var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
	frm = frm.concat('<input type="file" name="file" />'); 
	frm = frm.concat('<input type="hidden" name="brand_id" value="' + brandId + '"/>'); 	
	frm = frm.concat('<input type="hidden" name="lang_id" value="' + langId + '"/>'); 	
	frm = frm.concat('</form>'); 	
	$( 'body' ).prepend( frm );
	$('#form-upload input[name=\'file\']').trigger('click');
	if ( typeof timer != 'undefined' ) {
		clearInterval(timer);
	}	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			$val = $(node).val();			
			$.ajax({
				url: fcom.makeUrl('Brands', 'uploadLogo'),
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
						$('.text-danger').remove();
						$('#input-field').html(ans.msg);						
						if( ans.status == true ){
							$('#input-field').removeClass('text-danger');
							$('#input-field').addClass('text-success');
							$('#form-upload').remove();
							brandImages(ans.brandId,langId);
						}else{
							$('#input-field').removeClass('text-success');
							$('#input-field').addClass('text-danger');
						}
						reloadList();
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});			
		}
	}, 500);
});
