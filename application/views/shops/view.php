<?php defined('SYSTEM_INIT') or die('Invalid Usage');
	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input name="btnSrchSubmit" value="" type="submit" class="input-submit">';
	$keywordFld = $frmProductSearch->getField('keyword');
	$keywordFld->overrideFldType("hidden");
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id));
 ?>
<div id="body" class="body bg--shop" <?php if($showBgImage){ echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; } ?> >
	<div class="shop-bar">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 col-md-8 col-sm-8  col-xs-12">
            <div class="shops-detail">
              <div class="shops-detail-name"> <?php echo $shop['shop_name']; ?></div>
			  <div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
                <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
	C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
	l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
	l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
	l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"></path>
                </svg> </i> <span class="rate"> <?php echo round($shopRating,1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5';  if($shopTotalReviews){ ?> - <a href="<?php echo CommonHelper::generateUrl('Reviews','shop',array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews , ' ' , Labels::getLabel('Lbl_Reviews',$siteLangId); ?></a><?php } ?> </span> </div>
              <div class="shop-actions">
				<ul>
				<li><a href="javascript:void(0)" onclick="toggleShopFavorite(<?php echo $shop['shop_id']; ?>);" class="<?php echo ($shop['is_favorite']) ? 'is-active' : ''; ?>" id="shop_<?php echo $shop['shop_id']; ?>" tabindex="0">
					<i class="icn"> <img src="images/retina/loveshop.svg"></i>
				 <?php echo Labels::getLabel('LBL_Love', $siteLangId);  echo " ".$shop['shop_name']; ?> !</a>
				</li>
				<li> <a href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'])); ?>" class="" tabindex="0"> <i class="icn"> <img src="images/retina/send-meg.svg"></i> <?php echo Labels::getLabel('LBL_Send_Message', $siteLangId); ?></a></li>

				<li> <a href="<?php echo CommonHelper::generateUrl('Shops','ReportSpam', array($shop['shop_id'])); ?>" class=""><i class="icn"> <img src="images/retina/spam.svg"></i> <?php echo Labels::getLabel('LBL_Report_Spam',$siteLangId); ?></a></li>
				</ul>
			  </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12">
            <div class="shop-opened text-right"> <?php echo Labels::getLabel('LBL_Shop_Opened_By', $siteLangId); ?> <strong> <?php echo $shop['user_name'];?> </strong></div>
          </div>
        </div>
      </div>
    </div>
	<?php
		$variables= array('shop'=>$shop, 'siteLangId'=>$siteLangId,'frmProductSearch'=>$frmProductSearch,'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action,'canonicalUrl'=>$canonicalUrl,'shopId'=>$shopId,'productFiltersArr'=>$productFiltersArr);
		$this->includeTemplate('shops/templates/'.$template_id.'.php',$variables,false);
	?>
	<section class="top-space">
		<div class="container">
			<div class="gap"></div>
			<div class="row">
				<?php if(!isset($noProductFound)) { ?>
				<div class="col-lg-3">
					<div class="overlay overlay--filter"></div>
					<div class="filters">
						<div class="">
							<?php
							/* Left Side Filters Side Bar [ */
							if( $productFiltersArr ){
								$productFiltersArr['searchFrm']=$searchFrm;
								$this->includeTemplate('_partial/productFilters.php',$productFiltersArr,false);
							}
							/* ] */
							?>
						</div>
					</div>
				</div>
				<?php }
				if(!isset($noProductFound)){
					$blockTitle=Labels::getLabel('LBL_SHOP_PRODUCTS', $siteLangId);
					$class ='col-xl-9';
				}else{
					$class= 'col-lg-12';
					$blockTitle = '';
				}
				?>
				<div class="<?php echo $class;?>">
				<?php if($shop['shop_description']){?>
					<div class="category__description container--cms"><?php echo CommonHelper::renderHtml($shop['shop_description']);?></div>
				<?php } ?>
					<?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'blockTitle'=>$blockTitle,'siteLangId'=>$siteLangId),false);  ?>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
<script type="text/javascript">
$(document).ready(function(){
	$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Shops','view',array($shopId)); ?>';
	$productSearchPageType = '<?php echo SavedSearchProduct::PAGE_SHOP; ?>';
	$recordId = <?php echo $shopId;?>;
	<?php if($productFiltersArr['priceInFilter']){?>
		updatePriceFilter(<?php echo floor($productFiltersArr['priceArr']['minPrice']);?>,<?php echo ceil($productFiltersArr['priceArr']['maxPrice']);?>);
	<?php }?>
});
</script>
