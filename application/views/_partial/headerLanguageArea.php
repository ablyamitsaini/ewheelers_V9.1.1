<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

	<?php
	$showDefalultLi = true;
	if($languages && count($languages) > 1){
		$showDefalultLi = false;
	?>
	<li class="dropdown dropdown--arrow">
		<a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js">

		<?php if($languages[$siteLangId]['language_flag']){?>

			<i class="icn-language"><img class="icon--img" alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId);?>" src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo $languages[$siteLangId]['language_flag']; ?>">	</i>
		<?php }else{ echo'<i class="fa fa-language"></i>'; } ?>
		 <span><?php echo $languages[$siteLangId]['language_name']; ?></span> </a>
		<div class="dropdown__target dropdown__target-lang dropdown__target-js">
			<div class="box box--white">
				<h4 class="align--center hide--desktop"><?php echo Labels::getLabel('LBL_Select_Language',$siteLangId);?></h4>
				<ul class="list--vertical list--vertical-tabs">
					<?php foreach($languages as $langId => $language){ ?>
					<li <?php echo ($siteLangId==$langId)?'class="is-active"':'';?>><a href="javascript:void(0);" onClick="setSiteDefaultLang(<?php echo $langId;?>)"><?php if($language['language_flag']){ ?><img class="icon--img" alt="<?php echo Labels::getLabel('LBL_Language_Flag', $siteLangId);?>" src="<?php echo CONF_WEBROOT_URL; ?>images/flags/<?php echo $language['language_flag']; ?>"> <?php } ?> <?php echo $language['language_name']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</li>
	<?php } ?>
	<?php if($currencies && count($currencies) > 1){
		$showDefalultLi = false;
		?>
	<li class="dropdown dropdown--arrow">
		<a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js"><i class="icn-currency"><?php echo CommonHelper::getCurrencySymbol();?> </i><span> <?php echo Labels::getLabel('LBL_Currency', $siteLangId);?></span> </a>
		<div class="dropdown__target dropdown__target-lang dropdown__target-js">
			<div class="box box--white">
				<h4 class="align--center hide--desktop"><?php echo Labels::getLabel('LBL_Select_Currency',$siteLangId);?></h4>
				<ul class="list--vertical">
					<?php foreach($currencies as $currencyId => $currency){ ?>
					<li <?php echo ($siteCurrencyId == $currencyId)?'class="is-active"':'';?>><a href="javascript:void(0);" onClick="setSiteDefaultCurrency(<?php echo $currencyId;?>)"> <?php echo $currency; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</li>
	<?php }

		if($showDefalultLi){
			?>
			<li class="dropdown dropdown--arrow">
		<a href="javascript:void(0)" class="dropdown__trigger dropdown__trigger-js">

		<i class="icn-language"><img class="icon--img">	</i>
		<span></span> </a>

		</li>
			<?php
		}	?>
