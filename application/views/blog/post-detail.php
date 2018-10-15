<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
?>
<section class="">
	<div class="container">
		<div class="row">
			<div class=" col-lg-9 col-md-8 col-sm-9 col-xs-12">
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
					<div class="sticky-element">
						        <div class="sticky-element__social">
								<ul class="list__socials">
								  <li class="social--fb"><a class='st_facebook_large' displayText='Facebook'><span class="svg-icon">
						                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="18.124px" height="18.123px" viewBox="0 0 96.124 96.123" style="enable-background:new 0 0 96.124 96.123;"
	 xml:space="preserve">
<g>
	<path d="M72.089,0.02L59.624,0C45.62,0,36.57,9.285,36.57,23.656v10.907H24.037c-1.083,0-1.96,0.878-1.96,1.961v15.803
		c0,1.083,0.878,1.96,1.96,1.96h12.533v39.876c0,1.083,0.877,1.96,1.96,1.96h16.352c1.083,0,1.96-0.878,1.96-1.96V54.287h14.654
		c1.083,0,1.96-0.877,1.96-1.96l0.006-15.803c0-0.52-0.207-1.018-0.574-1.386c-0.367-0.368-0.867-0.575-1.387-0.575H56.842v-9.246
		c0-4.444,1.059-6.7,6.848-6.7l8.397-0.003c1.082,0,1.959-0.878,1.959-1.96V1.98C74.046,0.899,73.17,0.022,72.089,0.02z"/>
</g>
</svg></span></a></li>
								  <li class="social--tw"><a class='st_twitter_large' displayText='Tweet'><span class="svg-icon">
						                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
	<g>
		<path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016
			c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992
			c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056
			c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152
			c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792
			c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44
			C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568
			C480.224,136.96,497.728,118.496,512,97.248z"/>
	</g>
</g>
</svg></span></a></li>
								  <li class="social--pt"><a class='st_pinterest_large' displayText='Pinterest'><span class="svg-icon">
						                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 310.05 310.05" style="enable-background:new 0 0 310.05 310.05;" xml:space="preserve">
<g id="XMLID_798_">
	<path id="XMLID_799_" d="M245.265,31.772C223.923,11.284,194.388,0,162.101,0c-49.32,0-79.654,20.217-96.416,37.176
		c-20.658,20.9-32.504,48.651-32.504,76.139c0,34.513,14.436,61.003,38.611,70.858c1.623,0.665,3.256,1,4.857,1
		c5.1,0,9.141-3.337,10.541-8.69c0.816-3.071,2.707-10.647,3.529-13.936c1.76-6.495,0.338-9.619-3.5-14.142
		c-6.992-8.273-10.248-18.056-10.248-30.788c0-37.818,28.16-78.011,80.352-78.011c41.412,0,67.137,23.537,67.137,61.425
		c0,23.909-5.15,46.051-14.504,62.35c-6.5,11.325-17.93,24.825-35.477,24.825c-7.588,0-14.404-3.117-18.705-8.551
		c-4.063-5.137-5.402-11.773-3.768-18.689c1.846-7.814,4.363-15.965,6.799-23.845c4.443-14.392,8.643-27.985,8.643-38.83
		c0-18.55-11.404-31.014-28.375-31.014c-21.568,0-38.465,21.906-38.465,49.871c0,13.715,3.645,23.973,5.295,27.912
		c-2.717,11.512-18.865,79.953-21.928,92.859c-1.771,7.534-12.44,67.039,5.219,71.784c19.841,5.331,37.576-52.623,39.381-59.172
		c1.463-5.326,6.582-25.465,9.719-37.845c9.578,9.226,25,15.463,40.006,15.463c28.289,0,53.73-12.73,71.637-35.843
		c17.367-22.418,26.932-53.664,26.932-87.978C276.869,77.502,265.349,51.056,245.265,31.772z"/>
</g>
</svg></span></a></li>
								  <li class="social--mail"><a class='st_email_large' displayText='Email'><span class="svg-icon">
						                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 550.795 550.795" style="enable-background:new 0 0 550.795 550.795;" xml:space="preserve">
