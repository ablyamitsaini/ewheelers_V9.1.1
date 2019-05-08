$(document).ready(function(){
	searchProductBrands(document.frmSearch);
});
$(document).on('change','.language-js',function(){
/* $(document).delegate('.language-js','change',function(){ */
	var lang_id = $(this).val();
	var brand_id = $("input[id='id-js']").val();
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

	addBrandForm= function(id){
		$.facebox(function() {brandForm(id); });
	};

	brandForm = function(id) {
		fcom.displayProcessing();
		var frm = document.frmBrandSearchPaging;
			fcom.ajax(fcom.makeUrl('brands', 'form', [id]), '', function(t) {
			fcom.updateFaceboxContent(t);

			});
	};

	setupBrand = function(frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('brands', 'setup'), data, function(t) {
			reloadList();
			if (t.langId>0) {
				brandLangForm(t.brandId, t.langId);
				return ;
			}
			if (t.openMediaForm)
			{
				brandMediaForm(t.brandId);
				return;
			}
			$(document).trigger('close.facebox');
		});
	};

	brandLangForm = function(brandId, langId) {
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('brands', 'langForm', [brandId, langId]), '', function(t) {
			fcom.updateFaceboxContent(t);
		});
	};

	setupBrandLang=function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Brands', 'langSetup'), data, function(t) {
			reloadList();
			if (t.langId>0) {
				brandLangForm(t.brandId, t.langId);
				return ;
			}
			if (t.openMediaForm)
			{
				brandMediaForm(t.brandId);
				return;
			}
			$(document).trigger('close.facebox');
		});
	};

	searchProductBrands = function(form){
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		$("#listing").html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Brands','Search'),data,function(res){
			$("#listing").html(res);
		});
	};

	brandImages = function(brandId,lang_id){
		fcom.ajax(fcom.makeUrl('Brands', 'images', [brandId,lang_id]), '', function(t) {
			$('#image-listing').html(t);
			fcom.resetFaceboxHeight();
		});
	};

	brandMediaForm = function(brandId){
		fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('Brands', 'media', [brandId]), '', function(t) {
				brandImages(brandId);
				fcom.updateFaceboxContent(t);
			});
	};

	deleteRecord = function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.updateWithAjax(fcom.makeUrl('brands','deleteRecord'),data,function(res){
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

	toggleStatus = function(e,obj,canEdit){
		if(canEdit == 0){
			e.preventDefault();
			return;
		}
		if(!confirm(langLbl.confirmUpdateStatus)){
			e.preventDefault();
			return;
		}
		var brandId = parseInt(obj.value);
		if( brandId < 1 ){
			fcom.displayErrorMessage(langLbl.invalidRequest);
			return false;
		}
		data='brandId='+brandId;
		fcom.ajax(fcom.makeUrl('Brands','changeStatus'),data,function(res){
		var ans = $.parseJSON(res);
			if( ans.status == 1 ){
				fcom.displaySuccessMessage(ans.msg);
				$(obj).toggleClass("active");
			}else{
				fcom.displayErrorMessage(ans.msg);
			}
		});
	};

	toggleBulkStatues = function(status){
		if(!confirm(langLbl.confirmUpdateStatus)){
			return false;
		}
		$("#frmBrandListing input[name='status']").val(status);
		$("#frmBrandListing").submit();
	};

	deleteSelected = function(){
		if(!confirm(langLbl.confirmDelete)){
			return false;
		}
		$("#frmBrandListing").attr("action",fcom.makeUrl('Brands','deleteSelected')).submit();
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
						if(ans.status==1)
						{
							fcom.displaySuccessMessage(ans.msg);
							$('#form-upload').remove();
							brandImages(ans.brandId,langId);
							reloadList();
						}else{
							fcom.displayErrorMessage(ans.msg,'');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	}, 500);
});
