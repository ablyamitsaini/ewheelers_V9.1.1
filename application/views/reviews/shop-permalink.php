<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$shop_city = $shop['shop_city'];
$shop_state = ( strlen($shop['shop_city']) > 0 ) ? ', '. $shop['shop_state_name'] : $shop['shop_state_name'];
$shop_country = ( strlen($shop_state) > 0 ) ? ', '.$shop['shop_country_name'] : $shop['shop_country_name'];
$shopLocation = $shop_city . $shop_state. $shop_country;
?>
<div id="body" class="body bg--gray">
    <div class="section section--pagebar">
      <div class="container container--fixed">
        <div class="row">
          <div class="col-md-8">
            <div class="cell">
             <!-- <div class="cell__left">
                <div class="avtar"><img alt="" src="images/150x150_4.jpg"></div>
              </div>-->
              <div class="cell__right">
                <div class="avtar__info">
                  <h5><?php echo $shop['shop_name']; ?></h5>
                  <p><?php echo $shopLocation; ?> <?php echo Labels::getLabel('LBL_Opened_on', $siteLangId); ?> <?php echo FatDate::format($shop['shop_created_on']); ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 align--right"><span class="gap"></span><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id'])); ?>" class="btn btn--primary"><?php echo Labels::getLabel('Lbl_Back_to_Shop',$siteLangId); ?></a></div>
        </div>
      </div>
    </div>
	<section class="section section--gray">
		<div class="container">
			<div id="itemRatings" class="section section--info clearfix">
				<div class="section__head">
				  <h4><?php echo Labels::getLabel('Lbl_Review_of',$siteLangId).' '. $shop['shop_name'] , ' ' ,Labels::getLabel('Lbl_by',$siteLangId),' : ',$reviewData['user_name'] ;?></h4>
				</div>
				<div class="section__body">
					<div class="box box--white">
						<div class="row listings__repeated">
							<div class="col-md-3">
								<div class="item__ratings">
								<ul class="rating">
								<?php for($j=1;$j<=5;$j++){ ?>
								<li class="<?php echo $j<=round($reviewData["shop_rating"])?"active":"in-active" ?>">
									<svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
									<g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="<?php echo $j<=round($reviewData["shop_rating"])?"#ff3a59":"#474747" ?>" /></g></svg>
								</li>
								<?php } ?>
								</ul>
								</div>
								<span class="text--normal"><?php echo round($reviewData["shop_rating"],1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5' ?></span>
								<span class="gap"></span>
								<h6><?php echo CommonHelper::displayName($reviewData['user_name']); ?></h6>
								<span class="text--normal"><?php echo Labels::getLabel('Lbl_On_Date',$siteLangId) , ' ',FatDate::format($reviewData['spreview_posted_on']); ?></span>
							</div>
							<div class="col-md-9">
								<div class="description">
									<h5><?php echo $reviewData['spreview_title']; ?></h5>
									<div class="description__body">
										<p>
										<span class='lessText'><?php echo CommonHelper::truncateCharacters($reviewData['spreview_description'],200,'','',true);?></span>
										<?php if(strlen($reviewData['spreview_description']) > 200) { ?>
										<span class='moreText' hidden>
										<?php echo nl2br($reviewData['spreview_description']); ?>
										</span>
										<a class="readMore link--arrow" href="javascript:void(0);"> <?php echo Labels::getLabel('Lbl_SHOW_MORE',$siteLangId) ; ?> </a>
										<?php } ?>
										</p>

									</div>
									<div class="description__footer">
										<div class="row">
											<div class="col-md-7 col-sm-7">
											<?php echo Labels::getLabel('Lbl_Was_this_review_helpful?',$siteLangId); ?>
											<a href="javascript:undefined;" onclick='markReviewHelpful(<?php echo FatUtility::int($reviewData['spreview_id']); ?>,1);return false;' class="yes"><i class="fa fa-thumbs-up"></i> <?php echo Labels::getLabel('Lbl_Yes',$siteLangId); ?></a> <a href="javascript:undefined;" onclick='markReviewHelpful("<?php echo $reviewData['spreview_id']; ?>",0);return false;' class="no"><i class="fa fa-thumbs-down"></i> <?php echo Labels::getLabel('Lbl_No',$siteLangId); ?></a><br>
											<small><?php if($reviewHelpfulData['countUsersMarked']){ echo $reviewHelpfulData['helpful'] ,' ' , Labels::getLabel('Lbl_Out_of',$siteLangId) ,' ', $reviewHelpfulData['countUsersMarked'] ?> <?php echo Labels::getLabel('Lbl_users_found_this_review_helpful',$siteLangId); } ?></small>
											</div>
											<div class="col-md-5 col-sm-5">
												<?php /* <ul class="links--inline align--right">
												<li><a href="javascript:void(0);" onclick="reviewAbuse(<?php echo $reviewData['spreview_id'] ?>);return false;"><?php echo Labels::getLabel('Lbl_Report_Abuse',$siteLangId); ?></a></li>
												</ul>*/ ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				 </div>
			</div>
		</div>
    </section>
	<div class="gap"></div>
</div>
<script>
var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE',$siteLangId); ?>';
var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS',$siteLangId); ?>';
</script>
</div>
