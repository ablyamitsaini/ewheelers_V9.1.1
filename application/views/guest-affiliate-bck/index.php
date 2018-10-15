<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="after-header"></div>
<div id="body" class="body">
	<div  class="banner" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/seller-bg.jpg);">
		<div class="container">
			<div class="row">
			 <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
					<div class="seller-slogan">
						<div class="seller-slogan-txt">
						<?php echo FatUtility::decodeHtmlEntities( nl2br($bannerSlogan['epage_content']) );?> 
						</div>
					</div>
				</div>
				 <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
					<div class="seller-register-form">
						<div class="heading3"><?php echo Labels::getLabel('LBL_Affiliate_Registeration', $siteLangId); ?></div>
						<div id="register-form-div"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</div>
<script type="text/javascript">
	$("document").ready(function(){
		callAffilitiateRegisterStep(<?php echo $affiliate_register_step_number; ?>);
	});
</script>