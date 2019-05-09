$(document).ready(function(){
		/* alert(singleFeaturedProduct); */
		/* home page main slider */
        
        $('.js-collection-corner').slick( getSlickSliderSettings(6, 6, langLbl.layoutDirection) );
        
		if(langLbl.layoutDirection == 'rtl'){

			$('.js-hero-slider').slick({
				centerMode: false,
				slidesToShow: 1,
				variableWidth: false,
				arrows: false,
				dots: true,
				rtl:true,
				responsive: [{
					breakpoint: 1025,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
					}
				}, {
					breakpoint: 768,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
					}
				}, {
					breakpoint: 480,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
						dots: true,
					}
				}]
			});

			/* $('.js-collection-corner').slick({
				dots: false,
				arrows: false,
				autoplay: true,
				rtl:true,
				pauseOnHover: false,
				slidesToShow: 6,
				responsive: [{
					breakpoint: 1025,
					settings: {
						arrows: false,
						slidesToShow: 3,
					}
						}, {
					breakpoint: 500,
					settings: {
						arrows: false,
						slidesToShow: 2,
					}
						}]
			}); */

			$('.featured-item-js').slick({

			  centerMode: true,

			  centerPadding: '26%',

			  slidesToShow: 1,

			  rtl:true,

			  responsive: [

				{

				  breakpoint: 768,

				  settings: {

					arrows: false,

					centerMode: true,

					centerPadding: '5%',

					slidesToShow: 3

				  }

				},

				{

				  breakpoint:500,

				  settings: {

					arrows: false,

					centerMode: true,

					centerPadding: '0%',

					slidesToShow: 1

				  }

				}

			  ]

			});

			$('.fashion-corner-js').slick({
			   dots: false,
				arrows:false,
				autoplay:true,
				pauseOnHover:true,
				slidesToShow:6,
				rtl:true,
				 responsive: [
				{
				  breakpoint: 1025,
				  settings: {
					arrows: false,
					slidesToShow:3,
				  }
				},
				{
				  breakpoint: 500,
				  settings: {
					arrows: false,
					slidesToShow: 1,
				  }
				}
			  ]
			});

		}else{

			$('.js-hero-slider').slick({
				centerMode: false,
			
				slidesToShow: 1,
				variableWidth: false,
				arrows: false,
				dots: true,
				responsive: [{
					breakpoint: 1025,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
					}
				}, {
					breakpoint: 768,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
					}
				}, {
					breakpoint: 480,
					settings: {
						arrows: false,
						centerMode: false,
						centerPadding: '0px',
						variableWidth: false,
						slidesToShow: 1,
						dots: true,
					}
				}]
			});

			/* $('.js-collection-corner').slick({
				dots: false,
				arrows: false,
				autoplay: true,
				pauseOnHover: false,
				slidesToShow: 6,
				responsive: [{
					breakpoint: 1025,
					settings: {
						arrows: false,
						slidesToShow: 3,
					}
						}, {
					breakpoint: 500,
					settings: {
						arrows: false,
						slidesToShow: 2,
					}
						}]
			}); */

		$('.featured-item-js').slick({
		  centerMode: true,
		  centerPadding: '26%',
		  slidesToShow: 1,
		  responsive: [
			{
			  breakpoint: 768,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '5%',
				slidesToShow: 3
			  }
			},
			{
			  breakpoint:500,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '0%',
				slidesToShow: 1
			  }
			}
		  ]
		});

	  $('.fashion-corner-js').slick({
	   dots: false,
		arrows:false,
		autoplay:true,
		pauseOnHover:true,
		slidesToShow:6,
		 responsive: [
		{
		  breakpoint: 1025,
		  settings: {
			arrows: false,
			slidesToShow:3,
		  }
		},
		{
		  breakpoint: 500,
		  settings: {
			arrows: false,
			slidesToShow: 1,
		  }
		}
	  ]
	});

		}

/*Tabs*/
$(".tabs-content-js").hide();
$(".tabs--flat-js li:first").addClass("is-active").show();
$(".tabs-content-js:first").show();
$(".tabs--flat-js li").click(function () {
	$(".tabs--flat-js li").removeClass("is-active");
	$(this).addClass("is-active");
	$(".tabs-content-js").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
	setSlider();
});

});
