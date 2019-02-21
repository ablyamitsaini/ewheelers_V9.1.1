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
<div class="row">
	<?php $this->includeTemplate('_partial/product-overall-ratings.php',array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'product_id'=>$product_id),false); ?>
</div>
<div class="gap"></div>
<div class="tabs tabs--small tabs--scroll clearfix">
	<ul class="tabs-js group">
		<li><?php echo Labels::getLabel('Lbl_Reviews_by',$siteLangId); ?></li>
		<li class="is-active"><a href='javascript:void(0);' data-sort='most_helpful' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Helpful',$siteLangId); ?></a></li>
		<li><a href="javascript:void(0);" data-sort='most_recent' onclick="getSortedReviews(this);return false;"><?php echo Labels::getLabel('Lbl_Most_Recent',$siteLangId); ?> </a></li>
	</ul>
</div>
<div class="gap"></div>
<div class="box box--white box--radius box--space">
	<div class="listing__all"></div>
	<div id="loadMoreReviewsBtnDiv" class="reviews-lisitng"></div>
</div>
<script>
	var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE',$siteLangId); ?>';
	var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS',$siteLangId); ?>';

	$('#itemRatings div.progress__fill').css({'clip':'rect(0px, <?php echo $pixelToFillRight; ?>px, 160px, 0px)'});
</script>