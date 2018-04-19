window.recordCount = 0;
$(document).ready(function(){
	$(document).delegate('.acc_ctrl','click',function(e){
		e.preventDefault();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).next()
			.stop()
			.slideUp(300);
		} else {
			$(this).addClass('active');
			$(this).next()
			.stop()
			.slideDown(300);
		}
	});
	searchFaqs(document.frmSearchFaqs);
	faqRightPanel();
});

(function() {
	var dv = '#listing';
	var dvCategoryPanel = '#categoryPanel';
	var currPage = 1;
	var faqCatId=1;
	reloadListing = function(){
		searchFaqs(document.frmSearchFaqs);
	};
	
	$(document).delegate('a.selectedCat','click',function(){
		var catId=$(this).attr('id');
		searchFaqs(catId);
	});
	
	searchFaqs = function(catId){
		if( catId < 0 ){
			catId = 0;
		}
		$(dv).html(fcom.getLoader());
		
		fcom.updateWithAjax(fcom.makeUrl('supplier','SearchFaqs', [catId]), '', function(ans){			
			$(dv).find('.loader-yk').remove();
			$(dv).html(ans.html);
			window.recordCount = ans.recordCount;
		}); 		
	};
	
	faqRightPanel = function(){
		fcom.updateWithAjax(fcom.makeUrl('supplier','faqCategoriesPanel'), '', function(ans){
			$.mbsmessage.close();	
			$(dv).find('.loader-yk').remove();
			$(dvCategoryPanel).html(ans.categoriesPanelHtml);
			if(ans.recordCount==0){
				$(".questions-section").remove();
			}
			window.recordCount = ans.recordCount;
		}); 
	}
	
	goToLoadMore = function( page ){
		if( typeof page == undefined || page == null){
			page = 1;
		}
		currPage = page;
		var frm = document.frmSearchFaqsPaging;		
		$(frm.page).val(page);
		searchFaqs(frm,1);
	};
})();

/******** for faq accordians  ****************/ 
$(document).delegate('.accordians__trigger-js','click',function(){
	if( $(this).hasClass('is-active') ){
		$(this).removeClass('is-active');
		$(this).siblings('.accordians__target-js').slideUp();
		return false;
	}
	$('.accordians__trigger-js').removeClass('is-active');
	$(this).addClass("is-active");
	$('.accordians__target-js').slideUp();
	$(this).siblings('.accordians__target-js').slideDown();
});

$(document).delegate('.nav--vertical-js li','click',function(){
	if( !window.recordCount ){
		document.frmSearchFaqs.reset();
		$this = $(this).find('a');
		searchFaqs(document.frmSearchFaqs , 0 ,function(){$this.trigger('click');});
		event.stopPropagation();
		return false;
	}else{
		$('.nav--vertical-js li').removeClass('is-active');
		$(this).addClass('is-active');
	}
});

/* for click scroll function */
$(document).delegate(".scroll",'click',function( event ){
	if( !window.recordCount ){
		document.frmSearchFaqs.reset();
		$this = $(this);//.find('a');
		searchFaqs(document.frmSearchFaqs , 0 ,function(){$this.trigger('click');});
		event.stopPropagation();
		return false;
	}
	event.preventDefault();
	var full_url = this.href;
	var parts = full_url.split("#");
	var trgt = parts[1];
	if( $("#"+trgt).length ){
		var target_offset = $("#"+trgt).offset();
		var target_top = target_offset.top;
		$('html, body').animate({scrollTop:target_top}, 1000);
	}
});
