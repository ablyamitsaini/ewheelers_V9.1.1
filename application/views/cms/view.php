<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	<?php if($cPage['cpage_layout']==Contentpage::CONTENT_PAGE_LAYOUT1_TYPE) { ?>
	<div class="page-banner" style="background-image:url(<?php echo CommonHelper::generateUrl('image','cpageBackgroundImage', array($cPage['cpage_id'], $siteLangId, '', 0, false),CONF_WEBROOT_URL); ?>);">
		<div class="fixed-container">
			<div class="banner-txt">
				<h1><?php echo $cPage['cpage_image_title']; ?></h1>
				<h4><?php echo $cPage['cpage_image_content']; ?></h4>
			</div>
		</div>
    </div> 
	<?php 
	if($blockData){ ?>
		<div class="container--cms">
		<?php if(isset ($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1])  && $blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1]['cpblocklang_text']){?>
		  <section class="space">
			<div class="fixed-container">
			  <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1]['cpblocklang_text']);?>
			</div>
		  </section>
		<?php } if(isset ($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2])  && $blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2]['cpblocklang_text']){?>
		  <section class="space bg--gray">
			<div class="fixed-container">
			  <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2]['cpblocklang_text']);?>
			</div>
		  </section>
		<?php } if(isset ($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3])  && $blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3]['cpblocklang_text']){?>
		  <section class="space bg--second">
			<div class="fixed-container">
			  <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3]['cpblocklang_text']);?>
			</div>
		  </section>
		<?php }if(isset ($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4])  && $blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4]['cpblocklang_text']){?>
		  <section class="space">
			<div class="fixed-container">
			  <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4]['cpblocklang_text']);?>
			</div>
		  </section>
		<?php }if(isset ($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5])  &&  $blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5]['cpblocklang_text']){?>
		  <section class="space">
		   <div class="divider"></div>
			<div class="fixed-container">
				
			  <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5]['cpblocklang_text']);?>
			</div>
		  </section>
		<?php } ?>
    
     
      
    </div>
	<?php
	}
	//echo FatUtility::decodeHtmlEntities( $cPage['cpage_content'] ) ?>
	<?php } else { ?>
	<section class="top-space bg--white">
	  <div class="fixed-container">
		<?php if(!$isAppUser){?>
		<div class="breadcrumb">
		   <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
		</div>
		<?php }?>
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
	<?php } ?>
	<div class="gap"></div>
</div>