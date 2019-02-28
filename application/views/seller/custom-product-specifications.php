<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>
<?php require_once(CONF_THEME_PATH.'_partial/seller/customProductNavigationLinks.php'); ?>
<div class="box__body">
  <div class="tabs tabs--small tabs--scroll clearfix">
    <?php require_once('sellerCustomProductTop.php');?>
  </div>
  <div class="row">
    <div class="col-xs-12 panel__right--full">
      <div class="cols--group">
        <div class="box__head panel__head">
          <h5><?php echo Labels::getLabel('LBL_Product_Specifications',$siteLangId); ?></h5>
          <div class="btn-group">
			<?php if(is_array($prodSpec) && !empty($prodSpec)) { ?>
			  <a onclick="addProdSpec(<?php echo $product_id;?>)" href="javascript:void(0)"  class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Add_Specification', $siteLangId);?></a>
			<?php }?>
			  <a href="<?php echo CommonHelper::generateUrl('Seller', 'sellerProductForm', array($product_id) )?>"  class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Add_to_Store', $siteLangId);?></a>
		  </div>
        </div>
        <div class="panel__body" id="product_specifications_list"> </div>
      </div>
    </div>
  </div>
</div>
