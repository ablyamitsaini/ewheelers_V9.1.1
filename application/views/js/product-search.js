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
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1);		
	});
	
	$("input[name=category]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);		
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm);		
	});
	
	$("input[name=optionvalues]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);		
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1);		
	});
	
	$("input[name=conditions]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
		
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1);
	});
	
	$("input[name=free_shipping]").change(function(){
		alert("Pending...");
	});
	
	$("input:checkbox[name=out_of_stock]").change(function(){
		var id= $(this).parent().parent().find('label').attr('id');
		if($(this).is(":checked")){
			addFilter(id,this);
		
		}else{
			removeFilter(id,this);
		}
		searchProducts(frm,0,0,1);
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
		
		var minPrice=$("#old-min-value").val();
		var maxPrice=$("#old-max-value").val();
		
		$("#price_range").val(minPrice+'-'+maxPrice);
		var $range = $("#price_range");
		range = $range.data("ionRangeSlider");
		updateRange(minPrice,maxPrice);
		range.reset();
		searchProducts(frm);
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
	addToSearchQueryString (id,obj);	
	$('#filters').append("<a href='javascript:void(0);' class="+id+"   "+click+ ">"+$filterVal+"</a>");
		
}

function removeFilter(id,obj){
	$('.'+id).remove();
	$('#'+id).find('input[type=\'checkbox\']').attr('checked', false);
	var frm = document.frmProductSearch;

	/* form submit upon onchange of form elements select box[ */	
	removeFromSearchQueryString(id);		
	searchProducts(frm,0,0,1);
}

function clearFilters(id,obj){
 $('.'+id).remove();
 $('#'+id).find('input[type=\'checkbox\']').attr('checked', false);
}

function addToSearchQueryString(id,obj){	
	$filter = $(obj).parent().text();
	$filterVal = htmlEncode($(obj).parent().text());
	//searchUrl = searchUrl +'&'+ id + '='+ $filterVal.replace(/ /g,'');
	searchArr[id] = $filterVal.replace(/ /g,'');			
}

function removeFromSearchQueryString(key){
	delete searchArr[key];		
}

function getSearchQueryUrl(){	
	url = '';
	for (var key in searchArr) {
		url = url +'&'+ key + '='+ searchArr[key];
	}	
	return encodeURI(url);
}

function addPricefilter(){
	$('.price').remove();
	if(typeof($("input[name=priceFilterMaxValue]").val())!== "undefined"){
		if( $("input[name=priceFilterMaxValue]").val()==$("#price_max_range").val() && $("input[name=priceFilterMinValue]").val() ==Math.floor($("#price_min_range").val()))
		{

		}else{
			$('#filters').append('<a href="javascript:void(0)" class="price" onclick="removePriceFilter(this)" >'+currencySymbolLeft+$("input[name=priceFilterMinValue]").val()+currencySymbolRight+' - '+currencySymbolLeft+$("input[name=priceFilterMaxValue]").val()+currencySymbolRight+'</a>');
			$("input[name=price_min_range]").val($("input[name=priceFilterMinValue]").val());
			$("input[name=price_max_range]").val($("input[name=priceFilterMaxValue]").val());
		}
		searchArr['price_min_range'] = $("input[name=priceFilterMinValue]").val();
		searchArr['price_max_range'] = $("input[name=priceFilterMaxValue]").val();
		searchArr['currency'] = langLbl.siteCurrencyId;
		var frm = document.frmProductSearch;		
		/* form submit upon onchange of form elements select box[ */
		 searchProducts(frm,0,0,1); 

	}
}
function removePriceFilter(){

	var minPrice=$("#old-min-value").val();
	var maxPrice=$("#old-max-value").val();
	$('#filters').append('<a href="javascript:void(0)" class="price" onclick="removePriceFilter(this)" >'+currencySymbolLeft+ Math.floor($("#price_min_range").val())+currencySymbolRight+ '-' +currencySymbolLeft+Math.floor($("#price_max_range").val())+currencySymbolRight+'</a>');
	$("input[name=price_min_range]").val(minPrice);
	$("input[name=price_max_range]").val(maxPrice);
	var frm = document.frmProductSearch;
	
	$("#price_range").val(minPrice+'-'+maxPrice);
	var $range = $("#price_range");
	range = $range.data("ionRangeSlider");
	updateRange(minPrice,maxPrice);
	range.reset();

	delete searchArr['price_min_range'];
	delete searchArr['price_max_range'];
	delete searchArr['currency'];
	searchProducts(frm);
	$('.price').remove();
}
	
(function() {
	updateRange = function (from,to) {
		range.update({
			from: from,
			to: to
		});
	};
	var processing_product_load = false;
	searchProducts = function( frm, append, reset, withPriceFilter ){

		if( processing_product_load == true ) return false;
		processing_product_load = true;
		append = ( append == "undefined" ) ? 0 : append;
		reset = ( reset == "undefined" ) ? 0 : reset;
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		data = data+"&colMdVal="+[colMdVal];
		
		if(reset == 0){
			/* Category filter value pickup[ */
			var category=[];
			$("input:checkbox[name=category]:checked").each(function(){
				category.push($(this).val());
			});
			if ( category.length ){
				data=data+"&category="+[category];
			}
			/* ] */	
			
			/* brands filter value pickup[ */
			var brands=[];
			$("input:checkbox[name=brands]:checked").each(function(){
				brands.push($(this).val());
			});
			if ( brands.length ){
				data=data+"&brand="+[brands];				
			}
			/* ] */
			
			/* Option filter value pickup[ */
			var optionvalues=[];
			$("input:checkbox[name=optionvalues]:checked").each(function(){
				optionvalues.push($(this).val());
			});
			if ( optionvalues.length ){
				data=data+"&optionvalue="+[optionvalues];
			}
			/* ] */
			
			/* condition filters value pickup[ */
			var conditions=[];
			$("input:checkbox[name=conditions]:checked").each(function(){
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
				data=data+"&out_of_stock=1";
			});
			/* ] */
			/* price filter value pickup[ */
			if(withPriceFilter == undefined || withPriceFilter==0){
				if(typeof $("input[name=old-min-value]").val() != "undefined"){
					data = data+"&min_price_range="+$("input[name=old-min-value]").val();
				}
				if(typeof $("input[name=old-max-value]").val() != "undefined"){
					data = data+"&max_price_range="+$("input[name=old-max-value]").val();
				}
			}else{
				if(typeof $("input[name=price_min_range]").val() != "undefined"){
					data = data+"&min_price_range="+$("input[name=price_min_range]").val();
				}
				if(typeof $("input[name=price_max_range]").val() != "undefined"){
					data = data+"&max_price_range="+$("input[name=price_max_range]").val();
				}
			}
			/* ] */
		}
		
		if(($( "#filters" ).find('a').length)>0){
			$('#resetAll').css('display','block');
		}
		else{
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
			
			if(ans.selectedCurrencyPriceArr && ans.selectedCurrencyPriceArr['minPrice'] !='' && ans.selectedCurrencyPriceArr['maxPrice'] !='') {
				var minPrice = ans.selectedCurrencyPriceArr['minPrice'];
				var maxPrice = ans.selectedCurrencyPriceArr['maxPrice'];
				
				$('input[name="price_min_range"]').val(minPrice);
				$('input[name="price_max_range"]').val(maxPrice);
				
				$("#price_range").val(minPrice+'-'+maxPrice);
				
				if(withPriceFilter == undefined || withPriceFilter == 0){
					$('input[name="priceFilterMinValue"]').val(minPrice);
					$('input[name="priceFilterMaxValue"]').val(maxPrice);
					
					var $range = $("#price_range");
					range = $range.data("ionRangeSlider");
					if(range){
						range.update({
							min: minPrice,
							max: maxPrice,
							from: minPrice,
							to: maxPrice,
							disable: false
						});
					}
					$('.price').remove();
				}
			}
			
			
			
			if( append == 1 ){
				$(dv).find('.loader-yk').remove();
				$( ".filters" ).removeClass( "filter-disabled" );
				$(dv).append(ans.html);
			} else {
				$( ".filters" ).removeClass( "filter-disabled" );
				$(dv).html( ans.html );
			}
			
			/* if(ans.totalRecords==0)
			{
				$('#top-filters').hide();
				return;
			} */
			
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
		searchProducts(frm,0,0,1);
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