<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
	echo $frmProductSearch->getFormTag();
?>

<div class="row justify-content-between align-items-center">
	<div class="col-md-4 mb-2 mb-md-0">
		<div class="total-products">
        <span class="hide_on_no_product"><span id="total_records"><?php echo $recordCount;?></span> <?php echo Labels::getLabel('LBL_ITEMS_TOTAL', $siteLangId); ?></span>
		</div>
	</div>
    <div class="col-md-8">
        <div id="top-filters" class="page-sort hide_on_no_product">
            <ul>
                <li><div class="save-search">
                    <a href="javascript:void(0)" onclick="saveProductSearch()" class="btn btn--border"><i class="icn">
                        <svg class="svg">
                            <use xlink:href="/images/retina/sprite.svg#savesearch" href="/images/retina/sprite.svg#savesearch"></use>
                        </svg>
                    </i><span class="txt"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></span></a></div>
                </li>
                <li>
                <?php echo $frmProductSearch->getFieldHtml('sortBy'); ?></li>
                <li>
                <?php echo $frmProductSearch->getFieldHtml('pageSize'); ?></li>
                <li>
                    <div class="list-grid-toggle switch--link-js  d-none d-md-block">
                        <div class="icon">
                            <div class="icon-bar"></div>
                            <div class="icon-bar"></div>
                            <div class="icon-bar"></div>
                        </div>
                    </div>
                    <div class="d-xl-none">
                        <a href="javascript:void(0)" class="link__filter btn btn--border"><i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#filter"></use>
                            </svg>
                        </i><span class="txt"><?php echo Labels::getLabel('LBL_Filter', $siteLangId); ?></span></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
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
		<div>

		</div>

	<?php
		echo $frmProductSearch->getFieldHTML('keyword');
		echo $frmProductSearch->getFieldHtml('category');
		echo $frmProductSearch->getFieldHtml('sortOrder');
        echo $frmProductSearch->getFieldHtml('page');
        echo $frmProductSearch->getFieldHtml('shop_id');
        echo $frmProductSearch->getFieldHtml('collection_id');
        echo $frmProductSearch->getFieldHtml('join_price');
        echo $frmProductSearch->getFieldHtml('featured');
        echo $frmProductSearch->getFieldHtml('currency_id');
        echo $frmProductSearch->getFieldHtml('brand_id');
        echo $frmProductSearch->getFieldHtml('top_products');
        echo $frmProductSearch->getExternalJS();
	?>
	</form>
<script>
/* $(document).ready(function(){
	if($('input[name="keyword"]').val() == ''){
		$(".sortby option[value='keyword_relevancy_desc']").each(function() {
			$(".sortby option[value='keyword_relevancy_desc']").remove();
		});
	}
}); */
</script>
