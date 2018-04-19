$(document).ready(function(){
	searchProducts(document.frmProductSearch);
	
	/* for toggling of grid/list view[ */
	$('.switch--link-js').on('click',function(e) {
		$('.switch--link-js').removeClass("is-active");
		$(this).addClass("is-active");
		if ($(this).hasClass('list')) {
			$('.section--items').removeClass('gridview').addClass('listview');
		}
		else if($(this).hasClass('grid')) {
			$('.section--items').removeClass('listview').addClass('gridview');
		}
	});
	/* ] */
	
});
(function() {
	var processing_product_load = false;
	
	searchProducts = function(frm, append = 0){
		if( processing_product_load == true ) return false;
		processing_product_load = true;
		var dv = $("#productsList")
		if( append == 1 ){
			$(dv).append(fcom.getLoader());
		} else {
			$(dv).html(fcom.getLoader());
		}
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Products','setupSearch'),data,function(ans){
			processing_product_load = false;
			$.mbsmessage.close();
			if( append == 1 ){
				$(dv).find('.loader-yk').remove();
				$(dv).append(ans.html);
			} else {
				$(dv).html( ans.html );
			}
			
			/* for LoadMore[ */
			var nextPage = parseInt(ans.page) + 1;
			if( nextPage <= ans.pageCount ){
				$("#loadMoreBtn").attr('onClick', 'goToSearchPage(' + nextPage + ')');
			} else {
				$("#loadMoreBtn").remove();
			}
			/* ] */
			
		});
	}
	
	goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}		
		var frm = document.frmProductSearchPaging;		
		$(frm.page).val(page);
		$("form[name='frmProductSearchPaging']").remove();
		searchProducts(frm, 1);
	}
})();