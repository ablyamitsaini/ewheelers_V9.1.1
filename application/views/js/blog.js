$(document).ready(function () {

	$('.wrapper-menu').click(function () {
		$('html').toggleClass("nav-opened");
		$(this).toggleClass("open");
		
		$('.search-toggle').removeClass('active');
		$('html').removeClass("form-opened");
	});

	$('.search-toggle').on('click', function () {
		$(this).toggleClass('active');
		$('html').toggleClass("form-opened");
		
		$('.wrapper-menu').removeClass("open");
		$('html').removeClass("nav-opened");
	})

});

function submitBlogSearch(frm){
	var qryParam=($(frm).serialize_without_blank());
	var url_arr = [];
	if( qryParam.indexOf("keyword") > -1 ){
		var keyword = $(frm).find('input[name="keyword"]').val();
		var protomatch = /^(https?|ftp):\/\//;
		url_arr.push('keyword-'+encodeURIComponent(keyword.replace(protomatch,'').replace(/\//g,'-')));
	}
	
	if( qryParam.indexOf("category") > -1 ){
		url_arr.push('category-'+$(frm).find('select[name="category"]').val());
	}

	if(themeActive == true ){
		url = fcom.makeUrl('Blog','search', url_arr)+'?theme-preview';
		document.location.href = url;
		return;
	}
	url = fcom.makeUrl('Blog','search', url_arr);
	document.location.href = url;
}