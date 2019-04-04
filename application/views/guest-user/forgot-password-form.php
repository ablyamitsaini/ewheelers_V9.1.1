<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="section">
		<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 <?php echo (empty($pageData)) ? '' : '';?>">
                    <div class="text-center">
                        <div class="section-head">
                            <div class="section__heading m-3"><h3><?php echo Labels::getLabel('LBL_Forgot_Password?',$siteLangId);?></h3>
                       <p><?php echo Labels::getLabel('LBL_Forgot_Password_Msg',$siteLangId);?></p></div></div>

                    <?php
                    $frm->setFormTagAttribute('class', 'form form--normal');
                    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                    $frm->developerTags['fld_default_col'] = 12;
                    $frm->setFormTagAttribute('id', 'frmPwdForgot');
                    $frm->setFormTagAttribute('autocomplete', 'off');
                    $frm->setValidatorJsObjectName('forgotValObj');
                    $frm->setFormTagAttribute('action', CommonHelper::generateUrl('GuestUser', 'forgotPassword'));
                    $btnFld = $frm->getField('btn_submit');
                    $btnFld->setFieldTagAttribute('class', 'btn--block');
                    $frmFld = $frm->getField('user_email_username');
                    $frmFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_EMAIL_ADDRESS',$siteLangId));
                    /* if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){
                        $captchaFld = $frm->getField('htmlNote');
                        $captchaFld->htmlBeforeField = '<div class="field-set">
                                       <div class="caption-wraper"><label class="field_label"></label></div>
                                       <div class="field-wraper">
                                           <div class="field_cover">';
                        $captchaFld->htmlAfterField = '</div></div></div>';
                    } */
                    /* echo $frm->getFormHtml(); */?>
                    
                    
                    <?php echo $frm->getFormTag();	?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-set">
                                    <div class="field-wraper">
                                        <div class="field_cover"><?php echo $frm->getFieldHtml('user_email_username'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){ ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="field-set">
                                    <div class="caption-wraper"><label class="field_label"></label></div>
                                    <div class="field-wraper">
                                        <div class="field_cover">
                                            <?php echo $frm->getFieldHtml('htmlNote'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-set">
                                    <div class="field-wraper">
                                        <div class="field_cover"><?php echo $frm->getFieldHtml('btn_submit'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php echo $frm->getExternalJS();?>
                   
                  <p class="text--dark"><?php echo Labels::getLabel('LBL_Back_to_login',$siteLangId);?>
                  <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'loginForm'); ?>" class="text text--uppercase"><?php echo Labels::getLabel('LBL_Click_Here',$siteLangId);?></a></p>
                </div></div>
                <?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData,false ); } ?>
			</div>
		</div>
	</section>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>