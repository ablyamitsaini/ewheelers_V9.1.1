<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="box box--white box--space">
   <h5><?php echo Labels::getLabel('Lbl_Search',$siteLangId); ?></h5>
   <div class="search search--sort">
		<?php echo $blogSrchFrm->getFormTag(); ?>
		<div class="search__field">
			<?php echo 
			$blogSrchFrm->getFieldHTML('keyword') , 
			$blogSrchFrm->getFieldHTML('btn_submit');
			?>
			<i class="fa fa-search"></i>
		</div>
		</form> <?php echo $blogSrchFrm->getExternalJS(); ?>
	</div>
	<span class="gap"></span>
	<a href="<?php echo CommonHelper::generateUrl('Blog','contributionForm'); ?>" class="btn btn--secondary btn--block ripplelink "><?php echo Labels::getLabel('Lbl_Contribute',$siteLangId); ?></a>
	<?php if(!empty($categoriesArr)){ ?>
	<span class="gap"></span>
	<h5 class="toggle--nav-vertical toggle-nav--vertical-js"><?php echo Labels::getLabel('Lbl_Categories',$siteLangId); ?></h5>
	<ul class="nav--vertical nav--vertical-js">
	<?php foreach($categoriesArr as $cat){ ?>
	<li class="">
		<a href="<?php echo CommonHelper::generateUrl('Blog','category', array($cat['bpcategory_id'])); ?>"><?php echo $cat['bpcategory_name']; echo !empty($cat['countChildBlogPosts'])?"($cat[countChildBlogPosts])":''; ?></a>
		<?php if( count($cat['children']) ){ ?>
		<ul>
			<?php foreach($cat['children'] as $children){ ?>
			<li class="">
				<a href="<?php echo CommonHelper::generateUrl('Blog','category',array($children['bpcategory_id'])); ?>"><?php echo $children['bpcategory_name']; echo !empty($children['countChildBlogPosts'])?"($children[countChildBlogPosts])":''; ?></a>
				<?php if(count($children['children'])){ ?>
				<ul class="">
				<?php foreach($children['children'] as $subChildren){ ?>
				<li class="">
					<a href="<?php echo CommonHelper::generateUrl('Blog','category',array($subChildren['bpcategory_id'])); ?>"><?php echo $subChildren['bpcategory_name']; ?></a>
				</li>
				<?php } ?>
				</ul>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</li>
	<?php } ?>
   </ul>
	<?php } ?>
</div>
<script>
(function(){
	var uri = window.location.pathname;
	var parentCat = null;
	$('ul.nav--vertical-js li').each(function(){
		if($(this).find('ul').length){
			parentCat = $(this);
			$(this).find('ul li').each(function(){
				if($(this).find('a').attr('href') == uri){
					$(this).addClass('is-active');
					$(parentCat).addClass('is-active');
				}
			});
		} else {
			if($(this).find('a').attr('href') == uri){
				$(this).addClass('is-active');
			}
		}
	});
})();
</script>