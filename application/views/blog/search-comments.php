<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if($commentsCount){
	foreach($blogPostComments as $comment){
?>
<div class="comment box box--white box--space">
   <div class="comment__head">
	   <h6><?php echo CommonHelper::displayName($comment['bpcomment_author_name']); ?></h6>
	   <span class="text--normal"><?php echo FatDate::format($comment['bpcomment_added_on']); ?></span>
   </div>
   <div class="comment__body">
	   <div class="comment__description">
			<p><?php echo nl2br($comment['bpcomment_content']); ?></p>
	   </div>
   </div>
</div>
	<?php }
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSearchCommentsPaging') );
} else{ ?>
	<div class="comment box box--white box--space">
	<?php if(!UserAuthentication::isUserLogged()){ ?>
	   <span class=""><a href="<?php echo CommonHelper::generateUrl('GuestUser','loginForm'); ?>" ><?php echo Labels::getLabel('Lbl_Login',$siteLangId); ?> </a> <?php echo Labels::getLabel('Lbl_Login_required_to_post_comment',$siteLangId); ?></span>
   <?php }else{
	   echo Labels::getLabel('Msg_No_Comments_on_this_blog_post',$siteLangId); ?> <!--<a href="javascript:undefined" class="link--post-comment-form" ><?php // echo Labels::getLabel('Lbl_Submit_your_comment',$siteLangId);?></a>-->
	   <?php
   } ?>
	</div>
<?php
}