function initialize() {
    geocoder = new google.maps.Geocoder();	
}

function getCountryStates( countryId, stateId, dv ){
	fcom.ajax(fcom.makeUrl('GuestUser','getStates',[countryId,stateId]),'',function(res){
		$(dv).empty();
		$(dv).append(res);
	});
};

function recentlyViewedProducts(){
	$("#recentlyViewedProductsDiv").html(fcom.getLoader());
	
	fcom.ajax( fcom.makeUrl('Products','recentlyViewedProducts'),'',function(ans){
		$("#recentlyViewedProductsDiv").html(ans);
		$('.slides--six-js').slick( getSlickSliderSettings(6) );
	});
}

function resendVerificationLink(user){
	if(user=='')
	{
		return false;
	}
	$(document).trigger('closeMsg.systemMessage');
	$.mbsmessage(langLbl.processing,false,'alert--process alert');
	fcom.updateWithAjax( fcom.makeUrl('GuestUser','resendVerification',[user]),'',function(ans){
		$.mbsmessage(ans.msg, false, 'alert alert--success');
	});
}

function getCardType(number){
    // visa
    var re = new RegExp("^4");
    if (number.match(re) != null)
        return "Visa";

    // Mastercard
    re = new RegExp("^5[1-5]");
    if (number.match(re) != null)
        return "Mastercard";

    // AMEX
    re = new RegExp("^3[47]");
    if (number.match(re) != null)
        return "AMEX";

    // Discover
    re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
    if (number.match(re) != null)
        return "Discover";

    // Diners
    re = new RegExp("^36");
    if (number.match(re) != null)
        return "Diners";

    // Diners - Carte Blanche
    re = new RegExp("^30[0-5]");
    if (number.match(re) != null)
        return "Diners - Carte Blanche";

    // JCB
    re = new RegExp("^35(2[89]|[3-8][0-9])");
    if (number.match(re) != null)
        return "JCB";

    // Visa Electron
    re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
    if (number.match(re) != null)
        return "Visa Electron";

    return "";
}

 viewWishList = function( selprod_id, dv,event){
	event.stopPropagation();
	/*var dv = "#listDisplayDiv_" + selprod_id; */
		
	if( $(dv). next().hasClass("is-item-active") ){
		$(dv).next().toggleClass('open-menu');
		$(dv).parent().toggleClass('list-is-active');
		return;
	}
	$('.collection-toggle').next().removeClass("is-item-active");
	if( isUserLogged() == 0 ){
		loginPopUpBox();
		return false;
	}
	
	
	$.facebox(function() {
		fcom.ajax(fcom.makeUrl('Account','viewWishList', [selprod_id]), '' ,function(ans){
			fcom.updateFaceboxContent(ans,'faceboxWidth collection-ui-popup small-fb-width');
			//$(dv).next().html(ans);
			$("input[name=uwlist_title]").bind('focus',function(e){
				e.stopPropagation();
			});
		
			activeFavList = selprod_id;
			
		});
		
	});
	
	return false;
}

toggleShopFavorite = function( shop_id ){
	if( isUserLogged() == 0 ){
		loginPopUpBox();
		return false;
	}
	var data = 'shop_id='+shop_id;
	fcom.updateWithAjax(fcom.makeUrl('Account', 'toggleShopFavorite'), data, function(ans) {
		if( ans.status ){
			if( ans.action == 'A' ){
				$("#shop_"+shop_id).addClass("is-active");
			//	$("#shop_"+shop_id).text("Love this shop");
			} else if( ans.action == 'R' ){
				$("#shop_"+shop_id).removeClass("is-active");
				//$("#shop_"+shop_id).text("Loved pending css");
			}
		}
	});
	
}

