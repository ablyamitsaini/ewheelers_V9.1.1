<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="top-space body bg--gray">
		<div class="container">
		   <div class="panel panel--centered">
				<div class="box box--white box--tabled">
				   <div class="box__cell <?php echo (empty($pageData)) ? 'noborder--right noborder--left' : '';?>">
					   <h3><?php echo Labels::getLabel('LBL_Reset_Password',$siteLangId);?> </h3>
					   <p><?php echo Labels::getLabel('LBL_Reset_Password_Msg',$siteLangId);?></p>
						<?php
						$frm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
						$frm->setFormTagAttribute('class', 'form');
						$frm->setValidatorJsObjectName('resetValObj');
						$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
						$frm->developerTags['fld_default_col'] = 12;
						$frm->setFormTagAttribute('action', '');
						$frm->setFormTagAttribute('onSubmit', 'resetpwd(this, resetValObj); return(false);');
						echo $frm->getFormHtml();
						echo $frm->getExternalJs(); ?>
					</div>
					<?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData ,false); } ?>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
