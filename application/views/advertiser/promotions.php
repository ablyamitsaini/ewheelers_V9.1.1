<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Promotions',$siteLangId);?></h2>
		</div>
		<div class="content-header-right col-auto">
			<div class="btn-group">
				<a href="javascript:void(0)" onClick="promotionForm()" class="btn btn--sm"><?php echo Labels::getLabel('LBL_Add_Promotion',$siteLangId);?></a>
				<a href="javascript:void(0)" onClick="reloadList()" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_My_promotions',$siteLangId);?></a>
			</div>
		</div>
	</div>
	<div class="content-body">
		<div class="row">
			<div class="col-md-12">
				<div class="cards">
					<div class="cards-header p-3">
						<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Promotions',$siteLangId);?></h5>
						<p class="note"><?php echo Labels::getLabel('MSG_Minimum_balance_Required_For_Promotions',$siteLangId).' : '. CommonHelper::displaymoneyformat(FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE'));?>
					</div>
					<div class="cards-content p-3">
						<div id="promotionForm">
							<div class="bg-gray-light p-3 pb-0 formshowhide-js">
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
                                    
                                    $submitBtnFld = $frmSearchPromotions->getField('btn_submit');
                                    $submitBtnFld->setFieldTagAttribute('class','btn--block');
                                    $submitBtnFld->setWrapperAttribute('class','col-sm-6');
                                    $submitBtnFld->developerTags['col'] = 2;

                                    $cancelBtnFld = $frmSearchPromotions->getField('btn_clear');
                                    $cancelBtnFld->setFieldTagAttribute('class','btn--block');
                                    $cancelBtnFld->setWrapperAttribute('class','col-sm-6');
                                    $cancelBtnFld->developerTags['col'] = 2;
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
</main>
