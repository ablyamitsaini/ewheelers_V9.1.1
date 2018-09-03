<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php if( FatApp::getConfig('CONF_ENABLE_NEWSLETTER_SUBSCRIPTION',FatUtility::VAR_INT,0) ){
		if( FatApp::getConfig('CONF_NEWSLETTER_SYSTEM') == applicationConstants::NEWS_LETTER_SYSTEM_MAILCHIMP ){
			$frm->setFormTagAttribute('class', 'sub-form');
			$frm->setFormTagAttribute( 'onSubmit', 'setUpNewsLetter(this); return false;' );
			$emailFld = $frm->getField('email');
			$emailFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Enter_Your_Email_Address', $siteLangId) );
			$emailFld->setFieldTagAttribute('class',"no--focus");
		?>
		
		
		 <?php echo $frm->getFormTag();?>
              
               	<?php 
					
					echo $frm->getFieldHtml('email');
					/* echo $frm->getFieldHtml('btnSubmit'); */
				?>
              </form>
			  <?php echo $frm->getExternalJS(); ?>
	
		<?php } else if( FatApp::getConfig('CONF_NEWSLETTER_SYSTEM') == applicationConstants::NEWS_LETTER_SYSTEM_AWEBER ) { ?>
		<?php FatApp::getConfig('CONF_AWEBER_SIGNUP_CODE'); ?>
		<?php } }else { ?>
		<div class="gap"></div>
		<?php } ?>
		
		<script type = "text/javascript" >
			(function() {
				setUpNewsLetter = function(frm) {
					if (!$(frm).validate()) return;
					var data = fcom.frmData(frm);
					fcom.updateWithAjax(fcom.makeUrl('MyApp', 'setUpNewsLetter'), data, function(t) {
						if(t.status){
							document.frmNewsLetter.reset();
						}
					});
				};
			})();
		</script>