setupWishList = function(frm,event){
	if ( !$(frm).validate() ) return false;
	var data = fcom.frmData(frm);
	var selprod_id = $(frm).find('input[name="selprod_id"]').val();
	fcom.updateWithAjax(fcom.makeUrl('Account', 'setupWishList'), data, function(ans) {
		
		if(ans.status){
			fcom.ajax(fcom.makeUrl('Account','viewWishList', [selprod_id]), '' ,function(ans){
				$(".collection-ui-popup").html(ans);
				$("input[name=uwlist_title]").bind('focus',function(e){
					e.stopPropagation();
				});
			});
		}
	});
}

addRemoveWishListProduct = function( selprod_id, wish_list_id,event ){
	event.stopPropagation();
	if( isUserLogged() == 0 ){
		loginPopUpBox();
		return false;
	}
	wish_list_id = ( typeof(wish_list_id) != "undefined" ) ? parseInt(wish_list_id) : 0;
	var dv = ".collection-ui-popup";
	
	fcom.updateWithAjax( fcom.makeUrl('Account', 'addRemoveWishListProduct', [selprod_id, wish_list_id]), '', function(ans){
		if( ans.status == 1 ){
			if( ans.productIsInAnyList){
				$( "[data-id="+selprod_id+"]").addClass("is-active");
			} else {
				$( "[data-id="+selprod_id+"]").removeClass("is-active");
			}
			if( ans.action == 'A' ){
				$(dv).find(".wishListCheckBox_" + ans.wish_list_id ).addClass('is-active');
			} else if( ans.action == 'R' ){
				$(dv).find(".wishListCheckBox_" + ans.wish_list_id ).removeClass('is-active');
			}
		}
	});
}

