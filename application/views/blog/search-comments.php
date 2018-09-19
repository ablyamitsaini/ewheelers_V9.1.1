<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if($commentsCount){
	foreach($blogPostComments as $comment){
?>

<div class="comment even thread-even depth-1 comment-element" id="li-comment-13881">
	<article id="comment-13881" class="comment">
		<header class="comment-meta comment-author vcard">
			<img alt="" src="<?php echo CommonHelper::generateUrl('image','user', array($comment['bpcomment_user_id'], "THUMB",1),CONF_WEBROOT_FRONT_URL); ?>" class="avatar avatar-60 photo" width="60" height="60">
			<cite class="fn"><?php echo CommonHelper::displayName($comment['bpcomment_author_name']); ?></cite>
			<a class="comment-time-link" href="javascript:void(0)"><time datetime="<?php echo FatDate::format($comment['bpcomment_added_on']); ?>"><?php echo FatDate::format($comment['bpcomment_added_on']); ?></time></a>
		</header>
		<!-- .comment-meta -->
		<section class="comment-content comment">
			<p><?php echo nl2br($comment['bpcomment_content']); ?></p>
		</section>
		<!-- .comment-content -->
	</article>
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
