$(document).ready(function(){	
	bannerAdds();
	
	searchProducts(document.frmProductSearch);
	
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
});

(function() {
	bannerAdds = function(){
		fcom.ajax(fcom.makeUrl('Banner','allProducts'), '', function(res){
			$("#allProductsBanners").html(res);
		}); 
	};	
})();