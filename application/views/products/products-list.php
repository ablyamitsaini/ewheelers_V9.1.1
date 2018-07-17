<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
if($products){
	// commonHelper::printArray($products); die;
	foreach($products as $product){
	$productUrl = CommonHelper::generateUrl('Products','View',array($product['selprod_id']));
	/* $brandLogoUrl = CommonHelper::generateUrl('Image','brand',array($product['brand_id'], $siteLangId, 'minithumb')); */
	?>

<div class="col-md-<?php echo (isset($colMdVal) && $colMdVal > 0)?$colMdVal:4;?> col-xs-6 col-sm-6">
  <div class="item-yk item <?php echo (!$product['in_stock']) ? 'item--sold' : '';?>"> <span class="overlay--collection"></span>
    <?php include(CONF_THEME_PATH.'_partial/product-listing-head-section.php');?>
    <div class="item-yk_body">
      <?php if(!$product['in_stock']){ ?>
      <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?></span>
      <?php  } ?>
      <div class="product-img"><a title="<?php echo $product['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('Products','View',array($product['selprod_id']));?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($product['product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $product['selprod_title'];?>"> </a></div>
      <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
    </div>
    <div class="item-yk_footer">
      <?php include(CONF_THEME_PATH.'_partial/collection-product-price.php');?>
    </div>
  </div>
</div>
<?php  }

	$searchFunction ='goToProductListingSearchPage';
	if(isset($pagingFunc)){
		$searchFunction =  $pagingFunc;
	}

	$postedData['page'] = (isset($page)) ? $page:1;
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmProductSearchPaging','id' => 'frmProductSearchPaging') );
	$pagingArr = array('pageCount'=>$pageCount,'page'=>$postedData['page'],'recordCount'=>$recordCount, 'callBackJsFunc' => $searchFunction);
	$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
} else {
	echo Labels::getLabel('LBL_No_record_found!', $siteLangId);
}