function submitSiteSearch(frm){
	//var data = fcom.frmData(frm);
	var qryParam=($(frm).serialize_without_blank());
	var url_arr = [];
	if( qryParam.indexOf("keyword") > -1 ){
		//url_arr.push('keyword');
		var keyword = $(frm).find('input[name="keyword"]').val();
		var protomatch = /^(https?|ftp):\/\//;
		url_arr.push('keyword-'+encodeURIComponent(keyword.replace(protomatch,'').replace(/\//g,'-')));
	}
	
	if( qryParam.indexOf("category") > -1 ){
		//url_arr.push('category');
		url_arr.push('category-'+$(frm).find('select[name="category"]').val());
	}
	/* url_arr = []; */
	
	if(themeActive == true ){
		url = fcom.makeUrl('Products','search', url_arr)+'?theme-preview';
		document.location.href = url;
		return;
	}
	url = fcom.makeUrl('Products','search', url_arr);
	document.location.href = url;
}

function getSlickGallerySettings( imagesForNav,layoutDirection ){
	slidesToShow = (typeof slidesToShow != "undefined" ) ? parseInt(slidesToShow) : 4;
	slidesToScroll = (typeof slidesToScroll != "undefined" ) ? parseInt(slidesToScroll) : 1;
	layoutDirection = (typeof layoutDirection != "undefined" ) ? layoutDirection : 'ltr';
	if(imagesForNav){
		if(layoutDirection == 'rtl'){
			return{
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: '.slider-for',
				dots: false,
				centerMode: false,
				focusOnSelect: true,
				autoplay:true,
				rtl:true,
				responsive: [
				{
					breakpoint: 1050,
					settings: {
						slidesToShow:4,
					}
				},
				{
					breakpoint: 500,
					settings: {
						slidesToShow:3,
						
					}
				},
				{
					breakpoint: 400,
					settings: {
						slidesToShow: 2, 
					}
				}
			  ]
			}
		
		}else{
			
			return{
				slidesToShow: 4,
				  slidesToScroll: 1,
				  asNavFor: '.slider-for',
				  dots: false,
				  centerMode: false,
				  autoplay:false,
				  focusOnSelect: true,
					ltr:true,		  
				  responsive: [
					{
					breakpoint: 1050,
					settings: {
						slidesToShow:4,	
					}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow:3,
						}
					}
					  ,
					{
						breakpoint: 400,
						settings: {
							slidesToShow: 2,
						}
					}
				  ]
			}
		}
	}else{
	
		if(layoutDirection == 'rtl'){
			return {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				rtl:true,
				autoplay:true,
			}
		}else{
			return {
				slidesToShow: 1,
				slidesToScroll: -1,
				arrows: false,
				ltr:true,	
				fade: true,		 	
				autoplay:true,
			}		  
		}
	}
}

function getSlickSliderSettings( slidesToShow, slidesToScroll,layoutDirection ){
	slidesToShow = (typeof slidesToShow != "undefined" ) ? parseInt(slidesToShow) : 4;
	slidesToScroll = (typeof slidesToScroll != "undefined" ) ? parseInt(slidesToScroll) : 1;
	layoutDirection = (typeof layoutDirection != "undefined" ) ? layoutDirection : 'ltr';
	
	if(layoutDirection == 'rtl'){
		return {
			slidesToShow: slidesToShow,
			slidesToScroll: slidesToScroll,     
			infinite: false, 
			arrows: true, 
			rtl:true,
			prevArrow: '<a data-role="none" class="slick-prev" aria-label="'+langLbl.next+'"></a>',
			nextArrow: '<a data-role="none" class="slick-next" aria-label="next"></a>',    
			responsive: [{
				breakpoint:1050,
				settings: {
					slidesToShow: slidesToShow - 1,
				}
				},
				{
					breakpoint:990,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint:767,
					settings: {
						slidesToShow: 2,
					}
				} ,
				{
					breakpoint:400,
					settings: {
						slidesToShow: 1,
					}
				} 
				]
		}
	}else{
		return {
			slidesToShow: slidesToShow,
			slidesToScroll: slidesToScroll,     
			infinite: false, 
			arrows: true,					
			prevArrow: '<a data-role="none" class="slick-prev" aria-label="previous"></a>',
			nextArrow: '<a data-role="none" class="slick-next" aria-label="next"></a>',    
			responsive: [{
				breakpoint:1050,
				settings: {
					slidesToShow: slidesToShow - 1,
				}
				},
				{
					breakpoint:990,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint:767,
					settings: {
						slidesToShow: 2,
					}
				} ,
				{
					breakpoint:400,
					settings: {
						slidesToShow: 1,
					}
				} 
				]
		}
	}
}
function codeLatLng(lat, lng) {
	var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
		if(status == google.maps.GeocoderStatus.OK) {
		// console.log(results)
			if(results[1]) {
				//formatted address			  
				for (var i = 0; i < results[0].address_components.length; i++) {
					if (results[0].address_components[i].types[0] == "country") {
						var country =  results[0].address_components[i].short_name;
					}
					
					if (results[0].address_components[i].types[0] == "administrative_area_level_1") {
						var state_code =  results[0].address_components[i].short_name;
						var state =  results[0].address_components[i].long_name;
					}
					
					if (results[0].address_components[i].types[0] == "administrative_area_level_2") {					
						var city =  results[0].address_components[i].long_name;
					}				
				}
				
				var data="country="+country+"&state="+state+"&state_code="+state_code+"&city="+city;			
				fcom.updateWithAjax(fcom.makeUrl('Home','setCurrentLocation'), data, function(ans){
					window.location.reload();
				});				  
			}else{
				Console.log("Geocoder No results found");
			}
		} else {
			Console.log("Geocoder failed due to: " + status);
		}
    }); 
}

function defaultSetUpLogin(frm, v) {
	v.validate();
	if (!v.isValid()) {
		
		return false; 
	}
	fcom.ajax(fcom.makeUrl('GuestUser', 'login'), fcom.frmData(frm), function(t) {
		var ans = JSON.parse(t);
		/* alert(t); */
		if(ans.notVerified==1)
		{
			var autoClose = false;
		}else{
			var autoClose = true;
		}
		if( ans.status == 1 ){
			$.mbsmessage(ans.msg, autoClose, 'alert alert--success');
			location.href = ans.redirectUrl;
			return;
		}
		$.mbsmessage(ans.msg, autoClose, 'alert alert--danger');
	});
	return false;
}
	
