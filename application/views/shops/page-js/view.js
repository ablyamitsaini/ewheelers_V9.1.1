$(document).ready(function(){ 
	// Target your element	
	searchProducts( document.frmProductSearch,0,0,0,1 );	
	if($(".shop-navigations").length){
		$('.shop-navigations').colourBrightness();
	}
	
	if($(".input-field").length){
		$('.input-field').colourBrightness();
	}
});
