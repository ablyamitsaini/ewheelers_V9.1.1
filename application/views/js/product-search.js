var searchArr = [];
$(document).ready(function(){
	var frm = document.frmProductSearch;		
	
	$.each( frm.elements, function(index, elem){
		if( elem.type != 'text' && elem.type != 'textarea' && elem.type != 'hidden' && elem.type != 'submit' ){
			/* i.e for selectbox */
			$(elem).change(function(){
				searchProducts(frm,0,0,1);
			});
		}
	});
	/* ] */
	
	/* form submit upon onchange of elements not inside form tag[ */
	

	if( typeof isBrandPage !== 'undefined' && isBrandPage !== null ){
		$("input[name=brands]").attr("disabled","disabled");
		$("input[name=brands]").parent("label").addClass("disabled");
	}
	
	$("input[name=brands]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
			addToSearchQueryString(id,this);	
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1,1);		
	});
	
	$("input[name=category]").change(function(){		
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
			addToSearchQueryString(id,this);	
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1,1);		
	});
	
	$("input[name=optionvalues]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
			addToSearchQueryString(id,this);	
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1,1);		
	});
	
	$("input[name=conditions]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
			addToSearchQueryString(id,this);
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1,1);
	});
	
	$("input[name=free_shipping]").change(function(){
		alert("Pending...");
	});
	
	$("input:checkbox[name=out_of_stock]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
			addToSearchQueryString(id,this);	
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1,1);
	});
	
	$("input[name='priceFilterMinValue']").keyup(function(e){
		var code = e.which; 
		if( code == 13 ) {
			e.preventDefault();
			addPricefilter();
		}
	});
	
	$("input[name='priceFilterMaxValue']").keyup(function(e){
		var code = e.which;
		if( code == 13 ) {
			e.preventDefault();
			addPricefilter();
		}
	});
	
	/* ] */
	
	
	$("#resetAll").on('click',function(){
		searchArr = [];
		document.frmProductSearch.reset();
		document.frmProductSearchPaging.reset();

		$('#filters a').each(function(){
			id = $(this).attr('class');
			clearFilters(id,this); 
		});
		updatePriceFilter();		
		searchProducts(frm,0,0,1,1);
	});
	
	
	
	/* for toggling of grid/list view[ */
	$('.switch--link-js').on('click',function(e) {
		$('.switch--link-js').removeClass("is--active");
		$('.switch--link-js').addClass("btn--primary");
		$(this).addClass("is--active");
		if ($(this).hasClass('list')) {
			$('.section--items').parent().removeClass('listing-products--grid').addClass('listing-products--list');
		}
		else if($(this).hasClass('grid')) {
			$('.section--items').parent().removeClass('listing-products--list').addClass('listing-products--grid');
		}
	});
	/* ] */
	
	/******** function for left collapseable links  ****************/     
	$(".block__body-js").show();
	$(".block__head-js").click(function(){ 
		$(this).toggleClass("is-active"); 
	});    
		
	$(".block__head-js").click(function(){
		$(this).siblings(".block__body-js").slideToggle("slow");
	});

	var ww = document.body.clientWidth;
	if (ww <= 1050) {
		$(".block__body-js").hide();
		$(".block__body-js:first").show();
	}else{
		$(".block__body-js").show();
	}  
		
	/******** function for left filters mobile  ****************/       
	$('.btn--filter').click(function() {
		$(this).toggleClass("is-active");
		var el = $("html");
		if(el.hasClass('filter__show')) el.removeClass("filter__show");
		else el.addClass('filter__show');
		return false; 
	});
	$('html,.overlay--filter').click(function(){
		if($('html').hasClass('filter__show')){
			$('.btn--filter').removeClass("is-active");
			$('html').removeClass('filter__show');
		}
	});
	
	$('.filters').click(function(e){
		e.stopPropagation();
	});
	
	if($(window).width()<1050){		
		if($(".grids")[0]){
			$('.grids').masonry({
			  itemSelector: '.grids__item',
			});  
		}
	}
	
});

$(window).load(function(){
	if(($( "#filters" ).find('a').length)>0){
		$('#resetAll').css('display','block');
	}
	else{
		$('#resetAll').css('display','none');  
	}
})

/* function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
	return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
	return uri + separator + key + "=" + value;
  }
} */

function htmlEncode(value){
  return $('<div/>').text(value).html();
}

function addFilter(id,obj){
	var click = "onclick=removeFilter('"+id+"',this)";
	$filter = $(obj).parent().text();
	$filterVal = htmlEncode($(obj).parent().text());		
	if(!$('#filters').find('a').hasClass(id)){
		$('#filters').append("<a href='javascript:void(0);' class="+id+"   "+click+ ">"+$filterVal+"</a>");		
	}
}

function removeFilter(id,obj){
	$('.'+id).remove();
	$('#'+id).find('input[type=\'checkbox\']').attr('checked', false);
	var frm = document.frmProductSearch;
	/* form submit upon onchange of form elements select box[ */	
	removeFromSearchQueryString(id);		
	searchProducts(frm,0,0,1,1);
}

