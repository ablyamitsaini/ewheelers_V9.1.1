$(document).ready(function() {
	$(document).on('click', '#accordian li span.acc-trigger', function() {
		var link = $(this);
		var closest_ul = link.siblings("ul");

		if( link.hasClass("is--active") ){
			closest_ul.slideUp();
			link.removeClass( "is--active" );
		} else {
			closest_ul.slideDown();
			link.addClass( "is--active" );
		}
	});
	/* $("#accordian a").click(function() {
		var link = $(this);
		var closest_ul = link.closest("ul");
		var parallel_active_links = closest_ul.find(".active")
		var closest_li = link.closest("li");
		var link_status = closest_li.hasClass("active");
		var count = 0;

		closest_ul.find("ul").slideUp(function() {
			if (++count == closest_ul.find("ul").length)
			parallel_active_links.removeClass("active");
		});

		if ( !link_status ) {
			closest_li.children("ul").slideDown();
			closest_li.addClass("active");
		}
	}); */


  /* for left filters  */
    $('.link__filter').click(function() {
        $(this).toggleClass("active");
        var el = $("body");
        if(el.hasClass('filter__show')) el.removeClass("filter__show");
        else el.addClass('filter__show');
        return false;
    });
    $('body').click(function(){
        if($('body').hasClass('filter__show')){
            $('.link__filter').removeClass("active");
            $('body').removeClass('filter__show');
        }
    });

    $('.filter__overlay').click(function(){
        if($('body').hasClass('filter__show')){
            $('.link__filter').removeClass("active");
            $('body').removeClass('filter__show');
        }
    });

     $('.productFilters-js').click(function(e){
            e.stopPropagation();
        });




		 /* for mobile toggle */
		  if($(window).width()<1025){
            $(".productFilters-js").on("click",".filter-head-js", function(){
				if($(this).hasClass('active')){
                  $(this).removeClass('active');
				  $(this).next().slideUp();
				}
				else{
					$(this).addClass('active');
					$(this).next().slideDown();
				}
			 /*  if($(this).hasClass('active')){
                  $(this).removeClass('active');
                  $(this).siblings('.toggle-target').slideUp();
                  return false;
              }
              $('.filter .widgets-heading').removeClass('active');
              $(this).addClass("active");

                  $('.filter .toggle-target').slideUp();
                  $(this).siblings('.filter .toggle-target').slideDown();

              return; */

            });

		   }



		/* for sticky left panel */
/*     if($(window).width()>1050){
        function sticky_relocate() {
            var window_top = $(window).scrollTop();
            var div_top = $('.fixed__panel').offset().top -110;
            var sticky_left = $('#fixed__panel');
            if((window_top + sticky_left.height()) >= ($('#footer').offset().top - 40)){
                var to_reduce = ((window_top + sticky_left.height()) - ($('#footer').offset().top - 40));
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
	  } */
});
