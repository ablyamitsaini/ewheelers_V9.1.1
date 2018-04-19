<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
	<ul class="arrowTabs">
		<li class="<?php echo !empty($action) && $action=='export'?'is-active' : '';?>"><a href="javascript:void(0)" onClick="loadForm('export')"><?php echo Labels::getLabel('LBL_Export',$siteLangId); ?></a></li>
		<li class="<?php echo !empty($action) && $action=='import'?'is-active' : '';?>"><a href="javascript:void(0)" onClick="loadForm('import')"><?php echo Labels::getLabel('LBL_Import',$siteLangId); ?></a></li>
		<li class="<?php echo !empty($action) && $action=='settings'?'is-active' : '';?>"><a href="javascript:void(0)" onClick="loadForm('settings')"><?php echo Labels::getLabel('LBL_Settings',$siteLangId); ?></a></li>		
	</ul>
</div>