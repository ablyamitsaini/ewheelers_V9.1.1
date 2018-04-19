<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$shopMediaFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$shopMediaFrm->developerTags['colClassPrefix'] = 'col-md-';
$shopMediaFrm->developerTags['fld_default_col'] = 6;

$shopLogoHeadingFld = $shopMediaFrm->getField('shop_logo_heading');	
$shopLogoHeadingFld->developerTags['col'] = 12;
$shopLogoHeadingFld->value = '<h2>'. Labels::getLabel('LBL_Shop_Logo_Management', $adminLangId) .'</h2>';

$shopBannerHeadingFld = $shopMediaFrm->getField('shop_banner_heading');	
$shopBannerHeadingFld->developerTags['col'] = 12;
$shopBannerHeadingFld->value = '<br/><br/><h2>'. Labels::getLabel('LBL_Shop_Banner_Management', $adminLangId) .'</h2>';
	
	foreach( $languages as $lang_id => $lang_name ){
	
		/* Shop Logo fld [ */
			$shopLogoFld = $shopMediaFrm->getField('shop_logo_'.$lang_id);	
			$shopLogoFld->developerTags['col'] = 4;
			$shopLogoFld->addFieldTagAttribute('class','btn btn--primary btn--sm');
			$shopLogoFld->htmlAfterField = ' <br/><small class="text--small">'. sprintf(Labels::getLabel('MSG_Upload_shop_logo_text',$adminLangId),'60*60'). '</small>';
		
		$shop_logo_display_div = $shopMediaFrm->getField('shop_logo_display_div_'.$lang_id);
		$shop_logo_display_div->value = '<div class="uploaded--image"><img src="'.CommonHelper::generateUrl('Image','shopLogo',array($shop_id,$lang_id,'THUMB?'.time()),CONF_WEBROOT_FRONT_URL).'"></div><br/>';
		
		if( AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_LOGO, $shop_id, 0, $lang_id ) && $canEdit ){
			$shop_logo_display_div->htmlAfterField = '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeShopLogo('.$shop_id.', '. $lang_id .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
		}
		/* ] */
		
		/* Shop Banner fld[ */
		$shopBannerFld = $shopMediaFrm->getField('shop_banner_'.$lang_id);	
		$shopBannerFld->developerTags['col'] = 4;
		$shopBannerFld->addFieldTagAttribute('class','btn btn--primary btn--sm');
		$shopBannerFld->htmlAfterField = ' <br/><small class="text--small">'. sprintf(Labels::getLabel('MSG_Upload_shop_banner_text',$adminLangId),'1000*250'). '</small>';
		
		$shop_banner_display_div = $shopMediaFrm->getField('shop_banner_display_div_'.$lang_id);
		$shop_banner_display_div->value = '<div class=""><img src="'.CommonHelper::generateUrl('Image','shopBanner',array($shop_id,$lang_id,'PREVIEW?'.time()),CONF_WEBROOT_FRONT_URL).'"></div><br/>';
		
		if( AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shop_id, 0, $lang_id ) && $canEdit ){
			$shop_banner_display_div->htmlAfterField = '<a class = "btn btn--secondary btn--sm" href="javascript:void(0);" onClick="removeShopBanner('.$shop_id.', '. $lang_id .')">'.Labels::getLabel('LBL_Remove',$adminLangId).'</a>';
		}
		/* ] */
	}
?>
<div class="col-sm-12">
	<h1>Shop Media Setup</h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="addShopForm(<?php echo $shop_id ?>);">General</a></li>
			<?php 
			$inactive=($shop_id==0)?'fat-inactive':'';	
			foreach($languages as $langId=>$langName){?>
				<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($shop_id>0){?> onclick="addShopLangForm(<?php echo $shop_id ?>, <?php echo $langId;?>);" <?php }?>><?php echo $langName;?></a></li>
			<?php } ?>
			<li ><a class="active" href="javascript:void(0);" <?php if($shop_id>0){?> onclick="shopMediaForm(<?php echo $shop_id ?>);" <?php }?>>Media</a></li>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $shopMediaFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>
