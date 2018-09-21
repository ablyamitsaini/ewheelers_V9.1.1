<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="page-search">
	 <h3 class="widget__title -style-uppercase"><?php echo Labels::getLabel('Lbl_Search',$siteLangId); ?></h3>
	 <?php $blogSrchFrm->setFormTagAttribute ( 'onSubmit', 'submitBlogSearch(this); return(false);' ); 
	 $blogSrchFrm->addFormTagAttribute('class','form-main-search');
	 echo $blogSrchFrm->getFormTag(); 
	 $keywordFld = $blogSrchFrm->getField('keyword');
	 $keywordFld->addFieldTagAttribute('class','no-focus');
	 $keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('Lbl_Enter_The_Text_To_Search',$siteLangId));
	 echo $blogSrchFrm->getFieldHTML('keyword');
	 echo $blogSrchFrm->getFieldHTML('btn_submit'); ?>
	 </form> <?php echo $blogSrchFrm->getExternalJS(); ?>
 </div>
 
<div class="gap"></div>
<a href="<?php echo CommonHelper::generateUrl('Blog','contributionForm'); ?>" class="btn btn--primary btn--lg btn--block ripplelink btn--contribute">
	<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDUxMCA1MTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMCA1MTA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0iYWRkLWNpcmNsZSI+CgkJPHBhdGggZD0iTTI1NSwwQzExNC43NSwwLDAsMTE0Ljc1LDAsMjU1czExNC43NSwyNTUsMjU1LDI1NXMyNTUtMTE0Ljc1LDI1NS0yNTVTMzk1LjI1LDAsMjU1LDB6IE0zODIuNSwyODAuNWgtMTAydjEwMmgtNTF2LTEwMiAgICBoLTEwMnYtNTFoMTAydi0xMDJoNTF2MTAyaDEwMlYyODAuNXoiIGZpbGw9IiNGRkZGRkYiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
	<?php echo Labels::getLabel('Lbl_Contribute',$siteLangId); ?></a>
	<div class="gap"></div>
<?php if(!empty($categoriesArr)){ ?>
<h3 class="widget__title -style-uppercase"><?php echo Labels::getLabel('Lbl_categories',$siteLangId); ?></h3>
<div class="">
	<nav class="">
		<ul class="blog_lnks accordion">
			<?php foreach($categoriesArr as $cat){ ?>
			<li class="<?php echo (count($cat['children'])>0) ? "has-child" : "" ?>"><a href="<?php echo CommonHelper::generateUrl('Blog','category', array($cat['bpcategory_id'])); ?>"><?php echo $cat['bpcategory_name']; echo !empty($cat['countChildBlogPosts'])?" <span class='badge'>($cat[countChildBlogPosts])</span>":''; ?></a>
				<?php if( count($cat['children']) ){ ?>
				<span class="link--toggle link--toggle-js"></span>
				<ul style="display:none">
					<?php foreach($cat['children'] as $children){ ?>
						<li><a href="<?php echo CommonHelper::generateUrl('Blog','category',array($children['bpcategory_id'])); ?>"><?php echo $children['bpcategory_name']; echo !empty($children['countChildBlogPosts'])?" <span class='badge'>($children[countChildBlogPosts])</span>":''; ?></a>
						<?php if(count($children['children'])){ ?>
							<ul class="">
							<?php foreach($children['children'] as $subChildren){ ?>
								<li class="">
									<a href="<?php echo CommonHelper::generateUrl('Blog','category',array($subChildren['bpcategory_id'])); ?>"><?php echo $subChildren['bpcategory_name']; ?></a>
								</li>
							<?php } ?>
							</ul>
						<?php }?>
						</li>
					<?php }?>
				</ul>
				<?php }?>
			</li>
			<?php }?>
		</ul>
	</nav>
</div>
<?php }?>

<script>
        /* for blog links */
        $('.link--toggle-js').click(function(){
        if($(this).hasClass('is-active')){
            $(this).removeClass('is-active');
            $(this).next('.nav--toggled-js > ul > li ul').find('.link--toggle-js').removeClass('is-active');
            $(this).next('.nav--toggled-js > ul > li ul').slideUp();
            $(this).next('.nav--toggled-js > ul > li ul').find('.nav--toggled-js > ul > li ul').slideUp();
            return false;
        }
        $('.link--toggle-js').removeClass('is-active');
        $(this).addClass("is-active");
        $(this).parents('ul').each(function() {
            $(this).siblings('span').addClass('is-active');
        });
        $(this).closest('ul').find('li .nav--toggled-js > ul > li ul').slideUp();
        $(this).next('.nav--toggled-js > ul > li ul').slideDown();
        });
</script>
