<?php defined('SYSTEM_INIT') or die('Invalid usage');
/* reviews processing */
$totReviews = FatUtility::int($reviews['totReviews']);
$avgRating = FatUtility::convertToType($reviews['prod_rating'],FatUtility::VAR_FLOAT);
$rated_1 = FatUtility::int($reviews['rated_1']);
$rated_2 = FatUtility::int($reviews['rated_2']);
$rated_3 = FatUtility::int($reviews['rated_3']);
$rated_4 = FatUtility::int($reviews['rated_4']);
$rated_5 = FatUtility::int($reviews['rated_5']);

$pixelToFillRight = $avgRating/5*160;
$pixelToFillRight = FatUtility::convertToType($pixelToFillRight,FatUtility::VAR_FLOAT);

$rate_5_width = $rate_4_width =$rate_3_width= $rate_2_width= $rate_1_width = 0;

if($totReviews){
	$rate_5_width = round(FatUtility::convertToType($rated_5/$totReviews*100,FatUtility::VAR_FLOAT),2);
	$rate_4_width = round(FatUtility::convertToType($rated_4/$totReviews*100,FatUtility::VAR_FLOAT),2);
	$rate_3_width = round(FatUtility::convertToType($rated_3/$totReviews*100,FatUtility::VAR_FLOAT),2);
	$rate_2_width = round(FatUtility::convertToType($rated_2/$totReviews*100,FatUtility::VAR_FLOAT),2);
	$rate_1_width = round(FatUtility::convertToType($rated_1/$totReviews*100,FatUtility::VAR_FLOAT),2);
}
?>
<div class="listings">
	<div class="listings__head">
		<div class="row">
		<?php

			?>
			<div class="col-md-8">
				<div class="ratings--overall">
					<div class="row">
						<div class="col-md-5 col-sm-5">
							<div class="progress progress--radial">
								<div class="progress__circle">
									<div class="progress__mask left">
										<div class="progress__fill" style="/* transform: rotate(106deg); */"></div>
										<span class="progress__count"><?php echo round($avgRating,1); ?></span>
									</div>
								</div>
							</div>
							<p class="align--center"><?php echo Labels::getLabel('Lbl_Based_on',$siteLangId) ,' ', $totReviews ,' ',Labels::getLabel('Lbl_ratings',$siteLangId);?></p>
						</div>
						<div class="col-md-7 col-sm-7">
							<ul class="listing--progress">
								<li>
									<span class="grid--left">5 <?php echo Labels::getLabel('Lbl_Star',$siteLangId); ?></span>
									<div class="grid--right">
									<div class="progress progress--horizontal">
									<div title="<?php echo $rate_5_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_5_stars',$siteLangId); ?>" style="width: <?php echo $rate_5_width; ?>%" role="progressbar" class="progress__bar"></div>
									</div>
									</div>
								</li>
								<li>
									<span class="grid--left">4 <?php echo Labels::getLabel('Lbl_Star',$siteLangId); ?></span>
									<div class="grid--right">
									<div class="progress progress--horizontal">
									<div title="<?php echo $rate_4_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_4_stars',$siteLangId); ?>" style="width: <?php echo $rate_4_width; ?>%" role="progressbar" class="progress__bar"></div>
									</div>
									</div>
								</li>
								<li>
									<span class="grid--left">3 <?php echo Labels::getLabel('Lbl_Star',$siteLangId); ?></span>
									<div class="grid--right">
									<div class="progress progress--horizontal">
									<div title="<?php echo $rate_3_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_3_stars',$siteLangId); ?>" style="width: <?php echo $rate_3_width; ?>%" role="progressbar" class="progress__bar"></div>
									</div>
									</div>
								</li>
								<li>
									<span class="grid--left">2 <?php echo Labels::getLabel('Lbl_Star',$siteLangId); ?></span>
									<div class="grid--right">
									<div class="progress progress--horizontal">
									<div title="<?php echo $rate_2_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_2_stars',$siteLangId); ?>" style="width: <?php echo $rate_2_width; ?>%" role="progressbar" class="progress__bar"></div>
									</div>
									</div>
								</li>
								<li>
									<span class="grid--left">1 <?php echo Labels::getLabel('Lbl_Star',$siteLangId); ?></span>
									<div class="grid--right">
									<div class="progress progress--horizontal">
									<div title="<?php echo $rate_1_width,'% ',Labels::getLabel('LBL_Number_of_reviews_have_1_stars',$siteLangId); ?>" style="width: <?php echo $rate_1_width; ?>%" role="progressbar" class="progress__bar"></div>
									</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 border--left">
				<div class="have-you">
					<p><?php echo Labels::getLabel('Lbl_Have_You_Used_This_Product',$siteLangId); ?>?</p>
					<a onClick = "rateAndReviewProduct(<?php echo $product_id; ?>)" href="javascript:void(0)" class="btn btn--secondary btn--sm ripplelink"><?php echo Labels::getLabel('Lbl_Rate_And_Review_Product',$siteLangId); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#itemRatings div.progress__fill').css({'clip':'rect(0px, <?php echo $pixelToFillRight; ?>px, 160px, 0px)'});
</script>