(function($){
	var screenHeight = $(window).height() - 100;
	window.onresize = function(event) { 
		var screenHeight = $(window).height() - 100;		
	};

	$.extend(fcom, {
		getLoader: function(){
			return '<div class="loader-yk"><div class="loader-yk-inner"></div></div>';
		},
		
		scrollToTop: function(obj){
			if(typeof obj == undefined || obj == null){
				$('html, body').animate({scrollTop: $('html, body').offset().top -100 }, 'slow');
			}else{
				$('html, body').animate({scrollTop: $(obj).offset().top -100 }, 'slow');
			}
		},
		resetEditorInstance: function(){
			if(extendEditorJs == true ){ 
				var editors = oUtil.arrEditor;
				for (x in editors){
					eval('delete window.' + editors[x]);							
				}			
				oUtil.arrEditor = [];
			} 
		},
		setEditorLayout:function(lang_id){
			if(extendEditorJs == true ){ 
				var editors = oUtil.arrEditor;
				layout = langLbl['language'+lang_id];							
				for (x in editors){					
					$('#idContent'+editors[x]).contents().find("body").css('direction',layout);				
				}	
			}
		},
		resetFaceboxHeight:function(){		
			$('html').css('overflow','hidden');
			facebocxHeight  = screenHeight;		
			var fbContentHeight = 	parseInt($('#facebox .content').height())+parseInt(100);	
			$('#facebox .content').css('max-height', parseInt(facebocxHeight)-150 + 'px');			
			
			if(fbContentHeight >= screenHeight){ 
				$('#facebox .content').css('overflow-y', 'scroll');
				$('#facebox .content').css('display', 'block');
			}else{				
				$('#facebox .content').css('max-height', '');
				$('#facebox .content').css('overflow', '');			
			}			
		},
		updateFaceboxContent:function(t,cls){
			if(typeof cls == 'undefined' || cls == 'undefined'){
				cls = '';
			}
			$.facebox(t,cls);
			$.systemMessage.close();			
			fcom.resetFaceboxHeight();			
		},
	});
	
	$(document).bind('reveal.facebox', function() {	
		fcom.resetFaceboxHeight();		
	});
	
	$(window).on("orientationchange",function(){
		fcom.resetFaceboxHeight();
	});
	
	$(document).bind('loading.facebox', function() {	
		$('#facebox .content').addClass('fbminwidth');				
	});
	
	$(document).bind('afterClose.facebox', function() {
		$('html').css('overflow','') ;
	});
	
	/* $(document).bind('afterClose.facebox', fcom.resetEditorInstance); */
	$(document).bind('beforeReveal.facebox', function() {		
		$('#facebox .content').addClass('fbminwidth');	
		$('html').css('overflow','') 
	});
	
	$(document).bind('reveal.facebox', function() {		
			$('#facebox .content').addClass('fbminwidth');
	});
	
	$.systemMessage = function(data, cls){
		initialize();
		$.systemMessage.loading();
		$.systemMessage.fillSysMessage(data, cls);
	};
	
	$.extend($.systemMessage, {
		settings:{
			closeimage:siteConstants.webroot + 'images/facebox/close.gif',
		},
		loading: function(){
			$('.system_message').show();
		},
		fillSysMessage:function(data, cls){
			if(cls) $('.system_message').addClass(cls);
			$('.system_message .content').html(data);
			$('.system_message').fadeIn();
			
			if( CONF_AUTO_CLOSE_SYSTEM_MESSAGES == 1 ){
				var time = CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000;
				setTimeout(function(){
					$.systemMessage.close();
				}, time);
			}
			
			/* $('.system_message').css({top:10}); */
		},
		close:function(){
			$(document).trigger('closeMsg.systemMessage');
		},
	});
	
	$(document).bind('closeMsg.systemMessage', function() {		
		$('.system_message').fadeOut();
	});
	
	function initialize(){
		$('.system_message .closeMsg').click($.systemMessage.close);
	}
	/* [ */
	$.fn.serialize_without_blank = function () {
		var $form = this,
		result,
		$disabled = $([]);

		$form.find(':input').each(function () {
			var $this = $(this);
			if ($.trim($this.val()) === '' && !$this.is(':disabled')) {
				$disabled.add($this);
				$this.attr('disabled', true);
			}
		});

		result = $form.serialize();
		$disabled.removeAttr('disabled');
		return result;
	};
	/* ] */
	
})(jQuery);
	

