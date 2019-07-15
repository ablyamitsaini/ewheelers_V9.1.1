<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
<div class="container">
	<div class="message message--success align--center">
		<i class="fa fa-times"></i>
		<div class="section-head  section--head--center">
		 <div class="section__heading"><h2><?php echo Labels::getLabel('LBL_Payment_Failed',$siteLangId);?></h2></div>
		</div>
		<?php echo CommonHelper::renderHtml($textMessage);?>
		<span class="gap"></span>
	</div>

</div>
</section>