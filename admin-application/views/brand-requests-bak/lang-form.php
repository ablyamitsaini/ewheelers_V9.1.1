<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$brandReqLangFrm->setFormTagAttribute('class', 'web_form form_horizontal layout--'.$formLayout);
$brandReqLangFrm->setFormTagAttribute('onsubmit', 'setupBrandReqLang(this); return(false);');
?>
<div class="col-sm-12">
	<h1><?php echo Labels::getLabel('LBL_Brand_Request_Setup',$adminLangId); ?></h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0);" onclick="addBrandReqForm(<?php echo $brandReqId ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php 
			if ($brandReqId > 0) {
				foreach($languages as $langId=>$langName){?>
					<li><a class="<?php echo ($sbrandreq_lang_id==$langId)?'active':''?>" href="javascript:void(0);" onclick="addBrandReqLangForm(<?php echo $brandReqId ?>, <?php echo $langId;?>);"><?php echo $langName;?></a></li>
				<?php }
				}
			?>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $brandReqLangFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>	
</div>