$(document).ready(function(){
	
	if(typeof $.fn.autocomplete_advanced !== typeof undefined){
		$('#header_search_keyword').autocomplete_advanced({
			minChars:2,
			autoSelectFirst:false,
			lookup: function (query, done) {
				$.ajax({
					url: fcom.makeUrl('Products','searchProductTagsAutocomplete'),
					data: { keyword: encodeURIComponent(query) },
					dataType: 'json',
					type: 'post',
					success: function(json) {
						done(json);
					}
				});
			},
			triggerSelectOnValidInput: false,
			onSelect: function (suggestion) {
				submitSiteSearch( document.frmSiteSearch );
				//alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
			}
		});
	}
	
	if( $('.system_message').find('.div_error').length > 0 || $('.system_message').find('.div_msg').length > 0 || 	$('.system_message').find('.div_info').length > 0 || $('.system_message').find('.div_msg_dialog').length > 0 ){
		$('.system_message').show();
	}
	$('.closeMsg').click(function(){
		$('.system_message').find('.div_error').remove();
		$('.system_message').find('.div_msg').remove();
		$('.system_message').find('.div_info').remove();
		$('.system_message').find('.div_msg_dialog').remove();
		$('.system_message').hide();
	});
	addCatalogPopup = function(){
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Seller','addCatalogPopup'), '', function(t){	
				fcom.updateFaceboxContent(t,'faceboxWidth loginpopup');
				
			});
		});
	}
	toggleProductFavorite = function( product_id,el){
		if( isUserLogged() == 0 ){
			loginPopUpBox();
			return false;
		}
		var data = 'product_id='+product_id;
		$.mbsmessage.close();
		fcom.updateWithAjax(fcom.makeUrl('Account', 'toggleProductFavorite'), data, function(ans) {
			if( ans.status ){
				if( ans.action == 'A' ){
					$(el).addClass("is-active");
					$( "[data-id="+product_id+"]").addClass("is-active");
					$("[data-id="+product_id+"] span").attr('title', langLbl.RemoveProductFromFavourite);
				} else if( ans.action == 'R' ){
					$( "[data-id="+product_id+"]").removeClass("is-active");
					$("[data-id="+product_id+"] span").attr('title', langLbl.AddProductToFavourite);
				}
			}
		});
		
	}
	
	openSignInForm = function(){		
		fcom.ajax(fcom.makeUrl('GuestUser','LogInFormPopUp'), '', function(t){	
			fcom.updateFaceboxContent(t,'faceboxWidth loginpopup');			
		});		
	}
	
	$(".sign-in").click(function(){
		openSignInForm();
		
	});
	
	$(".cc-cookie-accept-js").click(function(){
		fcom.ajax(fcom.makeUrl('Custom','updateUserCookies'), '', function(t){
				$(".cookie-alert").hide('slow');
				$(".cookie-alert").remove();
			});
	});
	
	$(document).on("click",'.increase-js',function(){	
		var val = $(this).parent('div').find('input').val();		
		val = parseInt(val)+1;		
		$(this).parent('div').find('input').val(val);
	});	
	
	$(document).on("click",'.decrease-js',function(){
		var val = $(this).parent('div').find('input').val();			
		val = parseInt(val)-1;	
		if( val <= 1 ){val = 1;}
		$(this).parent('div').find('input').val(val);
	});
	
	$(document).on("click",'.setactive-js li',function(){
		$(this).closest('.setactive-js').find('li').removeClass('is-active');
		$(this).addClass('is-active');
	});
	
	$(document).on("keydown",'input[name=user_username]',function(e){
		if (e.which === 32) {  return false; }	
		this.value = this.value.replace(/\s/g, "");	
	});

	$(document).on("change",'input[name=user_username]',function(e){	
		this.value = this.value.replace(/\s/g, "");	
	});

});

