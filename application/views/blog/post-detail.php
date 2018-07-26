<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/blogTopFeaturedCategories.php');
?>
<div id="body" class="body bg--grey">
  <div class="fixed-container">
    <div class="row">
      <div class="panel">
        <div class="colums clearfix">
          <div class="col-md-9 colums__left">
		  
		  
		  
		  
		  
		  
					<div class="posted-content">
						
						<div class="posted-media"><?php if(!empty($post_images)){ ?>
							<?php foreach($post_images as $post_image){ ?>
								<img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($post_image['afile_record_id'],$post_image['afile_lang_id'], "BANNER",0 , $post_image['afile_id']),CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo $post_image['afile_name']; ?>">
							<?php } }?>
						</div>
						
						<div class="post-data">
						<div class="post-meta-detail">
							<div class="posted-by">
								<span class="auther"><?php echo Labels::getLabel('Lbl_By',$siteLangId); ?> <?php echo $blogPostData['post_author_name']; ?></span> <span class="time"><?php echo FatDate::format($blogPostData['post_added_on']); ?></span>
							</div>
							<div class="post--title"><?php echo $blogPostData['post_title']; ?></div>
							<ul class="likes-count">
								<!--<li><i class="icn-like"><img src="/images/eyes.png"></i>500 Views</li>-->
								<li><i class="icn-msg"><img src="/images/comments.png"></i>20 Comments</li>
							</ul>
						</div>					
						<div class="divider"></div>
						<div class="post__detail cms">
							<h3> Choose an Easy to use Ecommerce Platform</h3>
							Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate.<br><br> There can be a lot of complications while building an ecommerce website. To save yourself from the time-consuming process and avoid common pit-falls, consider choosing an ecommerce platform. Depending on your business plan, budget and scale of operations, you can choose an ecommerce platform that’s growing continually in terms of user satisfaction and can meet your unique requirements. For instance, if you want to test the market and still avoid spending too much, try an ecommerce platform like YoKart. Other examples include CS-Cart & Magento.<br><br> Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate. Don’t wait — take action. Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate. Don’t wait — take action.<br><br> Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate.
							<h3>Educate Your Customers</h3>

							Customer education is one of the most important and yet underrated practices to ensure information security. Create a FAQ page where you address important tips and trick of ensuring a safe transaction.

							<h6>In these FAQs, you can educate customers on:</h6>
							<ul>
								<li>How to place an online order</li>
								<li>How to ensure information security</li>
								<li>What makes your ecommerce website secure</li>
								<li>How to keep credit card information secure</li>
							</ul>
							There can be a lot of complications while building an ecommerce website. To save yourself from the time-consuming process and avoid common pit-falls, consider choosing an ecommerce platform. Depending on your business plan, budget and scale of operations, you can choose an ecommerce platform that’s growing continually in terms of user satisfaction and can meet your unique requirements. For instance, if you want to test the market and still avoid spending too much, try an ecommerce platform like YoKart. Other examples include CS-Cart & Magento.
							<br><br>
							<p><strong>Also Read: <a href="#">Choosing the Right Ecommerce Platform for Optimal SEO</a></strong></p>

							<img src="images/post-img.jpg" alt="">
							<h3>Choose an Easy to use Ecommerce Platform</h3>
							<p>Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate.
								<br><br> There can be a lot of complications while building an ecommerce website. To save yourself from the time-consuming process and avoid common pit-falls, consider choosing an ecommerce platform. Depending on your business plan, budget and scale of operations, you can choose an ecommerce platform that’s growing continually in terms of user satisfaction and can meet your unique requirements. For instance, if you want to test the market and still avoid spending too much, try an ecommerce platform like YoKart. Other examples include CS-Cart & Magento.
								<br><br> Out of many reasons, a person opts to shop through an ecommerce store because of convenience and experience. By ignoring any one of the two, you deprive experience hungry buyers. Designing a good experience is a critical process and plays an important role to improve the efficiency and conversion rate.</p>


						</div>
						<div class="comments">
							<h3><strong>Comments (2) </strong></h3>
							<div class="comment even thread-even depth-1 comment-element" id="li-comment-13881">
								<article id="comment-13881" class="comment">
									<header class="comment-meta comment-author vcard">
										<img alt="" src="https://secure.gravatar.com/avatar/3c78b90a19e3599dafbf0322aa4d2bea?s=60&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/3c78b90a19e3599dafbf0322aa4d2bea?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" width="60" height="60"><cite class="fn">Raju Chakraborty </cite><a class="comment-time-link" href="https://www.fatbit.com/fab/ecommerce-link-building/#comment-13881"><time datetime="2018-05-24T16:37:27+00:00">May 24, 2018 at 4:37 pm</time></a> </header>
									<!-- .comment-meta -->


									<section class="comment-content comment">
										<p>Hello Kavya, thank you for the detailed article on the innovative ways to generate backlinks as well as the engagement. However, depending on the ecommerce products and services, we need to change our approaches to get better success. Will look forward to more articles of similar nature.</p>
									</section>
									<!-- .comment-content -->

									<div class="reply">
										<a rel="nofollow" class="comment-reply-link" href="#comment-13881" onclick="return addComment.moveForm( &quot;comment-13881&quot;, &quot;13881&quot;, &quot;respond&quot;, &quot;19302&quot; )" aria-label="Reply to Raju Chakraborty">Reply</a> </div>
									<!-- .reply -->
								</article>
								<!-- #comment-## -->
								<div class="comment byuser comment-author-kavya bypostauthor odd alt depth-2 comment-element" id="li-comment-13920">
									<article id="comment-13920" class="comment">
										<header class="comment-meta comment-author vcard">
											<img alt="" src="https://secure.gravatar.com/avatar/7f1b20aca688c74e741e32a992f9fd70?s=60&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/7f1b20aca688c74e741e32a992f9fd70?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" width="60" height="60"><cite class="fn">Kavya Nair <span> Post author</span></cite><a class="comment-time-link" href="https://www.fatbit.com/fab/ecommerce-link-building/#comment-13920"><time datetime="2018-05-30T14:42:38+00:00">May 30, 2018 at 2:42 pm</time></a> </header>
										<!-- .comment-meta -->


										<section class="comment-content comment">
											<p>Thanks Raju!<br> Certainly, ways of generating backlinks vary with business and industry.<br> -Kavya
											</p>
										</section>
										<!-- .comment-content -->

										<div class="reply">
											<a rel="nofollow" class="comment-reply-link" href="#comment-13920" onclick="return addComment.moveForm( &quot;comment-13920&quot;, &quot;13920&quot;, &quot;respond&quot;, &quot;19302&quot; )" aria-label="Reply to Kavya Nair">Reply</a> </div>
										<!-- .reply -->
									</article>
									<!-- #comment-## -->
								</div>
								<!-- #comment-## -->
							</div>
							<!-- #comment-## -->
							<!--</ol>-->
							<!-- .commentlist -->
						</div>
						<div class="gap"></div>
						<div id="respond" class="comment-respond">
							<h3><strong>Leave a Comment</strong></h3>
							
							<form class="form">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="field-set">
											<div class="field-wraper">
												<div class="field_cover">
													<input placeholder="First Name" class="first-name" title="" value="" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="field-set">
											<div class="field-wraper">
												<div class="field_cover">
													<input placeholder="sahil123@dummyid.com" class="email" title="" value="" type="text">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="field-set">
											<div class="field-wraper">
												<div class="field_cover">
													<textarea placeholder="Message"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="field-set">
											<div class="field-wraper">
												<div class="field_cover">
													<input placeholder="Security Code*" title="" value="" type="text">
													<div class="captcha"><span class="captcha-img"><img src="images/captcha.png" alt=""></span><span class="refresh"></span></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="field-set">
											<div class="field-wraper">
												<div class="field_cover">
													<input value="Submit" class="btn btn--block" type="submit">
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						
						</div>
						
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