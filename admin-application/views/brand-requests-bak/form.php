<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmBrandReq->setFormTagAttribute('class', 'web_form form_horizontal');
$frmBrandReq->setFormTagAttribute('onsubmit', 'setupBrandReq(this); return(false);');
?>
<div class="col-sm-12">
	<h1><?php echo Labels::getLabel('LBL_Brand_Request_Setup',$adminLangId); ?></h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a class="active" href="javascript:void(0)" onclick="addBrandReqForm(<?php echo $brandReqId ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php 
			$inactive=($brandReqId==0)?'fat-inactive':'';	
			foreach($languages as $langId=>$langName){?>
				<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($brandReqId>0){?> onclick="addBrandReqLangForm(<?php echo $brandReqId ?>, <?php echo $langId;?>);" <?php }?>><?php echo $langName;?></a></li>
			<?php } ?>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $frmBrandReq->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>
