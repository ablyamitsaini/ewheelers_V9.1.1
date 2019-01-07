$(document).ready(function(){
	searchShops(document.frmShopSearch);
});
$(document).delegate('.logo-language-js','change',function(){
	var lang_id = $(this).val();
	var shop_id = $("input[name='shop_id']").val();
	shopImages(shop_id,'logo',lang_id);
});
$(document).delegate('.banner-language-js','change',function(){
	var lang_id = $(this).val();
	var shop_id = $("input[name='shop_id']").val();
	shopImages(shop_id,'banner',lang_id);
});
$(document).delegate('.bg-language-js','change',function(){
	var lang_id = $(this).val();
	var shop_id = $("input[name='shop_id']").val();
	shopImages(shop_id,'bg',lang_id);
});
(function() {
	var currentPage = 1;
	var runningAjaxReq = false;

	goToSearchPage = function(page) {	
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmShopSearchPaging;		
		$(frm.page).val(page);
		searchShops(frm);
	}

	reloadList = function() {
		var frm = document.frmShopSearchPaging;
		searchShops(frm);
	}

	addShopForm = function(id) {
		$.facebox(function() {shopForm(id);
		});
	};	
	shopForm = function(id) {
		fcom.displayProcessing();
		var frm = document.frmShopSearchPaging;			
			fcom.ajax(fcom.makeUrl('Shops', 'form', [id]), '', function(t) {				
				fcom.updateFaceboxContent(t);
			});
			};	

	setupShop = function(frm) {
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Shops', 'setup'), data, function(t) {			
			reloadList();
			if (t.langId>0) {
				/* $.mbsmessage(t.msg,'','alert--success'); */
				addShopLangForm(t.shopId, t.langId);
				return ;
			}
			$(document).trigger('close.facebox');
		});
	};

	addShopLangForm = function(shopId, langId) {		
			fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('Shops', 'langForm', [shopId, langId]), '', function(t) {
				fcom.updateFaceboxContent(t);
			});
		
	};
	
	setupShopLang=function(frm){ 
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('Shops', 'langSetup'), data, function(t) {			
			reloadList();				
			if (t.langId>0) {
				addShopLangForm(t.shopId, t.langId);
				return ;
			}
			$(document).trigger('close.facebox');
		});
	};

	searchShops = function(form){		
		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		/*]*/
		
		$("#shopListing").html(fcom.getLoader());
		
		fcom.ajax(fcom.makeUrl('Shops','search'),data,function(res){
			
			$("#shopListing").html(res);
		});
	};	
	
	clearShopSearch = function(){
		document.frmShopSearch.reset();
		searchShops(document.frmShopSearch);
	};

	getCountryStates = function(countryId,stateId,dv){
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('Shops','getStates',[countryId,stateId]),'',function(res){
			$(dv).empty();
			$(dv).append(res);
		});
	};
	
	shopMediaForm = function(shopId){
			fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('shops', 'media', [shopId]), '', function(t) {
				shopImages(shopId,'logo');
				shopImages(shopId,'banner');
				shopImages(shopId,'bg');
				fcom.updateFaceboxContent(t);				
			});
	};
	
	shopImages = function(shopId,imageType,lang_id){
		fcom.ajax(fcom.makeUrl('shops', 'images', [shopId,imageType,lang_id]), '', function(t) {
			if(imageType=='logo') {
				$('#logo-image-listing').html(t);
			} else if(imageType=='banner') {
				$('#banner-image-listing').html(t);
			} else {
				$('#bg-image-listing').html(t);
			}
			fcom.resetFaceboxHeight();
		});
	};
	
	shopTemplates = function(shopId){	
			fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('shops', 'shopTemplate', [shopId]), '', function(t) {	
				fcom.updateFaceboxContent(t);		
			});
	};
	
	setTemplate = function (shopId,ltemplateId){
		fcom.updateWithAjax(fcom.makeUrl('shops', 'setTemplate',[shopId,ltemplateId]), '', function(t) {
			shopTemplates(shopId);
			return ;
		});
	};
	
	shopCollectionProducts= function(shopId){
		fcom.displayProcessing();
			fcom.ajax(fcom.makeUrl('shops', 'shopCollection', [shopId]), '', function(t) {		
				fcom.updateFaceboxContent(t);
				getShopCollectionGeneralForm(shopId);
			});
	};
	
	getShopCollectionGeneralForm = function (shopId){
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('shops', 'shopCollectionGeneralForm', [shopId]), '', function(t) {
			fcom.updateFaceboxContent(t);
		});	
	}
	
	setupShopCollection = function (frm){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('shops', 'setupShopCollection'), data, function(t) {
			if (t.langId>0) {
				editShopCollectionLangForm(t.shop_id, t.collection_id, t.langId);
				return ;
			}
		
		});
	}
	
	setupShopCollectionlangForm = function (frm){
		if (!$(frm).validate()) return;		
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('shops', 'setupShopCollectionLang'), data, function(t) {
			if (t.langId>0) {
				editShopCollectionLangForm(t.shop_id, t.collection_id, t.langId);
				return ;
			}
		});

	}
	
	editShopCollectionLangForm = function(shop_id,scollection_id,langId){
		if (typeof(scollection_id) == "undefined" || scollection_id<0){
			return false;
		}
		if (typeof(langId) == "undefined" || langId<0){
			return false;
		}
		if (typeof(shop_id) == "undefined" || shop_id<0){
			
			return false;
		}
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('shops', 'shopCollectionLangForm', [shop_id,scollection_id,langId]), '', function(t) {
			fcom.updateFaceboxContent(t);
		});
	};
	
	sellerCollectionProducts = function( scollection_id,shop_id ) {
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('shops', 'sellerCollectionProductLinkFrm', [ scollection_id,shop_id ]), '', function(t) {
			fcom.updateFaceboxContent(t);
			bindAutoComplete();
		});	
	}
	
	setUpSellerCollectionProductLinks = function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('shops', 'setUpSellerCollectionProductLinks'), data, function(t) {
		});
	}
	
	deleteImage = function( fileId, shopId, imageType, langId){
		var agree = confirm( langLbl.confirmDeleteImage );
		if( !agree ){
			return false;
		}
		fcom.updateWithAjax(fcom.makeUrl('Shops', 'removeShopImage',[fileId,shopId,imageType,langId]), '', function(t) {
			shopImages( shopId, imageType, langId );
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
		var shopId = parseInt(obj.value);
		if(shopId < 1){
			fcom.displayErrorMessage(langLbl.invalidRequest);
			return false;
		}
		data='shopId='+shopId;
		fcom.displayProcessing();
		fcom.ajax(fcom.makeUrl('Shops','changeStatus'),data,function(res){
		var ans =$.parseJSON(res);
			if( ans.status == 1 ){
				$(obj).toggleClass("active");
				fcom.displaySuccessMessage(ans.msg);
				/* setTimeout(function(){ 
					reloadList(); 
				}, 1000); */
			} else {
				fcom.displayErrorMessage(ans.msg);
			}
		});
		$.systemMessage.close();
	};
	
})();

