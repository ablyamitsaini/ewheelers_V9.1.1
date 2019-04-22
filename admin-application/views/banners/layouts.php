<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>


<section class="section">
	<div class="sectionhead">

		<h4><?php echo Labels::getLabel('LBL_Banner_Layouts_Instructions',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
<div class="row">
	<div class="col-sm-12">
		<section class="section">
			<div class="sectionbody">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="shop-template">
							<a rel="facebox" onClick="displayImageInFacebox('<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_HOME_PAGE_LAYOUT_1),CONF_WEBROOT_FRONT_URL);?>');" href="javascript:void(0)">
								<figure class="thumb--square"><img width="400px;" style="height:100%" src="<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_HOME_PAGE_LAYOUT_1),CONF_WEBROOT_FRONT_URL);?>" /></figure>
								<p><?php echo Labels::getLabel('LBL_Layout_1',$adminLangId);?></p>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="shop-template">
							<a rel="facebox" onClick="displayImageInFacebox('<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_HOME_PAGE_LAYOUT_2),CONF_WEBROOT_FRONT_URL);?>');" href="javascript:void(0)">
								<figure class="thumb--square"><img width="400px;" style="height:100%" src="<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_HOME_PAGE_LAYOUT_2),CONF_WEBROOT_FRONT_URL);?>" /></figure>
								<p><?php echo Labels::getLabel('LBL_Layout_2',$adminLangId);?></p>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="shop-template">
							<a rel="facebox" onClick="displayImageInFacebox('<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_PRODUCT_PAGE_LAYOUT_1),CONF_WEBROOT_FRONT_URL);?>');" href="javascript:void(0)">
								<figure class="thumb--square"><img width="400px;"  style="height:100%" src="<?php echo CommonHelper::generateUrl('Image','bannerFrame',array(Banner::BANNER_PRODUCT_PAGE_LAYOUT_1),CONF_WEBROOT_FRONT_URL);?>" /></figure>
								<p><?php echo Labels::getLabel('LBL_Layout_3',$adminLangId);?></p>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
</div>
	</section>
