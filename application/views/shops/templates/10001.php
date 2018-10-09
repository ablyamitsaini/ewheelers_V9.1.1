<?php defined('SYSTEM_INIT') or die('Invalid Usage');?>
<?php $haveBannerImage = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '' , $siteLangId ); ?>
<div class="gap"></div>
<div class="gap"></div>
<div class="container">
  <div class="shop-header">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="white--bg">
          <div class="shop-logo"><img src="<?php echo CommonHelper::generateUrl('image','shopLogo',array($shop['shop_id'],$siteLangId,'SMALL')); ?>" alt="<?php echo $shop['shop_name']; ?>"></div>
          <div class="clear"></div>
          <div class="shop-nav">
            <?php
				$variables= array('template_id'=>$template_id, 'shop_id'=>$shop['shop_id'],'collectionData'=>$collectionData,'action'=>$action,'siteLangId'=>$siteLangId);
                $this->includeTemplate('shops/shop-layout-navigation.php',$variables,false);  ?>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <!--<div class="shop-banner"><img src="<?php /* echo CommonHelper::generateUrl('image','shopBanner',array($shop['shop_id'],$siteLangId,'wide')); ?>" alt="<?php echo Labels::getLabel('LBL_Shop_Banner', $siteLangId); */ ?>"></div>-->
		<?php if( $haveBannerImage ){ ?>
		  <div class="shops-sliders">
			<?php foreach($haveBannerImage as $banner){ ?>
			<div class="item"><img src="<?php echo CommonHelper::generateUrl('image','shopBanner',array($banner['afile_record_id'],$siteLangId,'TEMP2',$banner['afile_id'])); ?>" alt="<?php echo Labels::getLabel('LBL_Shop_Banner', $siteLangId); ?>"></div>
			<?php } ?>
		  </div>
		  <?php } ?>
      </div>
    </div>
  </div>
</div>
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
	$(document).ready(function(){
		$currentPageUrl = '<?php echo $canonicalUrl; ?>';
	});
</script>
