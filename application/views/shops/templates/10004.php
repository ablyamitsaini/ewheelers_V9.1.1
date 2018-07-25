<?php $haveBannerImage = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '' , $siteLangId ); ?>

<div class="shop-header shop--header04">
  <div class="fixed-container">
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-4  col-xs-12"> <a class="shop_navs_toggle" href="javascript:void(0)"><span></span></a>
        <div class="shop-logo"><img src="<?php echo CommonHelper::generateUrl('image','shopLogo',array($shop['shop_id'],$siteLangId,'EXTRA-SMALL')); ?>" alt="<?php echo $shop['shop_name']; ?>"></div>
      </div>
      <div class="col-lg-8 col-md-8 col-sm-4 col-xs-12">
        <div class="shop-nav">
          <?php $variables= array('template_id'=>$template_id,'shop_id'=>$shop['shop_id'],'collectionData'=>$collectionData,'action'=>$action,'siteLangId'=>$siteLangId);
				  $this->includeTemplate('shops/shop-layout-navigation.php',$variables,false);  ?>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
        <div class="product-search">
          <?php 
					echo $searchFrm->getFormTag();
					$fld=$searchFrm->getField('keyword');
					$fld->addFieldTagAttribute("class","input-field no--focus");
					echo $searchFrm->getFieldHTML('keyword');
					echo $searchFrm->getFieldHTML('shop_id');
					echo '</form>';
					echo $searchFrm->getExternalJS();
				   ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if( $haveBannerImage ){ ?>
<div class="shops-sliders">
  <?php foreach($haveBannerImage as $banner){ ?>
  <div class="item"><img src="<?php echo CommonHelper::generateUrl('image','shopBanner',array($banner['afile_record_id'],$siteLangId,'TEMP4',$banner['afile_id'])); ?>" alt="<?php echo Labels::getLabel('LBL_Shop_Banner', $siteLangId); ?>"></div>
  <?php } ?>
</div>
<?php } ?>
<script type="text/javascript">
	(function($){
		if(langLbl.layoutDirection == 'rtl'){
			$('.shops-sliders').slick({
				dots: false,
				arrows:true,
				autoplay:true,
				rtl:true,
				pauseOnHover:false,
			}); 
		}
		else
		{
			$('.shops-sliders').slick({
			dots: false,
			arrows:true,
			autoplay:true,
			pauseOnHover:false,
			}); 
		} 
	})(jQuery); 
$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Shops','view',array($shopId)); ?>';	
</script>