function bindAutoComplete(){
	$("input[name='scp_selprod_id']").autocomplete({'source': function(request, response) {
		$.ajax({
			url: fcom.makeUrl('Shops', 'autoCompleteProducts'),
			data: {keyword: request,fIsAjax:1,shopId:$("input[name='shop_id']").val()},
			dataType: 'json',
			type: 'post',
			success: function(json) {
				response($.map(json, function(item) {
				
					return { label: item['name'] +'['+item['product_identifier'] +']',	value: item['id']	};
				}));
			},
		});
	},
	'select': function(item) {
		$('input[name=\'scp_selprod_id\']').val('');
		$('#selprod-products' + item['value']).remove();
		$('#selprod-products ul').append('<li id="selprod-products' + item['value'] + '"><i class=" icon ion-close-round"></i> ' +item['label'] + '<input type="hidden" name="product_ids[]" value="' + item['value'] + '" /></li>');
	}
	});
}

$(document).on('click','.shopFile-Js',function(){
	var node = this;
	$('#form-upload').remove();
	var frmName = $(node).attr('data-frm');	
	if('frmShopLogo' == frmName){
		var langId = document.frmShopLogo.lang_id.value;
		var shopId = document.frmShopLogo.shop_id.value;
		var imageType = 'logo';
	}else if('frmShopBanner' == frmName){
		var langId = document.frmShopBanner.lang_id.value;
		var shopId = document.frmShopBanner.shop_id.value;
		var imageType = 'banner';
	}else {
		var langId = document.frmBackgroundImage.lang_id.value;
		var shopId = document.frmBackgroundImage.shop_id.value;
		var imageType = 'bg';
	}
	
	var fileType = $(node).attr('data-file_type');	
		
	var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
	frm = frm.concat('<input type="file" name="file" />'); 
	frm = frm.concat('<input type="hidden" name="shop_id" value="'+shopId+'"/>'); 
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
				url: fcom.makeUrl('Shops', 'uploadShopImages',[shopId, langId]),
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
						$('#input-field'+fileType).html(ans.msg);						
						if(ans.status == true){
							$('#input-field'+fileType).removeClass('text-danger');
							$('#input-field'+fileType).addClass('text-success');
							$('#form-upload').remove();
							shopImages(ans.shopId,imageType,langId);
							fcom.displaySuccessMessage(ans.msg);
							//addShopLangForm(ans.shopId, langId);	
						}else{
							$('#input-field'+fileType).removeClass('text-success');
							$('#input-field'+fileType).addClass('text-danger');
							fcom.displayErrorMessage(ans.msg);
						}												
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});			
		}
	}, 500);
	
});
