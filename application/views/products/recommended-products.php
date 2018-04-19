<?php if($recommendedProducts){ ?>

<div class="white--bg padding20">
  <div class="heading4 "><?php echo Labels::getLabel('LBL_Recommended_Products',$siteLangId); ?></div>
  <div class="border-bottom"></div>
  <div id="similar-product" class="more-slider carousel carousel--onethird slides--four-js">
    <?php foreach($recommendedProducts as $rProduct){
		$productUrl = CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id']));
		?>
    <div class="more_slider_item">
      <div class="item-yk">
        <div class="item-yk-head">
          <div class="item-yk-head-category"><a href="<?php echo CommonHelper::generateUrl('Category','View',array($rProduct['prodcat_id']));?>"><?php echo $rProduct['prodcat_name'];?> </a></div>
          <div class="item-yk-head-title"><a title="<?php echo $rProduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id']));?>"><?php echo $rProduct['selprod_title'];?> </a></div>
          <?php if(round($rProduct['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS")){ ?>
          <div class="item-yk_rating"><i class="svg"><svg   xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
            <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
						C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
						l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
						l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
						l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"/>
            </svg> </i><span class="rate"><?php echo round($rProduct['prod_rating'],1);?></span> </div>
          <?php } ?>
        </div>
        <div class="item-yk_body">
          <div class="product-img"><a title="<?php echo $rProduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($rProduct['selprod_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($rProduct['product_id'], "CLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $rProduct['selprod_title'];?>"> </a></div>
          <?php $this->includeTemplate('_partial/collection-ui.php',array('product'=>$rProduct,'siteLangId'=>$siteLangId),false);?>
        </div>
        <div class="item-yk_footer">
          <?php $this->includeTemplate('_partial/collection-product-price.php',array('product'=>$rProduct,'siteLangId'=>$siteLangId),false);?>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<div class="gap"></div>
<?php } ?>