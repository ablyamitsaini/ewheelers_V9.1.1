$(document).ready(function(){
	$('#slider-for').slick(getSlickGallerySettings(false) );
	$('#slider-nav').slick(getSlickGallerySettings(true) ); 
	/* $('#quickView-slider-for').slick(getSlickGallerySettings(false) );
	$('#quickView-slider-nav').slick( getSlickGallerySettings(true) ); */
	$('.gallery').modaal({
		type: 'image'
	});
	$('.social-toggle').on('click', function() {
	  $(this).next().toggleClass('open-menu');
	});
});


(function($) {

	var tabs =  $(".tabs-js li a");
  
	tabs.click(function() {
		var content = this.hash.replace('/','');
		tabs.removeClass("is-active");
		$(this).addClass("is-active");
    $(".tabs-content").find('.tab-item').hide();
    $(content).fadeIn(200);
	});

})(jQuery);


 $('.social-toggle').on('click', function() {
  $(this).next().toggleClass('open-menu');
});


/* for sticky things*/
      /* if($(window).width()>1050){
        function sticky_relocate() {
            var window_top = $(window).scrollTop();
            var div_top = $('.fixed__panel').offset().top -110;
            var sticky_left = $('#fixed__panel');
            if((window_top + sticky_left.height()) >= ($('.unique-heading').offset().top - 40)){
                var to_reduce = ((window_top + sticky_left.height()) - ($('.unique-heading').offset().top - 40));
                var set_stick_top = -40 - to_reduce;
                sticky_left.css('top', set_stick_top+'px');
            }else{
                sticky_left.css('top', '110px');
                if (window_top > div_top) {
                    $('#fixed__panel').addClass('stick');
                } else {
                    $('#fixed__panel').removeClass('stick');
                }
            }
        }

        $(function () {
            $(window).scroll(sticky_relocate);
            sticky_relocate();
        });
  }           */
  