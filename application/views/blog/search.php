<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if(!empty($postList)){ 
	if(count($postList)>2){ ?>
	<section>
		<div class="js-posts-slider posts-slider" dir="<?php echo CommonHelper::getLayoutDirection();?>">
		 <?php foreach($postList as $blogPost ){ ?>
			<div class="post-item">
				<div class="post-media"><img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($blogPost['post_id'],$siteLangId, "BANNER"),CONF_WEBROOT_URL); ?>" data-ratio="16:9" alt="<?php echo $blogPost['post_title']?>" class="img"></div>
				<div class="post-data">
					<div class="date-wrap"><span class="tag"><?php echo Labels::getLabel('Lbl_Latest_Post',$siteLangId); ?></span></div>
					<div class="post-heading">
						<h2><?php echo $blogPost['post_title']; ?></h2>
					</div>
					<a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" class="links"><?php echo Labels::getLabel('Lbl_Read_More',$siteLangId); ?></a>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>
	<?php }?>


	<?php $outerSectionCount=1; $innerListcount = 1;
	foreach($postList as $blogPost ){
		if($outerSectionCount%2!=0) {
			if($innerListcount == 1){ ?>
				<section class="section">
					<div class="container">
						<div class="post-list">
			<?php }?>
			<article class="post-repeated <?php echo ($innerListcount%2==0) ? "odd" : ""; ?>">
				<div class="posted-media">
					<div class="posted-media-inner"><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($blogPost['post_id'],$siteLangId, "BANNER"),CONF_WEBROOT_URL); ?>" alt="<?php echo $blogPost['post_title']?>"></a></div>
				</div>
				<div class="posted-data-side">
					<div class="posted-data">
						<div class="posted-by"><span class="auther"><?php echo Labels::getLabel('Lbl_By',$siteLangId)." "; ?> <?php echo CommonHelper::displayName($blogPost['post_author_name']); ?></span> <span class="time"><?php echo FatDate::format($blogPost['post_published_on']); ?></span></div>
						<h2><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><?php echo $blogPost['post_title']?></a></h2>
						<a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" class="btn btn--bordered"><?php echo Labels::getLabel('Lbl_Read_More',$siteLangId); ?></a>
						<div class="share-this">
						<ul class="blogs-listing list__socials">
							<!--<li><a href="javascript:void(0)" class='sharethis_custom'></a></li>-->
							<li class="social--fb"><a class='st_facebook_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Facebook'></a></li>
							<li class="social--tw"><a class='st_twitter_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Tweet'></a></li>
							<li class="social--pt"><a class='st_pinterest_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Pinterest'></a></li>
							<li class="social--mail"><a class='st_email_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Email'></a></li>
							<li class="social--wa"><a class='st_whatsapp_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Whatsapp'></a></li>
						</ul>
						</div>
					</div>
				</div>
			</article>
			<?php  if($innerListcount == 2){?>
				</div>
			</div>
		</section><?php $outerSectionCount++; }
		$innerListcount++;
		} else {
			if($innerListcount == 3){?>
			<section class="bg-pattern">
				<div class="container">
					<div class="row">
				<?php }?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="recent-posts">
							<div class="posted-media">
								<div class="posted-media-inner"><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><img src="<?php echo CommonHelper::generateUrl('image','blogPostFront', array($blogPost['post_id'],$siteLangId, "BANNER"),CONF_WEBROOT_URL); ?>" alt="<?php echo $blogPost['post_title']?>"></a></div>
							</div>
							<div class="posted-data-side">
								<div class="posted-data">
									<div class="posted-by"><span class="auther"><?php echo Labels::getLabel('Lbl_By',$siteLangId)." "; ?> <?php echo CommonHelper::displayName($blogPost['post_author_name']); ?></span> <span class="time"><?php echo FatDate::format($blogPost['post_published_on']); ?></span></div>
									<h2><a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>"><?php 
									$strLen = mb_strlen($blogPost['post_title']);	
									if($strLen > 50){
											echo mb_substr($blogPost['post_title'],0,50).'...';}
									else{	echo $blogPost['post_title'];
									}?></a></h2>
									<a href="<?php echo CommonHelper::generateUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" class="btn btn--bordered"><?php echo Labels::getLabel('Lbl_Read_More',$siteLangId); ?></a>
									<div class="share-this">
										<ul class="blogs-listing list__socials">
											<!--<li><a href="javascript:void(0)" class='sharethis_custom'></a></li>-->
											<li class="social--fb"><a class='st_facebook_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Facebook'></a></li>
											<li class="social--tw"><a class='st_twitter_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Tweet'></a></li>
											<li class="social--pt"><a class='st_pinterest_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Pinterest'></a></li>
											<li class="social--mail"><a class='st_email_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Email'></a></li>
											<li class="social--wa"><a class='st_whatsapp_custom' st_url="<?php echo CommonHelper::generateFullUrl('Blog','postDetail',array($blogPost['post_id'])); ?>" st_title="<?php echo $blogPost['post_title']; ?>" displayText='Whatsapp'></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php if($innerListcount >= 5){?>
					</div>
				</div>
			</section>
		<?php $innerListcount = 1;
				$outerSectionCount++;
				}else{
				$innerListcount++;
			}
		}

	} ?>


<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmBlogSearchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
?>
<script type="text/javascript">
	$(document).ready(function() {
		if(langLbl.layoutDirection == 'rtl'){
			$('.js-posts-slider').slick({
				centerMode: true,
				centerPadding: '28%',
				slidesToShow: 1,
				arrows: true,
				rtl:true,
				responsive: [{
						breakpoint: 768,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});
		}else{
			$('.js-posts-slider').slick({
				centerMode: true,
				centerPadding: '28%',
				slidesToShow: 1,
				arrows: true,
				responsive: [{
						breakpoint: 768,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							dots: true,
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});
		}

	});
</script>

<?php } else {
	?>
	<div class="post box box--white">
	<?php
	$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
	?>
	</div>
	<?php
} ?>
