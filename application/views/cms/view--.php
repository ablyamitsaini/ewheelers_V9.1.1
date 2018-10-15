<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	
	<div class="page-banner" style="background-image:url(<?php echo CommonHelper::generateUrl('image','cpageBackgroundImage', array($cPage['cpage_id'], $siteLangId, '', 0, false),CONF_WEBROOT_URL); ?>);">
		<div class="container">
			<div class="banner-txt">
				<h1><?php echo $cPage['cpage_image_title']; ?></h1>
				<h4><?php echo $cPage['cpage_image_content']; ?></h4>
			</div>
		</div>
    </div> 
	
	
	<section class="top-space bg--white">
	  <div class="container">
		
		<div class="row">
		  <div class="col-lg-12">
			<div class="heading3"><?php echo $cPage['cpage_title']; ?></div>
		  </div>
		</div>
		<div class="container--cms">
			<?php echo FatUtility::decodeHtmlEntities( $cPage['cpage_content'] ) ?>
		</div>
	  </div>
	</section>
	
	<div class="gap"></div>
</div>