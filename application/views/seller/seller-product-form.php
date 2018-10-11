<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
	var  product_id  =  <?php echo $product_id ;?>;
	var selprod_id  =  <?php echo $selprod_id ;?>;
</script>
<div id="body" class="body bg--gray">
  <section class="top-space">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="container">
      <div class="cols--group">
        <div class="panel__head ">
          <h2><?php echo Labels::getLabel('LBL_Inventory_Setup',$siteLangId); ?></h2>
          <div class="group--btns panel__head_action">
			  <a href="<?php echo CommonHelper::generateUrl('seller','products');?>" class="btn btn--primary btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Back_To_My_Inventory', $siteLangId)?></strong> </a>
			  <a href="<?php echo CommonHelper::generateUrl('seller','catalog');?>" class="btn btn--secondary btn--sm "><strong><?php echo Labels::getLabel( 'LBL_Back_To_Products', $siteLangId)?></strong> </a>
		  </div>
        </div>
        <div class="panel__body">
          <div class="box box--white box--space box--height">
            <div id="listing"> </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="gap"></div>
</div>
