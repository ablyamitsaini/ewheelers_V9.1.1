$("document").ready(function(){
	searchWishList();
});

(function() {
	var dv = '#listingDiv';
	searchWishList = function(){
		$("#loadMoreBtnDiv").html('');
		$("#back-js").hide();
		$("#tab-wishlist").parents().children().removeClass("is-active");
		$("#tab-wishlist").addClass("is-active");
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account','wishListSearch'), '', function(res){
			$(dv).html(res);
		}); 
	};
	
	setupWishList2 = function(frm,event){
		if ( !$(frm).validate() ) return false;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setupWishList'), data, function(ans) {
			if( ans.status ){
				searchWishList();
			}
		});
	};
	
	deleteWishList = function( uwlist_id ){
		var agree = confirm( langLbl.confirmDelete );
		if( !agree ){ return false; };
		fcom.updateWithAjax(fcom.makeUrl('Account', 'deleteWishList'), 'uwlist_id=' + uwlist_id, function(ans) {
			if( ans.status ){
				searchWishList();
			}
		});
	};
	
	viewWishListItems = function( uwlist_id , append){
		if(typeof append == undefined || append == null){
			append = 0;
		}
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account','viewWishListItems'), 'uwlist_id=' + uwlist_id, function(ans){
			if( append == 1 ){ 
				$(dv).find('.loader-yk').remove();
				$(dv).append(ans);
			} else {
				$(dv).find('.loader-yk').remove();
				$(dv).html(ans);
			}
			
			
		}); 
	};
	viewFavouriteItems = function(frm, append ){
		if(typeof append == undefined || append == null){
			append = 0;
		}if(typeof frm == undefined || frm == null){
			frm = document.frmProductSearchPaging;
		}
		
			data = fcom.frmData(frm);
		

		if( append == 1 ){
			$(dv).prepend(fcom.getLoader());
		} else {
			$(dv).html(fcom.getLoader());
		}
		
		fcom.updateWithAjax(fcom.makeUrl('Account','searchFavouriteListItems'),data, function(ans){
			$.mbsmessage.close();
			if( append == 1 ){ 
				$(dv).find('.loader-yk').remove();
				$(dv).append(ans.html);
			} else {
				$(dv).html(ans.html);
			}
			$("#back-js").show();
			$("#loadMoreBtnDiv").html( ans.loadMoreBtnHtml );
		}); 
	};
	
	searchWishListItems = function( uwlist_id, append, page ){
		var dv2 = "#wishListItems";
		append = ( append == "undefined" ) ? 0 : append;
		page = ( page == "undefined" ) ? 0 : page;
		if( append == 1 ){
			$(dv2).append(fcom.getLoader());
		} else {
			$(dv2).html(fcom.getLoader());
		}
		
		fcom.updateWithAjax(fcom.makeUrl('Account','searchWishListItems'), 'uwlist_id=' + uwlist_id + '&page=' + page , function(ans){
			$.mbsmessage.close();
			$(dv).find('.loader-yk').remove();
			if( append == 1 ){
				$(dv2).find('.loader-Js').remove();
				$(dv2).append(ans.html);
			} else {
				$(dv2).html( ans.html );
			}
			
			/* for LoadMore[ */
			$("#loadMoreBtnDiv").html( ans.loadMoreBtnHtml );
			/* ] */
		}); 
	}
	
	goToProductListingSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page =1;
		}
		/* var frm = document.frmProductSearchPaging;		
		$(frm.page).val(page);
		$("form[name='frmProductSearchPaging']").remove(); */
		var uwlist_id = $("input[name='uwlist_id']").val();
		searchWishListItems( uwlist_id, 0, page );
	}
	
	goToFavouriteListingSearchPage = function(page){
		if(typeof page==undefined || page == null){
			page =1;
		}		
		 var frm = document.frmProductSearchPaging;		
		$(frm.page).val(page);
		
		viewFavouriteItems( frm, 0,page );
	}
	
	searchFavoriteShop = function(){
		$("#tab-fav-shop").parents().children().removeClass("is-active");
		$("#tab-fav-shop").addClass("is-active");
		$(dv).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account', 'favoriteShopSearch'), '', function(res){
			$(dv).html(res);
		}); 
	};
	
	toggleShopFavorite2 = function(shop_id){
		toggleShopFavorite(shop_id);
		searchFavoriteShop();
	}
})();