<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="right-panel white--bg">
	<?php
		$keywordFld = $frmProductSearch->getField('keyword');
		$keywordFld->overrideFldType("hidden");
		echo $frmProductSearch->getFormTag();
	?>
	<div id="top-filters" class="hide_on_no_product">
		<div class="right_panel_head">
			<div class="row">
			  <div class="col-md-5 col-xs-12 col-sm-12 hide">
				<div class="heading2">
					<?php echo $blockTitle; ?>
					<?php if( !empty($brandData) ){  ?>
					<a href="<?php echo CommonHelper::generateUrl('brands', 'view', array($brandData['brand_id']) ); ?>"><?php echo $brandData['brand_name'] ?> </a>
					<?php } ?>
					<span class="subheading"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record" ></span>-<span id="end_record"></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"></span></span>
				</div>
			  </div>

			  <div class="col-md-7 col-xs-12 col-sm-12">

				<div class="right_panel_head_right">
					<a href="javascript:void(0)" class="btn btn--primary btn--sm link__filter hide--desktop"><?php echo Labels::getLabel('LBL_Filter', $siteLangId); ?></a>
					<a href="javascript:void(0)" class="btn btn--primary btn--sm switch--grind switch--link-js grid hide--mobile"><?php echo Labels::getLabel('LBL_Grid_View', $siteLangId); ?></a>
					<a href="javascript:void(0)" class="btn btn--secondary btn--sm switch--list switch--link-js list hide--mobile"><?php echo Labels::getLabel('LBL_List_View', $siteLangId); ?></a>
					<div class="gap"></div>
					<div class="sort-by">
						<ul>
						  <li class="sort"><?php echo Labels::getLabel('LBL_Sort_By', $siteLangId); ?> </li>
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
				</div>

			  </div>
			</div>
		</div>
		<?php
			echo $frmProductSearch->getFieldHtml('sortOrder');
			echo $frmProductSearch->getFieldHtml('shop_id');
			echo $frmProductSearch->getFieldHtml('collection_id');
			echo $frmProductSearch->getFieldHtml('join_price');
			echo $frmProductSearch->getFieldHtml('featured');
			echo $frmProductSearch->getFieldHtml('currency_id');
			echo $frmProductSearch->getExternalJS();
		?>
		</form>
		<div class="divider"></div>
		<div class="gap"></div>
	</div>
	<div class="listing-products listing-products--grid ">
		<div class="section section--items listview">
			<div id="productsList" class="row"></div>
		</div>
	</div>
	<div class="gap"></div>
</div>
<?php /*?>
<div id="loadMoreBtnDiv"></div>
<?php */?>