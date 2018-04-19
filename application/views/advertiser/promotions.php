<div id="body" class="body bg--gray">  
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="fixed-container">
      <div class="row">
        <?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
        <div class="col-md-10 panel__right--full" >
          <div class="cols--group">
			<div class="panel__head">
				<h2><?php echo Labels::getLabel('LBL_Promotions',$siteLangId);?></h2><br />

				<p class="note"><?php echo Labels::getLabel('MSG_Minimum_balance_Required_For_Promotions',$siteLangId).' : '. CommonHelper::displaymoneyformat(FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE'));?>
				<?php /* if(!empty($record)) echo */ ?>
				</p>	
			   
				<div class="group--btns panel__head_action">
					<a href="javascript:void(0)" onClick="promotionForm()" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Add_Promotion',$siteLangId);?></a>
					<a href="javascript:void(0)" onClick="reloadList()" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_My_promotions',$siteLangId);?></a>
				</div>			 
			</div>
			<div class="panel__body">
				<div class="box box--white box--space">
					<div id="promotionForm">
						<div class="form__cover nopadding--bottom formshowhide-js">
							<?php 
								$frmSearchPromotions->setFormTagAttribute ( 'id', 'frmSearchPromotions' );
								$frmSearchPromotions->setFormTagAttribute ( 'class', 'form' );
								$frmSearchPromotions->setFormTagAttribute( 'onsubmit', 'searchPromotions(this); return(false);' );
								
								$frmSearchPromotions->developerTags['colClassPrefix'] = 'col-md-';
								$frmSearchPromotions->developerTags['fld_default_col'] = 4;
								
								$keywordFld = $frmSearchPromotions->getField('keyword');
								$keywordFld->setWrapperAttribute('class','col-sm-6');
								$keywordFld->developerTags['col'] = 8;
								
								$dateFromFld = $frmSearchPromotions->getField('date_from');
								$dateFromFld->setFieldTagAttribute('class','field--calender');
								$dateFromFld->setWrapperAttribute('class','col-sm-6');
								$dateFromFld->developerTags['col'] = 4;

								$dateToFld = $frmSearchPromotions->getField('date_to');
								$dateToFld->setFieldTagAttribute('class','field--calender');
								$dateToFld->setWrapperAttribute('class','col-sm-6');
								$dateToFld->developerTags['col'] = 4;
								
								echo $frmSearchPromotions->getFormHtml();
							?>
						</div>
						<div id="listing">								
							<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>							
						</div>	
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