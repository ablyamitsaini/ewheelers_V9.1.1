<?php defined('SYSTEM_INIT') or die('Invalid Usage');

	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input value="" type="submit" class="input-submit">';
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id));
	$haveBannerImage = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '' , $siteLangId );
 ?>

<div id="body" class="body template-<?php echo $template_id;?>" role="main" <?php if($showBgImage){ /* echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; */ } ?> >
	<?php
		$variables= array('shop'=>$shop, 'siteLangId'=>$siteLangId,'frmProductSearch'=>$frmProductSearch,'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action,'shopId'=>$shopId,'shopTotalReviews'=>$shopTotalReviews,'shopRating'=>$shopRating);
		$this->includeTemplate('shops/templates/'.$template_id.'.php',$variables,false);
	?>

	<?php if( $shop['shop_payment_policy'] != '' || $shop['shop_delivery_policy'] != '' || $shop['shop_refund_policy'] != '' || $shop['shop_additional_info'] != '' ||  $shop['shop_seller_info'] != ''){ ?>
	<section class="top-space">
		<div class="container">
		  <div class="white--bg padding20">
			<div class="row">
			  <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12">

				<?php if( $shop['shop_payment_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4><?php echo Labels::getLabel('LBL_PAYMENT_POLICY', $siteLangId); ?></h4>
				  <p><?php echo nl2br($shop['shop_payment_policy']); ?></p>
				</div>
				<?php } ?>

				<?php if( $shop['shop_delivery_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4><?php echo Labels::getLabel('LBL_DELIVERY_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_delivery_policy']); ?> </p>
				</div>
				<?php } ?>

				<?php if( $shop['shop_refund_policy'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_REFUND_POLICY', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_refund_policy']); ?> </p>
				</div>
				<?php } ?>

				<?php if( $shop['shop_additional_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_ADDITIONAL_INFO', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_additional_info']); ?> </p>
				</div>
				<?php } ?>

				<?php if( $shop['shop_seller_info'] != '' ){ ?>
				<div class="container--cms">
				  <h4> <?php echo Labels::getLabel('LBL_SELLER_INFO', $siteLangId); ?></h4>
				  <p> <?php echo nl2br($shop['shop_seller_info']); ?> </p>
				</div>
				<?php } ?>
			  </div>
			</div>
		  </div>
		</div>
    </section>
	<?php } ?>
	<div class="gap"></div>
	</div>
	<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
	<script type="text/javascript">
	(function($){
	searchProducts(document.frmProductSearch);
	if(langLbl.layoutDirection == 'rtl'){
		$('.shops-sliders').slick({
			dots: false,
			arrows:true,
			autoplay:true,
			rtl:true,
			pauseOnHover:false,
			speed: 500,
	fade: true,
	cssEase: 'linear',
		});
	}
	else
	{
		$('.shops-sliders').slick({
		dots: false,
		arrows:true,
		autoplay:true,
		pauseOnHover:false,
		speed: 500,
	fade: true,
	cssEase: 'linear',
		});
	}
	})(jQuery);
	</script>
