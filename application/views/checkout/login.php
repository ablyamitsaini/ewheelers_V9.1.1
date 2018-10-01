<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="login">
	<div class="row">
		<?php $this->includeTemplate('guest-user/checkoutLoginFormTemplate.php', $loginFormData,false ); ?>
	</div>
	<div class="gap"></div>
	<p><?php echo Labels::getLabel('LBL_sign_up_help_description', $siteLangId); ?></p>
</div>