function clearFilters(id,obj){
	$('.'+id).remove();
	$('#'+id).find('input[type=\'checkbox\']').attr('checked', false);
}

function addToSearchQueryString(id,obj){	
	//$filter = $(obj).parent().text(); 
	var attrVal = $(obj).attr('data-title')		
	if (typeof attrVal !== typeof undefined && attrVal !== false) {		
		$filterVal = htmlEncode(removeSpecialCharacter(attrVal));
	}else{
		$filterVal = htmlEncode(removeSpecialCharacter($(obj).parent().text()));
	}
	$filterVal = $filterVal.toLowerCase();
	searchArr[id] = encodeURIComponent($filterVal.replace(/\s/g,'-'));	
}

function removeSpecialCharacter($str){
	return $str.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
}

function removeFromSearchQueryString(key){
	delete searchArr[key];		
}

function getSearchQueryUrl(includeBaseUrl){	
	url = '';
	if(typeof includeBaseUrl != 'undefined' || includeBaseUrl != null){
		url = $currentPageUrl;
	}
	
	for (var key in searchArr) {
		url = url +'/'+ key.replace(/_/g,'-') + '-'+ searchArr[key];
	}	
	
	var keyword = $("input[name=keyword]").val();
	if(keyword !=''){
		delete searchArr['keyword'];		
		url = url +'/'+'keyword-'+keyword.replace(/_/g,'-');
	}
	
	var currency = parseInt($("input[name=currency_id]").val());
	if(currency > 0){
		delete searchArr['currency'];
		url = url +'/'+'currency-'+currency;
	}
	
	var featured = parseInt($("input[name=featured]").val());
	if(featured > 0){
		url = url +'/'+'featured-'+featured;
	}
	
	var collection_id = parseInt($("input[name=collection_id]").val());
	if(collection_id > 0){
		url = url +'/'+'collection-'+collection_id;
	}
	
	var shop_id = parseInt($("input[name=shop_id]").val());
	if(shop_id > 0){
		url = url +'/'+'shop-'+shop_id;
	}
		
	/* var e = document.getElementById("sortBy");
	var sortBy = e.options[e.selectedIndex].value;
	if(sortBy){ 
		url = url +'/'+'sort-'+sortBy.replace(/_/g,'-');
	} */ 
	
	/* var e = document.getElementById("pageSize");
	var pageSize = parseInt(e.options[e.selectedIndex].value);
	if(pageSize > 0){
		url = url +'/'+'page-'+pageSize;
	} */
	
	return encodeURI(url);
}

function addPricefilter(){ 
	$('.price').remove();
	if(!$('#filters').find('a').hasClass('price')){
		$('#filters').append('<a href="javascript:void(0)" class="price" onclick="removePriceFilter(this)" >'+currencySymbolLeft+$("input[name=priceFilterMinValue]").val()+currencySymbolRight+' - '+currencySymbolLeft+$("input[name=priceFilterMaxValue]").val()+currencySymbolRight+'</a>');
	}
	searchArr['price_min_range'] = $("input[name=priceFilterMinValue]").val();
	searchArr['price_max_range'] = $("input[name=priceFilterMaxValue]").val();
	searchArr['currency'] = langLbl.siteCurrencyId;
	var frm = document.frmProductSearch;		
	searchProducts(frm,0,0,1,1);	
}
function removePriceFilter(){	
	updatePriceFilter();
	var frm = document.frmProductSearch;
	delete searchArr['price_min_range'];
	delete searchArr['price_max_range'];
	delete searchArr['currency'];
	searchProducts(frm,0,0,1,1);	
	$('.price').remove();
}

function updatePriceFilter(minPrice,maxPrice){
	if(typeof minPrice == 'undefined' || typeof maxPrice == 'undefined'){
		minPrice = $("#filterDefaultMinValue").val();
		maxPrice = $("#filterDefaultMaxValue").val();
	}else{
		addPricefilter();
	}	
	
	$('input[name="priceFilterMinValue"]').val(minPrice);				
	$('input[name="priceFilterMaxValue"]').val(maxPrice);
	var frm = document.frmProductSearch;	
	var $range = $("#price_range");
	range = $range.data("ionRangeSlider");		
	updateRange(minPrice,maxPrice);
	range.reset();	
}
	
