<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit','searchMessages(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form'); 
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSrch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class','col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-3');
$cancelBtnFld->developerTags['col'] = 2;
?>  
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>						   
				<div class="col-md-10 panel__right--full">
					<div class="cols--group">
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_My_Messages',$siteLangId);?></h2>						   
						</div>					   
						<div class="panel__body">                            
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
                                   <h4><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></h4>                                  
                                </div>
                                <div class="box__body">
									<div id="withdrawalReqForm"></div>
									<div class="form__cover nopadding--bottom">
                                        <?php echo $frmSrch->getFormHtml(); ?>
									</div>                                    
									<span class="gap"></span> 
									<div id="messageListing"><?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?></div>									                                 
                                </div>                                 
							</div>                             
						</div>  
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>