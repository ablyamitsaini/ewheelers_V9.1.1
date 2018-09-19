<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if(!empty($categoriesArr)){ ?>
<h3 class="widget__title "><?php echo Labels::getLabel('Lbl_categories',$siteLangId); ?></h3>
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

	<a href="<?php echo CommonHelper::generateUrl('Blog','contributionForm'); ?>" class="btn btn--secondary btn--block ripplelink "><?php echo Labels::getLabel('Lbl_Contribute',$siteLangId); ?></a>


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
