<?php defined('SYSTEM_INIT') or die('Invalid Usage');
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id));
?>
<div id="body" class="body template-<?php echo $template_id;?>" role="main" <?php if($showBgImage){ /* echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; */ } ?> >
	<?php
		$shopData = array_merge($data,array( 'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action,'shopTotalReviews'=>$shopTotalReviews,'shopRating'=>$shopRating));
		$this->includeTemplate('shops/templates/'.$template_id.'.php',$shopData,false);
	?>
<?php echo $this->includeTemplate('products/listing-page.php',$data,false); ?>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
<script type="text/javascript">
(function($){
	if(langLbl.layoutDirection == 'rtl'){
		$('.shops-sliders').slick({
			arrows: false,
			dots: true,
			autoplay: true,
			pauseOnHover: false,
			speed: 500,
			fade: true,
			cssEase: 'linear',
            rtl:true
		});
	}
	else
	{
		$('.shops-sliders').slick({
		arrows: false,
			dots: true,
			autoplay: true,
			pauseOnHover: false,
			speed: 500,
			fade: true,
			cssEase: 'linear',
		});
	}
})(jQuery);

</script>
