<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
	echo $frmProductSearch->getFormTag();
?>
<div class="page-sort hide_on_no_product" id="top-filters">
	<ul>
		<li class="d-xl-none">
			<a href="javascript:void(0)" class="link__filter"><i class="icn">
				<svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter"></use>
				</svg>
			</i><span class="txt"><?php echo Labels::getLabel('LBL_Filter', $siteLangId); ?></span></a>
		</li>
		<?php if((UserAuthentication::isUserLogged() && (User::isBuyer())) || (!UserAuthentication::isUserLogged())) { ?>

		<?php }?>
		<?php /* <li class="is--active d-none d-xl-block">
			<a href="javascript:void(0)" class="switch--grind switch--link-js grid hide--mobile"><i class="icn">
				<svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#gridview" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#gridview"></use>
				</svg>
			</i><span class="txt"><?php echo Labels::getLabel('LBL_Grid_View', $siteLangId); ?></span></a>
		</li>
		<li class="d-none d-xl-block">
			<a href="javascript:void(0)" class="switch--list switch--link-js list hide--mobile"><i class="icn">
				<svg class="svg">
					<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#listview" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#listview"></use>
				</svg>
			</i><span class="txt"><?php echo Labels::getLabel('LBL_List_View', $siteLangId); ?></span></a>
		</li> */ ?>
		<li>
			<div class="sort-by">
				<ul>
					<?php if(!isset($doNotdisplaySortBy)){?>
				  <li class="sort"><?php echo Labels::getLabel('LBL_Sort_By', $siteLangId); ?> </li>
					<?php }?>
				  <li>
					<?php echo $frmProductSearch->getFieldHTML('keyword'); ?>
					<?php echo $frmProductSearch->getFieldHtml('sortBy'); ?>
					<?php echo $frmProductSearch->getFieldHtml('category'); ?>
				  </li>
				  <li class="hide--mobile">
					<?php echo $frmProductSearch->getFieldHtml('pageSize'); ?>
				  </li>
				</ul>
			</div>
		</li>
		<li>
			<a href="javascript:void(0)" onclick="saveProductSearch()" class="btn btn--default btn--sm"><i class="icn">

			</i><span class="txt"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></span></a>
		</li>
		<li>
			<div class="list-grid-toggle switch--link-js">
				<div class="icon icon-grid">
					<div class="icon-bar"></div>
					<div class="icon-bar"></div>
					<div class="icon-bar"></div>
				</div>
			</div>
		</li>
	</ul>
	<?php
		echo $frmProductSearch->getFieldHtml('sortOrder');
		echo $frmProductSearch->getFieldHtml('shop_id');
		echo $frmProductSearch->getFieldHtml('collection_id');
		echo $frmProductSearch->getFieldHtml('join_price');
		echo $frmProductSearch->getFieldHtml('featured');
		echo $frmProductSearch->getFieldHtml('currency_id');
		echo $frmProductSearch->getFieldHtml('top_products');
		echo $frmProductSearch->getExternalJS();
	?>
	</form>
</div>

<script>
/* $(document).ready(function(){
	if($('input[name="keyword"]').val() == ''){
		$(".sortby option[value='keyword_relevancy_desc']").each(function() {
			$(".sortby option[value='keyword_relevancy_desc']").remove();
		});
	}
}); */
</script>
