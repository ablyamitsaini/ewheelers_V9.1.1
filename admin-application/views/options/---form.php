<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOptions->setFormTagAttribute('class', 'web_form form_horizontal');
$frmOptions->setFormTagAttribute('onsubmit', 'setupOptions(this); return(false);');
?>
fcom
<div class="col-sm-12">
	<h1>Options Setup</h1>
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a class="active" href="javascript:void(0)" onclick="addOptionForm(<?php echo $option_id ?>);">General</a></li>
			<?php 
			$inactive=($option_id==0)?'fat-inactive':'';	
			foreach($languages as $langId=>$langName){?>
				<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($option_id>0){?> onclick="addOptionLangForm(<?php echo $option_id ?>, <?php echo $langId;?>);" <?php }?>><?php echo $langName;?></a></li>
			<?php }
			
			?>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $frmOptions->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>
