<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">

    <div class="section section--pagebar">
      <div class="container container--fixed">
        <div class="row align-items-center  justify-content-between">
          <div class="col-md-8 col-sm-8">
                <h1><?php echo Labels::getLabel('LBL_Forgot_Password?',$siteLangId);?></h1>
           </div>
          <div class="col-md-auto col-sm-auto">

              <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'loginForm'); ?>" class="btn btn--secondary">
              <?php echo Labels::getLabel('LBL_Back_to_Login',$siteLangId);?></a>

          </div>
        </div>
      </div>
    </div>



	<section class="section">
		<div class="container">
            <div class="row justify-content-center">

                <div class="col-md-6 <?php echo (empty($pageData)) ? '' : '';?>">
                   <div class="bg-gray rounded p-4 p-5">
                    <div class="text-center">
                        <div class="section-head">
                            <div class="section__heading m-3">
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

<<<<<<< HEAD
                  <p class="text--dark"><?php echo Labels::getLabel('LBL_Back_to_login',$siteLangId);?>
                  <a href="<?php echo CommonHelper::generateUrl('GuestUser', 'loginForm'); ?>" class="link"><?php echo Labels::getLabel('LBL_Click_Here',$siteLangId);?></a></p>
                </div></div>
=======

                </div>
                </div>
                </div>
>>>>>>> d549f04152ef715122eb54cc26ad7daf9f3d6813
                <?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData,false ); } ?>
			</div>
			</div>
		</div>
	</section>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
