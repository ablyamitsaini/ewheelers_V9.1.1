<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
                <?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>                                 
				<div class="col-md-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head no-print">
						   <h2><?php echo Labels::getLabel('LBL_View_Subscription_Order',$siteLangId);?></h2>                     
						</div>
						<div class="panel__body">                            
                            <div class="box box--white box--space">
                               <div class="box__head no-print" >
                                   <h4><?php echo Labels::getLabel('LBL_Order_Details',$siteLangId);?></h4>
                                   <div class="group--btns">
									   <?php /* <a href="javascript:window.print();" class="btn btn--secondary btn--sm no-print"><?php echo Labels::getLabel('LBL_Print',$siteLangId);?></a>  */?>
									   <a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Back_to_Subscription',$siteLangId);?></a>                                 	
                                   </div>
                               </div>
                                <div class="box__body">                                    
                                    <div class="grids--offset">
                                         <div class="grid-layout">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                     <p><strong><?php echo Labels::getLabel('LBL_Customer_Name',$siteLangId);?>: </strong><?php echo $orderDetail['user_name'];?></p>
                                                     <p><strong><?php echo Labels::getLabel('LBL_Status',$siteLangId);?>: </strong><?php if($orderDetail['ossubs_status_id']==FatApp::getConfig('CONF_DEFAULT_SUBSCRIPTION_PAID_ORDER_STATUS') && $orderDetail['ossubs_till_date']<date("Y-m-d") ){
													 echo Labels::getLabel('LBL_Expired',$siteLangId);}else{
														  echo $orderStatuses[$orderDetail['ossubs_status_id']];
													 }
														?></p>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                     <div class="info--order">
                                                         <p><strong><?php echo Labels::getLabel('LBL_Invoice',$siteLangId);?> #: </strong><?php echo $orderDetail['ossubs_invoice_number'];?></p>
                                                         <p><strong><?php echo Labels::getLabel('LBL_Date',$siteLangId);?>: </strong><?php echo FatDate::format($orderDetail['order_date_added']);?></p>
                                                         <span class="gap"></span>
                                                          
                                                     </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="section--repeated">
                                        <table class="table align--left">
                                            <tbody>
												<tr class="">
													<th><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></th>
													<th><?php echo Labels::getLabel('LBL_Subscription_Name',$siteLangId);?></th>
													<th><?php echo Labels::getLabel('LBL_Subscription_Period',$siteLangId);?></th>
													<th><?php echo Labels::getLabel('LBL_Subscription_Amount',$siteLangId);?></th>
													<th><?php echo Labels::getLabel('LBL_Product_Upload_Limit',$siteLangId);?></th>
												</tr>
												<tr>
													<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></span><?php echo FatDate::format($orderDetail['order_date_added'],true);?></td>
													<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Subscription_Name',$siteLangId);?></span><?php echo OrderSubscription::getSubscriptionTitle($orderDetail,$siteLangId);?></td>
													<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Subscription_Period',$siteLangId);?></span>
													<?php if($orderDetail['ossubs_from_date']==0 || $orderDetail['ossubs_till_date']==0) echo Labels::getLabel("LBL_NA",$siteLangId); else echo FatDate::format($orderDetail['ossubs_from_date'])." - " .FatDate::format($orderDetail['ossubs_till_date']); ?>
													</td> 
													<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Subscription_Amount',$siteLangId);?></span><?php echo CommonHelper::displayMoneyFormat($orderDetail['ossubs_price']);?></td> 
													<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Product_Upload_Limit',$siteLangId);?></span><?php echo $orderDetail['ossubs_products_allowed'];?></td>
												</tr>
											</tbody>
										</table>
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