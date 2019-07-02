<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="container">

	<div class="message message--success align--center">
		<i class="fa fa-times"></i>
		<h2><?php echo Labels::getLabel('LBL_Payment_Failed',$siteLangId);?></h2>
		<h6><?php echo CommonHelper::renderHtml($textMessage);?></h6>
		<span class="gap"></span>
	</div>

</div>