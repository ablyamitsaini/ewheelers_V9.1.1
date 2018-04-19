<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/blogTopFeaturedCategories.php');
?>
<div id="body" class="body bg--grey">
  <div class="fixed-container">
    <div class="row">
      <div class="panel">
        <div class="colums clearfix">
          <div class="col-md-3 colums__right">
            <?php $this->includeTemplate('_partial/blogSidePanel.php'); ?>
          </div>
          <div class="col-md-9 colums__left">
            <div class="post post--details box box--white">
              <?php if(!empty($post_images)){ ?>
              <div class="post__pic">
                <?php foreach($post_images as $post_image){ ?>
                <div class="item"><img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($post_image['afile_record_id'],$post_image['afile_lang_id'], "BANNER",0 , $post_image['afile_id']),CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo $post_image['afile_name']; ?>"></div>
                <?php } ?>
              </div>
              <?php } ?>
              <div class="post__head">
                <h4><?php echo $blogPostData['post_title']; ?></h4>
              </div>
              <div class="post__body">
                <div class="row">
                  <div class="col-md-9"> <span class="text--normal"> <?php echo Labels::getLabel('Lbl_By',$siteLangId); ?> <a href="javascript:void(0)" class="text--dark"><?php echo $blogPostData['post_author_name']; ?></a> <?php echo Labels::getLabel('Lbl_on',$siteLangId); ?> <span class="text--dark"><?php echo FatDate::format($blogPostData['post_added_on']); ?></span>
                    <?php $categoryIds = !empty($blogPostData['categoryIds'])?explode(',',$blogPostData['categoryIds']):array();
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
									?>
                    </span> </div>
                  <div class="col-md-3 align--right">
                    <?php if($blogPostData['post_comment_opened']){ ?>
                    <span class="text--normal"> <a href="#container--comments"><i class="fa fa-comment"></i><?php echo $commentsCount,' ',Labels::getLabel('Lbl_Comments',$siteLangId); ?></a> </span>
                    <?php  } ?>
                  </div>
                </div>
                <div class="post__description container--cms"> <?php echo FatUtility::decodeHtmlEntities($blogPostData['post_description']); ?> </div>
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
            </div>
            <?php if($blogPostData['post_comment_opened']){ ?>
            <?php echo $srchCommentsFrm->getFormHtml(); ?>
            <div class="container--repeated" id='container--comments'>
              <h4><?php echo ($commentsCount)? sprintf(Labels::getLabel('Lbl_Comments(%s)',$siteLangId),$commentsCount):Labels::getLabel('Lbl_Comments',$siteLangId); ?></h4>
              <div id="comments--listing"> </div>
            </div>
            <div id="loadMoreCommentsBtnDiv"></div>
            <?php } ?>
            <?php if($blogPostData['post_comment_opened'] && UserAuthentication::isUserLogged() && isset($postCommentFrm)){ ?>
            <div class="container--repeated" id="container--comment-form">
              <h4><?php echo Labels::getLabel('Lbl_What_do_you_think',$siteLangId); ?></h4>
              <div class="box box--white padding20">
                <?php
					$postCommentFrm->setFormTagAttribute('class','form');
					$postCommentFrm->setFormTagAttribute('onsubmit','setupPostComment(this);return false;');
					$postCommentFrm->developerTags['colClassPrefix'] = 'col-md-';
					$postCommentFrm->developerTags['fld_default_col'] = '12';
					$nameFld = $postCommentFrm->getField('bpcomment_author_name');
					$nameFld->addFieldTagAttribute('readonly',true);
					$nameFld->developerTags['col'] =6;
					$emailFld = $postCommentFrm->getField('bpcomment_author_email');
					$emailFld->addFieldTagAttribute('readonly',true);
					$emailFld->developerTags['col'] =6;
					echo $postCommentFrm->getFormHtml();
				?>
              </div>
            </div>
            <?php } ?>
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