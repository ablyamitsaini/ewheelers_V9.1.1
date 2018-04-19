$(document).ready(function(){
	
	
	
	/******** function for scrollbar  ****************/  
	if($(window).width()>1050){    
		$('.scrollbar').enscroll({
			verticalTrackClass: 'scroll__track',
			verticalHandleClass: 'scroll__handle'
		});
	}
	$('.toggle--details-js').click(function(){
		$(this).toggleClass("is-active");
		$('.target--details-js').slideToggle("slow");
	});  
  
	/* 7 items slider */
	$('.slides--seven-js').slick({
	  slidesToShow: 7,
	  slidesToScroll: 1,     
	  infinite: false, 
	  arrows: true, 
	  prevArrow: '<a data-role="none" class="slick-prev" aria-label="previous"></a>',
	  nextArrow: '<a data-role="none" class="slick-next" aria-label="next"></a>',    
	  responsive: [
	   {
		  breakpoint:1050,
		  settings: {
			slidesToShow: 5,
		  }
		},
		{
		  breakpoint:990,
		  settings: {
			slidesToShow: 3,
		  }
		} ,
		{
		  breakpoint:767,
		  settings: {
			slidesToShow: 3,
		  }
		}  ,
		{
		  breakpoint:400,
		  settings: {
			slidesToShow: 2,
		  }
		}   
	  ]    
	});
	
	/* 6 items slider */ 
	$('.slides--six-js').slick({
	  slidesToShow: 6,
	  slidesToScroll: 1,     
	  infinite: false, 
	  arrows: true, 
	  prevArrow: '<a data-role="none" class="slick-prev" aria-label="previous"></a>',
	  nextArrow: '<a data-role="none" class="slick-next" aria-label="next"></a>',    
	  responsive: [
	   {
		  breakpoint:1050,
		  settings: {
			slidesToShow: 5,
		  }
		},
		{
		  breakpoint:990,
		  settings: {
			slidesToShow: 3,
		  }
		} ,
		{
		  breakpoint:767,
		  settings: {
			slidesToShow: 2,
		  }
		}  ,
		{
		  breakpoint:400,
		  settings: {
			slidesToShow: 1,
		  }
		}   
	  ]    
	}); 

});

(function() {
	searchCategoryProducts = function (catId, shopId){
		$(document.frmProductSearch.category).val(catId);
		searchProducts(document.frmProductSearch);		
		if(typeof shopId != undefined && shopId > 0){
			d = new Date();
			$('#shopCatBanner').attr('src',fcom.makeUrl('Shops','Banner',[shopId,'wide',catId])+'?'+d.getTime());
		}		
	};
})();