<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute( 'onSubmit', 'importFile("importData",'.$actionType.'); return false;' );
?>
<div class="container container--fluid">
	<div class="tabs--inline tabs--scroll clearfix">
		<ul>
			<li><a href="javascript:void(0);" onclick="getInstructions('<?php echo $actionType;?>');"><?php echo Labels::getLabel('LBL_Instructions',$siteLangId); ?></a></li>

			<li class="is-active"><a class="is-active" href="javascript:void(0);" onclick="importForm('<?php echo $actionType;?>');"><?php echo Labels::getLabel('LBL_Content',$siteLangId); ?></a></li>
			<?php if($displayMediaTab){?>
			<li><a href="javascript:void(0);" onclick="importMediaForm('<?php echo $actionType;?>');"><?php echo Labels::getLabel('LBL_Media',$siteLangId); ?></a></li>
			<?php }?>
		</ul>
	</div>
</div>
<div class="form__subcontent">
	<?php echo $frm->getFormHtml(); ?>
</div>