(function() {
	updateRange = function (from,to) {			
		range.update({
			from: from,
			to: to
		});
	};
	var processing_product_load = false;
	searchProducts = function( frm, append, resetValue, withPriceFilter ,useFilterInurl ){

		if( processing_product_load == true ) return false;
		processing_product_load = true;
		append = (typeof append == "undefined" ) ? 0 : append;
		resetValue = (typeof resetValue == "undefined" ) ? 0 : resetValue;
		
		if(typeof useFilterInurl == 'undefined' || useFilterInurl == null){
			useFilterInurl = 0;
		}		
		
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		data = data+"&colMdVal="+[colMdVal];
		
		if(resetValue == 0){ 
			/* Category filter value pickup[ */
			var category=[];
			$("input:checkbox[name=category]:checked").each(function(){
				var id = $(this).parent().parent().find('label').attr('id');	
				addToSearchQueryString (id,this);
				addFilter (id,this);
				category.push($(this).val());
			});
			if ( category.length ){
				data=data+"&category="+[category];
			}
			/* ] */	
			
			/* brands filter value pickup[ */
			var brands=[];
			$("input:checkbox[name=brands]:checked").each(function(){
				var id = $(this).parent().parent().find('label').attr('id');	
				addToSearchQueryString (id,this);
				addFilter (id,this);
				brands.push($(this).val());
			});
			if ( brands.length ){
				data=data+"&brand="+[brands];				
			}
			/* ] */
			
			/* Option filter value pickup[ */
			var optionvalues=[];
			$("input:checkbox[name=optionvalues]:checked").each(function(){
				var id = $(this).parent().parent().find('label').attr('id');	
				addToSearchQueryString (id,this);
				addFilter (id,this);
				optionvalues.push($(this).val());
			});
			if ( optionvalues.length ){
				data=data+"&optionvalue="+[optionvalues];
			}
			/* ] */
			
			/* condition filters value pickup[ */
			var conditions=[];
			$("input:checkbox[name=conditions]:checked").each(function(){
				var id = $(this).parent().parent().find('label').attr('id');	
				addToSearchQueryString (id,this);
				addFilter (id,this);
				conditions.push($(this).val());
			});
			if ( conditions.length ){
				data=data+"&condition="+[conditions];
			}
			/* ] */
			
			/* Free Shipping Filter value pickup[ */
			
			/* ] */
			
			/* Out Of Stock Filter value pickup[ */
			$("input:checkbox[name=out_of_stock]:checked").each(function(){
				var id = $(this).parent().parent().find('label').attr('id');	
				addToSearchQueryString (id,this);
				addFilter (id,this);
				data=data+"&out_of_stock=1";
			});
			/* ] */
			
			/* price filter value pickup[ */			
			if(typeof $("input[name=priceFilterMinValue]").val() != "undefined"){
				data = data+"&min_price_range="+$("input[name=priceFilterMinValue]").val();
			}
			if(typeof $("input[name=priceFilterMaxValue]").val() != "undefined"){
				data = data+"&max_price_range="+$("input[name=priceFilterMaxValue]").val();
			}
		
		}
		
		if(($( "#filters" ).find('a').length)>0){
			$('#resetAll').css('display','block');
		}else{
			$('#resetAll').css('display','none');  
		}
		
		var dv = $("#productsList");
		var colMdVal = $(dv).attr('data-col-md');
		if( append == 1 ){
			$(dv).append(fcom.getLoader());
		} else {
			$(dv).html(fcom.getLoader());
			$( ".filters" ).addClass( "filter-disabled" );
		}
		
		if(useFilterInurl > 0){
			history.pushState(null, null, getSearchQueryUrl(true));	
		}

		fcom.updateWithAjax(fcom.makeUrl('Products','productsList'),data,function(ans){
			
			processing_product_load = false;
			$.mbsmessage.close();
			
			if( ans.reload == '1' ){
				location.reload();
				return;
			}
			
			$('.pagingString').show();
			if( $('#start_record').length > 0  ){
				$('#start_record').html(ans.startRecord);
			}
			if( $('#end_record').length > 0  ){
				$('#end_record').html(ans.endRecord);
			}
			if( $('#total_records').length > 0  ){
				$('#total_records').html(ans.totalRecords);
			}
			if( ans.totalRecords == 0 && $('#top-filters').length > 0 ){
				$(".hide_on_no_product").addClass("dont-show");
			} else {
				$(".hide_on_no_product").removeClass("dont-show");
			}
									
			if( append == 1 ){
				$(dv).find('.loader-yk').remove();
				$( ".filters" ).removeClass( "filter-disabled" );
				$(dv).append(ans.html);
			} else {
				$( ".filters" ).removeClass( "filter-disabled" );
				$(dv).html( ans.html );
			}
									
			/* for LoadMore[ */
			$("#loadMoreBtnDiv").html( ans.loadMoreBtnHtml );
			/* ] */
			if(!ans.startRecord)
			{
				$('.pagingString').hide();
				return;
			}
			
		});
	}
	
	goToProductListingSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmProductSearchPaging;	
		$(frm.page).val(page);
		$("form[name='frmProductSearchPaging']").remove();
		searchProducts(frm,0,0,1,1);
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	};
	
	saveProductSearch = function() {
		 event.stopPropagation();
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}
		$.facebox(function() {
		fcom.ajax(fcom.makeUrl('Products','saveProductSearchPopup'), '' ,function(ans){
			$.facebox(ans,'faceboxWidth collection-ui-popup');
				if( ans.status ){
					$(document).trigger('close.facebox');
				}
			});
		});
	
		return false;
	};
	
	setupSaveProductSearch = function(frm){
		if ( !$(frm).validate() ) return false;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Products', 'setupSaveProductSearch'), data, function(ans) {
			if( ans.status ){
				$(document).trigger('close.facebox');
			}
		});
	};

	
})();