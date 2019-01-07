<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if($reviewsList){
	// CommonHelper::printArray($reviewsList); die;
	foreach($reviewsList as $review){ ?>
	<div id="one" class="tab-item" style="display:block;">
	  <div class="helpfull">
		<div class="row">
		  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
			<div class="avatar avatar--92"><img src="<?php echo CommonHelper::generateUrl('Image','user',array($review['spreview_postedby_user_id'],'thumb',true));?>" alt="<?php echo $review['user_name']; ?>"></div>
		  </div>
		  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
			<div class="user-detail">
			  <div class="by-name"><?php echo Labels::getLabel('Lbl_By',$siteLangId) ; ?> <?php echo CommonHelper::displayName($review['user_name']); ?> <?php echo Labels::getLabel('Lbl_On_Date',$siteLangId) , ' ',FatDate::format($review['spreview_posted_on']); ?> </div>
			  <div class="his-long-comment cms-editor">
				<h2><?php echo $review['spreview_title']; ?></h2>
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
			</div>
		  </div>
		  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
			<div class="verified">
			  <div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
				<path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"></path>
				</svg> </i><span class="rate"><?php echo round($review["prod_rating"],1); ?></span> </div>
			  <!--<p><img src="images/verified.png" class="inline--block" alt=""> <em><strong>Verfied Buyer</strong></em></p>-->
			  <div class="yes-no">
				<ul>
				  <li><a href="javascript:undefined;" onclick='markReviewHelpful(<?php echo FatUtility::int($review['spreview_id']); ?>,1);return false;' class="yes"><img src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-up.png" alt="<?php echo Labels::getLabel('LBL_Helpful', $siteLangId); ?>"> (<?php echo $review['helpful']; ?>) </a></li>
				  <li><a href="javascript:undefined;" onclick='markReviewHelpful("<?php echo $review['spreview_id']; ?>",0);return false;' class="no"><img src="<?php echo CONF_WEBROOT_URL; ?>images/thumb-down.png" alt="<?php echo Labels::getLabel('LBL_Not_Helpful', $siteLangId); ?>"> (<?php echo $review['notHelpful']; ?>) </a></li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
<?php } ?>
<div class=" align--center"><a href="<?php echo CommonHelper::generateUrl('Reviews','Product',array($selprod_id));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('Lbl_Showing_All',$siteLangId).' '.count($reviewsList).' '.Labels::getLabel('Lbl_Reviews',$siteLangId) ; ?> </a></div>
<?php echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSearchReviewsPaging') );
} else{
	$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
}?>
