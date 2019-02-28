<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$frmOrderSrch->setFormTagAttribute('onSubmit','searchOrders(this); return false;');
$frmOrderSrch->setFormTagAttribute('class', 'form'); 

$keywordFld = $frmOrderSrch->getField('keyword');
$keywordFld->setWrapperAttribute('class','col-lg-4 col-sm-4 col-md-4 ');
$keywordFld->developerTags['col'] = 4;
/* $keywordFld->htmlAfterField = '<small class="text--small">'.Labels::getLabel('LBL_Buyer_account_orders_listing_search_form_keyword_help_txt', $siteLangId).'</small>'; */

/* $statusFld = $frmOrderSrch->getField('status');
$statusFld->setWrapperAttribute('class','col-sm-6');
$statusFld->developerTags['col'] = 4; */

$dateFromFld = $frmOrderSrch->getField('date_from');
$dateFromFld->setFieldTagAttribute('class','field--calender');
$dateFromFld->setWrapperAttribute('class','col-lg-2 col-sm-2 col-md-2 ');
$dateFromFld->developerTags['col'] = 2;

$dateToFld = $frmOrderSrch->getField('date_to');
$dateToFld->setFieldTagAttribute('class','field--calender');
$dateToFld->setWrapperAttribute('class','col-lg-2 col-sm-2 col-md-2 ');
$dateToFld->developerTags['col'] = 2;

/* $priceFromFld = $frmOrderSrch->getField('price_from');
$priceFromFld->setWrapperAttribute('class','col-sm-6');
$priceFromFld->developerTags['col'] = 2;

$priceToFld = $frmOrderSrch->getField('price_to');
$priceToFld->setWrapperAttribute('class','col-sm-6');
$priceToFld->developerTags['col'] = 2; */

$submitBtnFld = $frmOrderSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-lg-2 col-sm-2 col-md-2 ');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmOrderSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-lg-2 col-sm-2 col-md-2 ');
$cancelBtnFld->developerTags['col'] = 2;
?>

<div id="body" class="body bg--gray">
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="container">
      <div class="row">
        <?php //$this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
        <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
        <div class="col-xs-10 panel__right--full" >
          <div class="cols--group">
            <div class="panel__head">
              <h2><?php echo Labels::getLabel('LBL_My_Subscriptions', $siteLangId); ?></h2>
            </div>
            <div class="panel__body">
              <div class="box box--white box--space">
                <div class="box__head">
									<h4><?php echo Labels::getLabel('LBL_Search_Subscriptions', $siteLangId); ?></h4>
									<?php if($currentActivePlan) {
									if(strtotime(date("Y-m-d"))>=strtotime('-3 day',strtotime($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])) ){
										if($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::PAID_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])>0 ){
											$message = sprintf(Labels::getLabel('MSG_Your_Subscription_is_going_to_expire_in_%s_day(s),Please_maintain_your_wallet_to_continue_your_subscription,_Amount_required_%s',$siteLangId),FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date']),CommonHelper::displayMoneyFormat($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'price']));
										}else if($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::PAID_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])==0 ){
											$message = sprintf(Labels::getLabel('MSG_Your_Subscription_is_going_to_expire_today,_Please_maintain_your_wallet_to_continue_your_subscription,_Amount_required_%s',$siteLangId),CommonHelper::displayMoneyFormat($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'price']));
										}else if($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::PAID_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])<0 && $autoRenew ){
											$message = sprintf(Labels::getLabel('MSG_Your_Subscription_has_been_expired,Please_purchase_new_plan_or_maintain_your_wallet_to_continue_your_subscription,_Amount_required_%s',$siteLangId),CommonHelper::displayMoneyFormat($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'price']));
										}else if($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::PAID_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])<0  && !$autoRenew){
											$message = sprintf(Labels::getLabel('MSG_Your_Subscription_has_been_expired,Please_purchase_new_plan_or_add_%s_in_your_wallet_before_renewing_your_subscription',$siteLangId),CommonHelper::displayMoneyFormat($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'price']));
										}elseif($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::FREE_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])>0 ){
											$message = sprintf(Labels::getLabel('MSG_Your_Free_Subscription_is_going_to_expire_in_%s_day(s),Please_Purchase_new_Subscription_to_continue_services',$siteLangId),FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date']));
										}elseif($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::FREE_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])==0 ){
											$message = sprintf(Labels::getLabel('MSG_Your_Free_Subscription_is_going_to_expire_today,_Please_Purchase_new_Subscription_to_continue_services',$siteLangId));
										}elseif($currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'type']==SellerPackages::FREE_TYPE && FatDate::diff(date("Y-m-d"),$currentActivePlan[OrderSubscription::DB_TBL_PREFIX.'till_date'])<0 ){
											$message = Labels::getLabel('MSG_Your_Free_Subscription_has_been_expired,Please_Purchase_new_Subscription_to_continue_services',$siteLangId);
										}
									?>


									<?php
						}
								}
							?>  <div class="auto-renew">
									<p><?php echo Labels::getLabel('LBL_AutoRenew_Subscription', $siteLangId); ?></p>
									<?php $autoRenewClass='';
							 $autoOffClass='is--active';
							 $autoOnClass='';

							 if($autoRenew){
								 $autoRenewClass ='is--active';
								$autoOffClass='';
								$autoOnClass='is--active';
							 }
							 $onOffArr = applicationConstants::getOnOffArr($siteLangId);
							 ?>
									<div class="switch-links"> <a href="javascript:void(0)" onclick="toggleAutoRenewal()" class="<?php echo $autoOffClass;?>"><?php echo $onOffArr[applicationConstants::OFF];?></a>
										<div class="switch-button auto-renew-js  <?php echo $autoRenewClass;?>"></div>
										<a  href="javascript:void(0)" onclick="toggleAutoRenewal()"  class="<?php echo $autoOnClass;?>" ><?php echo $onOffArr[applicationConstants::ON];?></a> </div>
								</div>

                </div>
                <?php if(isset($message)){ ?>
                  <p class="highlighted-note">
                    <?php  echo $message;?>
                  </p>
				<?php }?>
                <div class="box__body">
                  <div class="bg-gray-light p-3 pb-0"> <?php echo $frmOrderSrch->getFormHtml(); ?> </div>
                  <span class="gap"></span>
                  <div id="ordersListing"></div>
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
