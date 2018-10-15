<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if($reviewsList){
	foreach($reviewsList as $review){ ?>
	<div class="row listings__repeated">
		<div class="col-md-3">
			<div class="item__ratings">
			<ul class="rating">
			<?php for($j=1;$j<=5;$j++){ ?>
			<li class="<?php echo $j<=round($review["shop_rating"])?"active":"in-active" ?>">
				<svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
				<g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="<?php echo $j<=round($review["shop_rating"])?"#ff3a59":"#474747" ?>" /></g></svg>
			</li>
			<?php } ?>
			</ul>
			</div>
			<span class="text--normal"><?php echo round($review["shop_rating"],1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5' ?></span>
			<span class="gap"></span>
			<h6><?php echo CommonHelper::displayName($review['user_name']); ?></h6>
			<span class="text--normal"><?php echo Labels::getLabel('Lbl_On_Date',$siteLangId) , ' ',FatDate::format($review['spreview_posted_on']); ?></span>
		</div>
		<div class="col-md-9">
		<div class="item-yk-head-title"><a title="<?php echo ($review['selprod_title']) ? $review['selprod_title'] : $review['product_name']; ?>" href="<?php echo CommonHelper::generateUrl('Products', 'View', array($review['selprod_id']) ); ?>"><?php echo ($review['selprod_title']) ? $review['selprod_title'] : $review['product_name']; ?></a></div>
			<div class="description">
				<h5><?php echo $review['spreview_title']; ?></h5>
				<div class="description__body">
					<p>
					<span class='lessText'><?php echo CommonHelper::truncateCharacters($review['spreview_description'],200,'','',true);?></span>
					<?php if(strlen($review['spreview_description']) > 200) { ?>
					<span class='moreText' hidden>
					<?php echo nl2br($review['spreview_description']); ?>
					</span>
					<a class="readMore link--arrow" href="javascript:void(0);"> <?php echo Labels::getLabel('Lbl_SHOW_MORE',$siteLangId) ; ?> </a>
					<?php } ?>
					</p>
				</div>
				<div class="description__footer">
					<div class="row">
						<div class="col-md-7 col-sm-7">
						<?php echo Labels::getLabel('Lbl_Was_this_review_helpful?',$siteLangId); ?>
						<a href="javascript:undefined;" onclick='markReviewHelpful(<?php echo FatUtility::int($review['spreview_id']); ?>,1);return false;' class="yes"><i class="fa fa-thumbs-up"></i> <?php echo Labels::getLabel('Lbl_Yes',$siteLangId); ?></a> <a href="javascript:undefined;" onclick='markReviewHelpful("<?php echo $review['spreview_id']; ?>",0);return false;' class="no"><i class="fa fa-thumbs-down"></i> <?php echo Labels::getLabel('Lbl_No',$siteLangId); ?></a><br>
						<small><?php if($review['countUsersMarked']){ echo $review['helpful'] ,' ' , Labels::getLabel('Lbl_Out_of',$siteLangId) ,' ', $review['countUsersMarked'] ?> <?php echo Labels::getLabel('Lbl_users_found_this_review_helpful',$siteLangId); } ?></small>
						</div>
						<div class="col-md-5 col-sm-5">
							<ul class="links--inline">
							<li><a href="<?php echo CommonHelper::generateUrl('Reviews','shopPermalink',array($review['spreview_seller_user_id'] , $review['spreview_id'])) ?>"><?php echo Labels::getLabel('Lbl_Permalink',$siteLangId); ?> </a></li>
							<?php /* <li><a href="javascript:void(0);" onclick="reviewAbuse(<?php echo $review['spreview_id'] ?>);return false;"><?php echo Labels::getLabel('Lbl_Report_Abuse',$siteLangId); ?></a></li> */ ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSearchReviewsPaging') );
} else{
	$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
}?>
