<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="container container--fixed">
   <div class="container container--fluid">
	   <div class="panel panel--centered">
		   <div class="box box--white">
			   <div class="message message--success align--center">
				   <i class="fa fa-times"></i>
				   <h2><?php echo Labels::getLabel('LBL_Payment_Failed',$siteLangId);?></h2>
				   <h6><?php echo CommonHelper::renderHtml($textMessage);?></h6>
				   <span class="gap"></span>
			   </div>
		   </div>
	   </div>
	</div>
</div>