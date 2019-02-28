<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
	<section class="section">
		<div class="container">
			<div class="row justify-content-center">
			   <div class="col-md-6 <?php echo (empty($pageData)) ? '' : '';?>">
					 <div class="box box--white box--space">
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
				</div>	</div>
				<?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData ,false); } ?>
			</div>
		</div>
	</section>
</div>
