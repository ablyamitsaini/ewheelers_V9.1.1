<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
if(count($postList)>2 && (!isset($keyword)) && (!isset($bpCategoryId))){ require_once(CONF_THEME_PATH.'_partial/blogSlides.php'); }
	?>
<div class="posts--all" id='listing'></div>
<script>
	var bpCategoryId = <?php echo !empty($bpCategoryId) ? $bpCategoryId : 0; ?>;
	var keyword = '<?php echo !empty($keyword) ? $keyword : ''; ?>';

	$(document).ready(function() {
		if(langLbl.layoutDirection == 'rtl'){
			$('.js-posts-slider').slick({
				centerMode: true,
				centerPadding: '28%',
				slidesToShow: 1,
				arrows: true,
				rtl:true,
				responsive: [{
						breakpoint: 768,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});
		}else{
			$('.js-posts-slider').slick({
				centerMode: true,
				centerPadding: '28%',
				slidesToShow: 1,
				arrows: true,
				responsive: [{
						breakpoint: 768,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});
		}

	});

</script>