function isUserLogged(){
	var isUserLogged = 0;
	$.ajax({
		url: fcom.makeUrl('GuestUser','checkAjaxUserLoggedIn'),
		async: false,
		dataType: 'json',
	}).done(function(ans) {
		isUserLogged = parseInt( ans.isUserLogged );
	});
	return isUserLogged;
}

/* function checkisThemePreview(){
	var isThemePreview = 0;
	$.ajax({
		url: fcom.makeUrl('MyApp','checkisThemePreview'),
		async: false,
		dataType: 'json',
	}).done(function(ans) {
		isThemePreview = parseInt( ans.isThemePreview );
	});
	alert(isThemePreview);
	return isThemePreview;
} */

function loginPopUpBox(){
	/* fcom.ajax(fcom.makeUrl('GuestUser','LogInFormPopUp'), '', function(ans){
		$(".login-account a").click();
	}); */
	openSignInForm();
}
function setSiteDefaultLang(langId){ 
	fcom.ajax(fcom.makeUrl('Home','setLanguage',[langId]),'',function(res){
		document.location.reload();
	});
}

function setSiteDefaultCurrency(currencyId){ 
	fcom.ajax(fcom.makeUrl('Home','setCurrency',[currencyId]),'',function(res){
		document.location.reload();
	});
}

function quickDetail(selprod_id)
{
	$.facebox(function() {
		fcom.ajax(fcom.makeUrl('Products','productQuickDetail',[selprod_id]), '', function(t){
			fcom.updateFaceboxContent(t,'faceboxWidth productQuickView');
		});
	});
}
/* read more functionality [ */
$(document).delegate('.readMore' ,'click' , function(){
	var $this = $(this) ;
	var $moreText = $this.siblings('.moreText') ;
	var $lessText = $this.siblings('.lessText') ;
	
	if($this.hasClass('expanded')){
		$lessText.show();
		$moreText.hide();
		$this.text($linkMoreText) ;
	}else{
		$moreText.slideDown(1000);
		$lessText.hide();
		$this.text($linkLessText) ;
	}
	$this.toggleClass('expanded');
});
/* ] */

/* Request a demo button [ */
$(document).delegate('#btn-demo' ,'click' , function(){
	$.facebox(function() {
		fcom.ajax(fcom.makeUrl('Custom','requestDemo'), '', function(t){	
			fcom.updateFaceboxContent(t,'faceboxWidth requestdemo');
		});
	});
});
/* ] */

