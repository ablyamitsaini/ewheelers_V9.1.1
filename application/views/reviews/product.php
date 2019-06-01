<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body bg--gray">
  <div class="section section--pagebar">
    <div class="container container--fixed">
      <div class="row">
        <div class="col-md-8">
          <div class="cell">
            <div class="cell__left">
              <div class="avtar"><img alt="<?php echo $product['product_name']; ?>" src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product',array($product['product_id'],'SMALL',$product['selprod_id'],0,$siteLangId)), CONF_IMG_CACHE_TIME, '.jpg'); ?>"></div>
            </div>
            <div class="cell__right">
              <div class="avtar__info">
                <?php if($product['selprod_title']){ ?>
                <h5><?php echo $product['selprod_title']; ?> </h5>
                <p><?php echo $product['product_name']; ?></p>
                <?php } else { ?>
                <h5><?php echo $product['product_name']; ?> </h5>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 align--right"><span class="gap"></span><a href="<?php echo CommonHelper::generateUrl('Products','view',array($product['selprod_id'])); ?>" class="btn btn--primary"><?php echo Labels::getLabel('Lbl_Back_to_Product',$siteLangId); ?></a></div>
      </div>
    </div>
  </div>
  <section class="section section--gray">
    <div class="container">
		<div id="itemRatings">
			<div class="section__head">
			 <h4><?php echo Labels::getLabel('Lbl_Reviews_of',$siteLangId).' '. (($product['selprod_title']) ? $product['selprod_title'] .' - '.$product['product_name'] : $product['product_name']);?></h4>
			 <?php echo $frmReviewSearch->getFormHtml(); ?>
			</div>
			<div class="section__body">
			  <?php $this->includeTemplate('_partial/product-reviews-list.php',array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'product_id'=>$product['product_id']),false); ?>
			</div>
		</div>
    </div>
  </section>
  <div class="gap"></div>
</div>
