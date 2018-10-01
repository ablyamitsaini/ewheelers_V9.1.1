$(document).ready(function(){
		/* alert(singleFeaturedProduct); */
		/* home page main slider */
		if(langLbl.layoutDirection == 'rtl'){
			$('.yk-slides').slick({
				dots: false,
				arrows:true,
				autoplay:true,
				pauseOnHover:true,
				rtl:true,
				adaptiveHeight:false,
				responsive: [
				{
				  breakpoint: 768,
				  settings: {
					arrows: false,


				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					arrows: false,
				  }
				}
			  ]

			});

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
			$('.trending-corner').slick({
			   dots: false,
				arrows:false,
				autoplay:true,
				pauseOnHover:true,
				slidesToShow:4,
				rtl:true,
				 responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					arrows: false,
					slidesToShow:2,
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
			$('.yk-slides').slick({

				dots: false,
				arrows:true,
				autoplay:true,
				pauseOnHover:true,
				adaptiveHeight:false,
				responsive: [
				{
				  breakpoint: 768,
				  settings: {
					arrows: false,

				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					arrows: false,
				  }
				}
			  ]


			});

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
	$('.trending-corner').slick({
	   dots: false,
		arrows:false,
		autoplay:true,
		pauseOnHover:true,
		slidesToShow:4,
		 responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			arrows: false,
			slidesToShow:2,
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





});
