<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>
<div class="cards">
	<?php require_once(CONF_THEME_PATH.'_partial/seller/customProductNavigationLinks.php'); ?>
	<div class="cards-content p-3">
		<div class="tabs tabs--small tabs--scroll clearfix">
			<?php require_once(CONF_THEME_PATH.'seller/sellerCustomProductTop.php');?>
		</div>
	</div>
	<div class="tabs__content">
		<div class="form__content">
			<div class="col-xs-12 panel__right--full">
				<div class="cols--group">
					<div class="cards-header p-3">
						<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Product_Specifications',$siteLangId); ?></h5>
						<div class="actions">
							<div class="btn-group">
							<?php if(is_array($prodSpec) && !empty($prodSpec)) { ?>
							  <a onclick="addProdSpec(<?php echo $product_id;?>)" href="javascript:void(0)"  class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Add_Specification', $siteLangId);?></a>
							<?php }?>
							  <a href="<?php echo CommonHelper::generateUrl('Seller', 'sellerProductForm', array($product_id) )?>"  class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Add_to_Store', $siteLangId);?></a>
							</div>
						</div>
					</div>
					<div class="cards-content p-3" id="product_specifications_list"> </div>
				</div>
			</div>
		</div>
	</div>
</div>
