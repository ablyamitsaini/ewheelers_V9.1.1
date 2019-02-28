<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute( 'onSubmit', 'importFile("importData",'.$actionType.'); return false;' );
?>
 
	<div class="tabs tabs-sm tabs--scroll clearfix">
		<ul>
			<li class="is-active"><a class="is-active" href="javascript:void(0);" onclick="importForm('<?php echo $actionType;?>');"><?php echo Labels::getLabel('LBL_Content',$siteLangId); ?></a></li>
			<?php if($displayMediaTab){?>
			<li><a href="javascript:void(0);" onclick="importMediaForm('<?php echo $actionType;?>');"><?php echo Labels::getLabel('LBL_Media',$siteLangId); ?></a></li>
			<?php }?>
		</ul>
	</div>
 
<div class="form__subcontent">
	<?php echo $frm->getFormHtml(); ?>
</div>
