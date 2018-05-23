<div class="item-yk-head">
  <?php if(isset($selprod_condition) && $selprod_condition) { ?>
  <!--<div class="item-yk-head-lable"><?php /* echo Product::getConditionArr($siteLangId)[$product['selprod_condition']]; */?></div>-->
  <?php }?>
  <div class="item-yk-head-category"><a href="<?php echo CommonHelper::generateUrl('Category','View',array($product['prodcat_id']));?>"><?php echo $product['prodcat_name'];?> </a></div>
  <div class="item-yk-head-title"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><?php echo $product['selprod_title'];?> </a></div>
  <?php if(round($product['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?>
  <div class="item-yk_rating">
	  <?php if(round($product['prod_rating'])>0 ){ ?>
	  <span class="rate"><?php echo round($product['prod_rating'],1);?></span> <i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
	  <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
	C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
	l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
	l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
	l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"/>
	  </svg> </i>
	  <?php } ?>
		  <?php if(isset($firstToReview) && $firstToReview){ ?>
		  <?php if(round($product['prod_rating'])==0 ){  ?>
		  <span class="be-first"> <a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span>
		  <?php } ?>
	  <?php }?>
	</div>
  <?php } ?>
</div>