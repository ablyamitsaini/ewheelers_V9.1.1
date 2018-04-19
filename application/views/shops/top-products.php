<?php defined('SYSTEM_INIT') or die('Invalid Usage');

	$searchFrm->setFormTagAttribute ( 'onSubmit', 'searchProducts(this); return(false);' );
	$keywordFld = $searchFrm->getField('keyword');
	$keywordFld->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search',$siteLangId));
	$keywordFld->htmlAfterField = '<input value="" type="submit" class="input-submit">';
	$bgUrl = CommonHelper::generateFullUrl('Image','shopBackgroundImage',array($shop['shop_id'],$siteLangId,0,0,$template_id)); 
 ?>
<div id="body" class="body bg--shop" <?php if($showBgImage){ echo 'style="background: url('.$bgUrl.') repeat 0 0;"'; } ?>>
	<div class="shop-bar">
      <div class="fixed-container">
        <div class="row">
          <div class="col-lg-7 col-md-7 col-sm-7  col-xs-12">
            <div class="shops-detail">
              <div class="shops-detail-name"> <?php echo $shop['shop_name']; ?></div>
			  <div class="item-yk_rating"><i class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
                <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
	C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
	l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
	l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
	l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"></path>
                </svg> </i> <span class="rate"> <?php echo round($shopRating,1),' ',Labels::getLabel('Lbl_Out_of',$siteLangId),' ', '5';  if($shopTotalReviews){ ?> - <a href="<?php echo CommonHelper::generateUrl('Reviews','shop',array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews , ' ' , Labels::getLabel('Lbl_Reviews',$siteLangId); ?></a><?php } ?> </span> </div>
              <div class=""> 
			  <a href="javascript:void(0)" class="btn btn--primary ripplelink active block-on-mobile " tabindex="0"><?php echo Labels::getLabel('LBL_Love', $siteLangId);  echo " ".$shop['shop_name']; ?> !</a> 
			  <a href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'])); ?>" class="btn btn--primary ripplelink block-on-mobile" tabindex="0"><?php echo Labels::getLabel('LBL_Send_Message', $siteLangId); ?></a> 
			  <a href="<?php echo CommonHelper::generateUrl('Shops','ReportSpam', array($shop['shop_id'])); ?>" class="btn btn--primary ripplelink block-on-mobile"><?php echo Labels::getLabel('LBL_Report_Spam',$siteLangId); ?></a>
			  </div>
            </div>
          </div>
        <div class="col-lg-5 col-md-5 col-sm-5  col-xs-12">
            <div class="shop-opened text-right"> <?php echo Labels::getLabel('LBL_Shop_Opened_By', $siteLangId); ?> <strong> <?php echo $shop['user_name'];?> </strong></div>
          </div>
        </div>
      </div>
    </div>

	<?php 
	$variables= array('shop'=>$shop, 'siteLangId'=>$siteLangId,'frmProductSearch'=>$frmProductSearch,'searchFrm'=>$searchFrm,'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action);
	if(!isset($template_id) || ($template_id<0)){
		$template_id=10001;
	}
	
	$this->includeTemplate('shops/templates/'.$template_id.'.php',$variables,false);

	?>
	
	
	<section class="top-space">
		<div class="fixed-container">
			<div class="gap"></div>
			<div class="row">
				<div class="col-lg-3">
					<div class="overlay overlay--filter"></div>
					<div class="filters">
						<div class="box box--white">
							<?php
							/* Left Side Filters Side Bar [ */
							if( $productFiltersArr ){
								$this->includeTemplate('_partial/productFilters.php',$productFiltersArr,false); 
							}
							/* ] */
							?>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col--right">
					<?php $blockTitle=Labels::getLabel('LBL_TOP_PRODUCTS', $siteLangId);?>				
					<?php $this->includeTemplate('_partial/productsSearchForm.php',array('frmProductSearch'=>$frmProductSearch,'blockTitle'=>$blockTitle,'siteLangId'=>$siteLangId),false);  ?>
				<!--	<div class="col-md-3 col--left col--left-adds">
						<?php if(!empty($pollQuest)){ ?>
						<span class="gap"></span>
						<div class="box-poll">
						   <?php $this->includeTemplate('_partial/poll-form.php'); ?>
						</div>
						<?php } ?>
						<div class="wrapper--adds">
							<div class="grids" id="allProductsBanners"></div>   
						</div>  
					</div>-->
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<script type="text/javascript">
	(function($){
	  searchProducts(document.frmProductSearch);
	})(jQuery);
	// $('.sort').css('display','none');
</script>
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>