// Autocomplete */
	(function($) {
		$.fn.autocomplete = function(option) {
			return this.each(function() {
				this.timer = null;
				this.items = new Array();
		
				$.extend(this, option);
				
				$(this).attr('autocomplete', 'off');
				
				// Focus
				$(this).on('focus', function() {
					this.request();
				});
				
				// Blur
				$(this).on('blur', function() {
				
					setTimeout(function(object) {
						object.hide();
					}, 200, this);				
				});
				
				// Keydown
				$(this).on('keydown', function(event) {
					switch(event.keyCode) {
						case 27: // escape
						case 9: // tab	
							this.hide();
							break;
						default:
							this.request();
							break;
					}				
				});
				
				// Click
				this.click = function(event) {
					event.preventDefault();
		
					value = $(event.target).parent().attr('data-value');
		
					if (value && this.items[value]) {
						this.select(this.items[value]);
					}
				}
				
				// Show
				this.show = function() {
					var pos = $(this).position();
		
					$(this).siblings('ul.dropdown-menu').css({
						top: pos.top + $(this).outerHeight(),
						left: pos.left
					});
		
					$(this).siblings('ul.dropdown-menu').show();
				}
				
				// Hide
				this.hide = function() {
					$(this).siblings('ul.dropdown-menu').hide();
				}		
				
				// Request
				this.request = function() {
					clearTimeout(this.timer);
					this.timer = setTimeout(function(object) {
						
						var txt_box_width = $(object).outerWidth();
						$(object).siblings('ul.dropdown-menu').width(txt_box_width+'px');
						
						if( $(object).attr('name')=='keyword'){
							/* i.e header search form will enable autocomplete, if minimum characters are 3 */
							if($(object).val().length<3){ return; }
						}
						
						object.source($(object).val(), $.proxy(object.response, object));
					}, 200, this);
				}
				
				// Response
				this.response = function(json) {
					html = '';
		
					if (json.length) {
						for (i = 0; i < json.length; i++) {
							this.items[json[i]['value']] = json[i];
						}
		
						for (i = 0; i < json.length; i++) {
							if (!json[i]['category']) {
								html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
							}
						}
		
						// Get all the ones with a categories
						var category = new Array();
		
						for (i = 0; i < json.length; i++) {
							if (json[i]['category']) {
								if (!category[json[i]['category']]) {
									category[json[i]['category']] = new Array();
									category[json[i]['category']]['name'] = json[i]['category'];
									category[json[i]['category']]['item'] = new Array();
								}
		
								category[json[i]['category']]['item'].push(json[i]);
							}
						}
		
						for (i in category) {
							html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
		
							for (j = 0; j < category[i]['item'].length; j++) {
								html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
							}
						}
					}
		
					if (html) {
						this.show();
					} else {
						this.hide();
					}
		
					$(this).siblings('ul.dropdown-menu').html(html);
				}
				
				$(this).after('<ul class="dropdown-menu box--scroller"></ul>');
				$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			});
		}
	})(window.jQuery);  
	
	
$("document").ready(function(){	

	/* $("#btnProductBuy").on('click', function(event){
		event.preventDefault();
		var frmObj = $(this).parents("form");
		var selprod_id = $(frmObj).find('input[name="selprod_id"]').val();
		var quantity = $(frmObj).find('input[name="quantity"]').val();
		cart.add( selprod_id, quantity, true);
		return false;
	}); */
	
	/* $(".add-to-cart--js").on('click', function(event){ */
		$(document).delegate('.add-to-cart--js' ,'click' , function(event){
			$btn = $(this);
			event.preventDefault();
			var data = $("#frmBuyProduct").serialize();
			var yourArray = [];
    			$(".cart-tbl").find("input").each(function(e){
					
					console.log($(this).parent().parent().parent().attr('class'));
					if (($(this).val()>0) && (!$(this).parent().parent().siblings().hasClass("cancelled--js"))){
						 data = data+'&'+$(this).attr('lang')+"="+$(this).val();	 
					}
				});
			fcom.updateWithAjax(fcom.makeUrl('cart', 'add' ),data, function(ans) {
				if (ans['redirect']) {
					location = ans['redirect'];
					return false;
				}
				console.log($btn.hasClass("btnBuyNow"));
				if ($btn.hasClass("btnBuyNow")==true)
				{
					setTimeout(function () {
						window.location = fcom.makeUrl('Checkout');
					}, 300);
					return false;
				}
				if ($btn.hasClass("quickView")==true) {
					$(document).trigger('close.facebox');
				}
				$('span.cartQuantity').html(ans.total);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('html').toggleClass("cart-is-active");
				$('.cart').toggleClass("cart-is-active");
				$('#cartSummary').load(fcom.makeUrl('cart', 'getCartSummary'));
			});
			return false;
			
		}); 	
}); 	

/* nice select */
$(document).ready(function() {
  $('select').niceSelect();
  $('#category--js').niceSelect('destroy');
});