<g>

		<path d="M501.613,491.782c12.381,0,23.109-4.088,32.229-12.16L377.793,323.567c-3.744,2.681-7.373,5.288-10.801,7.767
			c-11.678,8.604-21.156,15.318-28.434,20.129c-7.277,4.822-16.959,9.737-29.045,14.755c-12.094,5.024-23.361,7.528-33.813,7.528
			h-0.306h-0.306c-10.453,0-21.72-2.503-33.813-7.528c-12.093-5.018-21.775-9.933-29.045-14.755
			c-7.277-4.811-16.75-11.524-28.434-20.129c-3.256-2.387-6.867-5.006-10.771-7.809L16.946,479.622
			c9.119,8.072,19.854,12.16,32.234,12.16H501.613z"></path>
		<path d="M31.047,225.299C19.37,217.514,9.015,208.598,0,198.555V435.98l137.541-137.541
			C110.025,279.229,74.572,254.877,31.047,225.299z"></path>
		<path d="M520.059,225.299c-41.865,28.336-77.447,52.73-106.75,73.195l137.486,137.492V198.555
			C541.98,208.396,531.736,217.306,520.059,225.299z"></path>
		<path d="M501.613,59.013H49.181c-15.784,0-27.919,5.33-36.42,15.979C4.253,85.646,0.006,98.97,0.006,114.949
			c0,12.907,5.636,26.892,16.903,41.959c11.267,15.061,23.256,26.891,35.961,35.496c6.965,4.921,27.969,19.523,63.012,43.801
			c18.917,13.109,35.368,24.535,49.505,34.395c12.05,8.396,22.442,15.667,31.022,21.701c0.985,0.691,2.534,1.799,4.59,3.269
			c2.215,1.591,5.018,3.61,8.476,6.107c6.659,4.816,12.191,8.709,16.597,11.683c4.4,2.975,9.731,6.298,15.985,9.988
			c6.249,3.685,12.143,6.456,17.675,8.299c5.533,1.842,10.655,2.766,15.367,2.766h0.306h0.306c4.711,0,9.834-0.924,15.368-2.766
			c5.531-1.843,11.42-4.608,17.674-8.299c6.248-3.69,11.572-7.02,15.986-9.988c4.406-2.974,9.938-6.866,16.598-11.683
			c3.451-2.497,6.254-4.517,8.469-6.102c2.057-1.476,3.605-2.577,4.596-3.274c6.684-4.651,17.1-11.892,31.104-21.616
			c25.482-17.705,63.01-43.764,112.742-78.281c14.957-10.447,27.453-23.054,37.496-37.803c10.025-14.749,15.051-30.22,15.051-46.408
			c0-13.525-4.873-25.098-14.598-34.737C526.461,63.829,514.932,59.013,501.613,59.013z"></path>
	</g>

</svg>
                                        </span></a></li>
								</ul>
						        </div>
						    </div>
					<div class="divider"></div>
					<div class="post__detail cms">
						<?php echo FatUtility::decodeHtmlEntities($blogPostData['post_description']); ?>
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
		  <div class="col-lg-3 col-md-4 col-sm-3 col-xs-12">
            <?php $this->includeTemplate('_partial/blogSidePanel.php'); ?>
          </div>
          <!--<div class="col-md-3 colums__right">
            <div class="wrapper--adds" >
              <div class="grids" id="div--banners"> </div>
            </div>
          </div>-->
        </div>
    </div>
</section>
<script>
var boolLoadComments = (<?php echo FatUtility::int($blogPostData['post_comment_opened']); ?>)?true:false ;

/* for social sticky */
	$(window).scroll(function(){
		body_height = $(".post-data").position();
		scroll_position = $(window).scrollTop();
		if(body_height.top < scroll_position)
			$(".post-data").addClass("is-fixed");
		else
			$(".post-data").removeClass("is-fixed");

	});

</script>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
