<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if(!empty($postList)){
	foreach($postList as $blogPost ){ ?>
<div class="post box box--white">
	<div class="col-md-5 col-sm-5 col--left">
		<div class="post__pic"><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($blogPost['post_id'],$siteLangId, "MEDIUM"),CONF_WEBROOT_URL); ?>" alt="<?php echo $blogPost['post_title']?>"></a></div>
	</div>
   <div class="col-md-7 col-sm-7">
	   <div class="post__head">
		   <h4><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" title="<?php echo $blogPost['post_title']; ?>" ><?php echo CommonHelper::truncateCharacters($blogPost['post_title'] , 50,'','',true); ?></a></h4>
	   </div>
	   <div class="post__body">
		   <div class="row">
				<div class="col-md-8">
					<span class="text--normal">
					<?php echo Labels::getLabel('Lbl_By',$siteLangId); ?> <a href="javascript:void(0)" class="text--dark"><?php echo CommonHelper::displayName($blogPost['post_author_name']); ?></a> <?php echo Labels::getLabel('Lbl_on',$siteLangId); ?> <span class="text--dark"><?php echo FatDate::format($blogPost['post_published_on']); ?></span>
					<?php $categoryIds = !empty($blogPost['categoryIds'])?explode(',',$blogPost['categoryIds']):array();
					$categoryNames = !empty($blogPost['categoryNames'])?explode('~',$blogPost['categoryNames']):array();
					$categoryCodes = !empty($blogPost['categoryCodes'])?explode(',',$blogPost['categoryCodes']):array();
					$categories = array_combine($categoryIds,$categoryNames);
					$categoryCodes = array_combine($categoryIds,$categoryCodes);
					$activeCategories = BlogPostCategory::getActiveCategoriesFromCodes($categoryCodes);
					
					$categories = array_intersect_key($categories ,array_flip($activeCategories));
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
					</span>
				</div>
				<div class="col-md-4">
				<?php if($blogPost['post_comment_opened']){ ?>
					<span class="text--normal">
						<a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])),'#container--comment-form'; ?>"><i class="fa fa-comment"></i><?php echo Labels::getLabel('Lbl_Leave_a_comment',$siteLangId); ?></a> 
					</span>
				<?php } ?>
				</div>
		   </div>

		   <div class="post__description">
			   <p><?php echo $blogPost['post_short_description']; ?></p>
		   </div>

	   </div>

	   <div class="post__footer">
		   <div class="row">
			   <div class="col-md-6 col-xs-6">
				  <a class="link--arrow text--uppercase" href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('Lbl_View_Full_Post',$siteLangId); ?></a>
			   </div>
			   <div class="col-md-6 col-xs-6">
					<ul class="list__socials">
						<li><?php echo Labels::getLabel('LBL_Share_On',$siteLangId); ?></li>
						<li class="social--fb"><a class='st_facebook_large' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Facebook'></a></li>
						<li class="social--tw"><a class='st_twitter_large' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Tweet'></a></li>
						<li class="social--pt"><a class='st_pinterest_large' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Pinterest'></a></li>
						<li class="social--mail"><a class='st_email_large' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Email'></a></li>
						<li class="social--wa"><a class='st_whatsapp_large' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Whatsapp'></a></li>
					</ul>
			   </div>
		   </div>
	   </div>
	</div>
</div>
<?php }

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmBlogSearchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
}else {
	?>
	<div class="post box box--white">
	<?php
	$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
	?>
	</div>
	<?php
}