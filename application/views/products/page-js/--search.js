$(document).ready(function(){	
	bannerAdds();
});

(function() {
	bannerAdds = function(){
		fcom.ajax(fcom.makeUrl('Banner','searchListing'), '', function(res){
			$("#searchPageBanners").html(res);
		}); 
	};	
})();	