$(document).ready(function(){
	searchBlogs(document.frmBlogSearch);
	bannerAdds();
	
	$('.toggle-nav--vertical-js').click(function(){
		$(this).toggleClass("active");
		if($(window).width()<990){
			$('.nav--vertical-js').slideToggle();
		}
	});
	
});
(function() {
	bannerAdds = function(){
		fcom.ajax(fcom.makeUrl('Banner','blogPage'), '', function(res){
			$("#div--banners").html(res);
		}); 
	};	

	var dv = '#listing';
	var currPage = 1;
	
	reloadListing = function(){
		searchBlogs(document.frmBlogSearch);
	};
	
	searchBlogs = function(frm, append){
		if(typeof append == undefined || append == null){
			append = 0;
		}
		
		var data = fcom.frmData(frm);
		if( append == 1 ){
			$(dv).prepend(fcom.getLoader());
		} else {
			$(dv).html(fcom.getLoader());
		}
		if(bpCategoryId){
			data +='&categoryId='+bpCategoryId;
		}
		
		fcom.updateWithAjax(fcom.makeUrl('Blog','search'), data, function(ans){
			$.mbsmessage.close();			
			if( append == 1 ){
				$(dv).find('.loader-yk').remove();
				$(dv).append(ans.html);
			} else {
				$(dv).html(ans.html);
			}
			if($("#loadMoreBtnDiv").length){
				$("#loadMoreBtnDiv").html( ans.loadMoreBtnHtml );
			}
			
		}); 
	};
	
	goToSearchPage = function(page){
		if(typeof page == undefined || page == null){
			page = 1;
		}
		currPage = page;
		var frm = document.frmBlogSearchPaging;		
		$(frm.page).val(page);
		searchBlogs(frm);
	};
	
})();