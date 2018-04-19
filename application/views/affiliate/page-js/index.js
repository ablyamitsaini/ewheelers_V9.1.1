$(document).ready(function(){
	personalInfo();
});

(function() {
	var tabListing = "#tabListing";
	
	personalInfo = function(el){
		$(tabListing).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Account','personalInfo'), '', function(res){
			$(tabListing).html(res);
			$(el).parent().siblings().removeClass('is-active');
			$(el).parent().addClass('is-active');
		});
	};
	
	addressInfo = function( el ){
		$(tabListing).html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Affiliate','addressInfo'), '', function(res){
			$(tabListing).html(res);
			$(el).parent().siblings().removeClass('is-active');
			$(el).parent().addClass('is-active');
		});
	}
})();