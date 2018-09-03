<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
?>
<div id="body" class="body bg--grey">
<div class="gap"></div>
  <div class="fixed-container">
    <div class="row">
      <div class="panel">
        <div class="colums clearfix">
          <div class="col-md-9 colums__left">
				<div class="posted-content">
					
					<div class="posted-media">
					<?php if(!empty($post_images)){ ?>
					  <div class="post__pic">
						<?php foreach($post_images as $post_image){ ?>
						<div class="item"><img src="<?php echo FatUtility::generateUrl('image','blogPostFront', array($post_image['afile_record_id'],$post_image['afile_lang_id'], "BANNER",0 , $post_image['afile_id']),CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo $post_image['afile_name']; ?>"></div>
						<?php } ?>
					  </div>
					  <?php } ?>
					</div>
					
					<div class="post-data">
					<div class="post-meta-detail">
						<div class="posted-by">
							<span class="auther"><?php echo Labels::getLabel('Lbl_By',$siteLangId); ?> <?php echo $blogPostData['post_author_name']; ?></span> <span class="time"><?php echo FatDate::format($blogPostData['post_added_on']); ?></span><span class="time"><?php $categoryIds = !empty($blogPostData['categoryIds'])?explode(',',$blogPostData['categoryIds']):array();
								$categoryNames = !empty($blogPostData['categoryNames'])?explode('~',$blogPostData['categoryNames']):array();
								$categories = array_combine($categoryIds,$categoryNames);
								?>
						<?php if(!empty($categories)){
											echo Labels::getLabel('Lbl_in',$siteLangId);
											foreach($categories as $id=>$name){
												if($name == end($categories)){
												?>
						<a href="<?php echo CommonHelper::generateUrl('Blog','category',array($id)); ?>" class="text--dark"><?php echo $name; ?></a>
						<?php
													break;
												}
											?>
						<a href="<?php echo CommonHelper::generateUrl('Blog','category',array($id)); ?>" class="text--dark"><?php echo $name; ?></a>,
						<?php
											}
										}
										?></span>
						</div>
						<div class="post--title"><?php echo $blogPostData['post_title']; ?></div>
						<ul class="likes-count">
							<!--<li><i class="icn-like"><img src="<?php echo CONF_WEBROOT_URL; ?>images/eye.svg"></i>500 Views</li>-->
							<?php if($blogPostData['post_comment_opened']){ ?>
								<li><i class="icn-msg"><img src="<?php echo CONF_WEBROOT_URL; ?>images/comments.svg"></i><?php echo $commentsCount,' ',Labels::getLabel('Lbl_Comments',$siteLangId); ?></li>
							<?php  } ?>
						</ul>
					</div>					
					<div class="divider"></div>
					<div class="post__detail cms">
						<?php echo FatUtility::decodeHtmlEntities($blogPostData['post_description']); ?>
					</div>
					<div class="post__footer">
						<ul class="list__socials">
						  <li><?php echo Labels::getLabel('LBL_Share_On',$siteLangId); ?></li>
						  <li class="social--fb"><a class='st_facebook_large' displayText='Facebook'></a></li>
						  <li class="social--tw"><a class='st_twitter_large' displayText='Tweet'></a></li>
						  <li class="social--pt"><a class='st_pinterest_large' displayText='Pinterest'></i></a></li>
						  <li class="social--mail"><a class='st_email_large' displayText='Email'></i></a></li>
						  <li class="social--wa"><a class='st_whatsapp_large' displayText='Whatsapp'></i></a></li>
						</ul>
					</div>
					<?php if($blogPostData['post_comment_opened']){ ?>
					<?php echo $srchCommentsFrm->getFormHtml(); ?>
					<div class="gap"></div>
					<div class="comments" id="container--comments">
						<h3><strong><?php echo ($commentsCount)? sprintf(Labels::getLabel('Lbl_Comments(%s)',$siteLangId),$commentsCount):Labels::getLabel('Lbl_Comments',$siteLangId); ?></strong></h3>
					</div>
					<div id="comments--listing"> </div>
					<div id="loadMoreCommentsBtnDiv"></div>
					<?php } ?>
					<?php if($blogPostData['post_comment_opened'] && UserAuthentication::isUserLogged() && isset($postCommentFrm)){ ?>
					<div class="gap"></div>
					<div id="respond" class="comment-respond">
						<h3><strong><?php echo Labels::getLabel('Lbl_Leave_A_Comment',$siteLangId); ?></strong></h3>
						<?php
							$postCommentFrm->setFormTagAttribute('class','form');
							$postCommentFrm->setFormTagAttribute('onsubmit','setupPostComment(this);return false;');
							$postCommentFrm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
							$postCommentFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
							$postCommentFrm->developerTags['fld_default_col'] = 12;
							$nameFld = $postCommentFrm->getField('bpcomment_author_name');
							$nameFld->addFieldTagAttribute('readonly',true);
							$nameFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Name', $siteLangId));
							$nameFld->developerTags['col'] =6;
							$emailFld = $postCommentFrm->getField('bpcomment_author_email');
							$emailFld->addFieldTagAttribute('readonly',true);
							$emailFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Email_Address', $siteLangId));
							$emailFld->developerTags['col'] =6;
							$commentFld = $postCommentFrm->getField('bpcomment_content');
							$commentFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Message', $siteLangId));
							echo $postCommentFrm->getFormHtml();
						?>
					</div>
					<?php }?>
					
					</div>
				</div>
		  </div>
		  <div class="col-md-3 colums__right">
            <?php $this->includeTemplate('_partial/blogSidePanel.php'); ?>
          </div>
          <div class="col-md-3 colums__right">
            <div class="wrapper--adds" >
              <div class="grids" id="div--banners"> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="gap"></div>
</div>
<script>
var boolLoadComments = (<?php echo FatUtility::int($blogPostData['post_comment_opened']); ?>)?true:false ;
</script> 
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>