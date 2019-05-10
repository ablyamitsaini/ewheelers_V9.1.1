<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header row justify-content-between mb-3">
		<div class="col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></h2>
		</div>
		<div class="col-md-auto">
			<div class="btn-group">
				<?php if(!Shop::isShopActive(UserAuthentication::getLoggedUserId(),0,true)){ ?>
    				<a  href="<?php echo  CommonHelper::generateUrl('Seller','shop');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Create_Shop',$siteLangId); ?></a>
				<?php  } ?>

				<!-- <a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>" class="btn btn--sm"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></a> -->

                <a href="<?php echo CommonHelper::generateUrl('seller','customProductForm' );?>" class="btn btn--sm"><?php echo Labels::getLabel('LBL_Add_new_catalog',$siteLangId);?></a>
                <a href="<?php echo CommonHelper::generateUrl('seller','catalog' );?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_My_products',$siteLangId);?></a>

                <a href="<?php echo CommonHelper::generateUrl('seller','products' );?>" class="btn btn--sm"><?php echo Labels::getLabel('LBL_My_store_inventory',$siteLangId);?></a>

			</div>
		</div>
	</div>
	<div class="content-body">
		<div class="widget-wrapper mb-3">
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#my-sales" href="
    									<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#my-sales"></use>
    								</svg></i>
    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Total_sales',$siteLangId);?></h6>
    								<?php echo CommonHelper::displayMoneyFormat($totalSoldSales);?>
    							</div>
    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Sale_for_today',$siteLangId);?></h6>
    								<?php echo CommonHelper::displayMoneyFormat($todaySoldSales);?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('Account','credits'); ?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Credits',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#credits" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#Credits"></use>
    								</svg></i>

    							<div class="stats-number">
    								<h6 class="total">
                                        <?php echo Labels::getLabel('LBL_Total_Credits',$siteLangId);?>
                                    </h6>
    								<?php echo CommonHelper::displayMoneyFormat($userBalance);?>
    								<h6 class="total">
                                        <?php echo Labels::getLabel('LBL_Credits_earned_today',$siteLangId);?>
                                    </h6>
    								<?php echo CommonHelper::displayMoneyFormat($txnsSummary['total_earned']);?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Order',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#order" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#order"></use>
    								</svg></i>

    							<div class="stats-number">
                                    <h6 class="total"><?php echo Labels::getLabel('LBL_Total_Orders',$siteLangId);?></h6>
    								<?php echo $ordersCount;?>
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Orders_for_today',$siteLangId);?></h6>
    								<?php echo $todayOrderCount;?>
    							</div>
    						</div>
    					</div>
    				</div>
            </a>
			</div>
			<!-- <div class="widget widget-stats">
				<div class="cards">
					<div class="cards-header">
						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Sold',$siteLangId);?></h5>
					</div>
					<div class="cards-content p-3">
						<div class="stats">
							<i class="icn"><svg class="svg">
									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#sold" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#sold"></use>
								</svg></i>

							<div class="stats-number">
								<h6 class="total"><?php echo Labels::getLabel('LBL_Today_Sold',$siteLangId);?></h6>
								<?php echo $todaySoldCount;?>
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
								<?php echo $totalSoldCount;?>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<?php if( FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE') ){ ?>
    			<div class="widget widget-stats">
                    <a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions'); ?>">
        				<div class="cards">
        					<div class="cards-header">
        						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Active_Subscription',$siteLangId);?></h5>
        					</div>
        					<div class="cards-content p-3">
        						<div class="stats">
        							<i class="icn"><svg class="svg">
        									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#messages" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#messages"></use>
        								</svg></i>
        							<?php if($pendingDaysForCurrentPlan >= 0) {?>
        							<div class="stats-number">
        								<h6 class="total"><?php echo Labels::getLabel('LBL_Products',$siteLangId);?> & <strong><?php echo $pendingDaysForCurrentPlan; ?> <?php echo Labels::getLabel('LBL_Days',$siteLangId);?></strong> <?php echo Labels::getLabel('LBL_Remaining',$siteLangId);?></h6>
        								<?php echo ($remainingAllowedProducts > 0)? $remainingAllowedProducts:0 ; ?>
        							</div>
        							<?php } else {?>
        							<div class="stats-number">
        								<h6><?php echo $subscriptionName.' '; ?></h6>
        								<h6 class="total"><?php echo Labels::getLabel('LBL_Expires_On',$siteLangId).' '; ?></h6>
        								<?php echo (isset($subscriptionTillDate))? $subscriptionTillDate:''; ?>
        							</div>
        							<?php } ?>
        						</div>
        					</div>
        				</div>
                    </a>
    			</div>
			<?php } ?>
			<div class="widget widget-stats">
                <a href="<?php echo CommonHelper::generateUrl('Account','messages'); ?>">
    				<div class="cards">
    					<div class="cards-header">
    						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></h5>
    					</div>
    					<div class="cards-content p-3">
    						<div class="stats">
    							<i class="icn"><svg class="svg">
    									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#messages" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#messages"></use>
    								</svg></i>
    							<div class="stats-number">
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Unread_messages',$siteLangId);?></h6>
    								<?php echo $todayUnreadMessageCount;?>
    								<h6 class="total"><?php echo Labels::getLabel('LBL_Total_messages',$siteLangId);?></h6>
    								<?php echo $totalMessageCount;?>
    							</div>
    						</div>
    					</div>
    				</div>
                </a>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-6 col-md-12  ">
				<div class="cards">
					<div class="cards-header p-3">
						<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Sales_Graph',$siteLangId);?></h5>
					</div>
					<div class="cards-content p-3 graph">
						<?php $this->includeTemplate('_partial/seller/sellerSalesGraph.php'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12">
                <div class="cards">
                    <div class="cards-header p-3">
                        <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Latest_Orders',$siteLangId);?></h5>
                        <?php if( count( $orders ) > 0 ){ ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('seller','sales');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cards-content p-3">
                        <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                            <tbody>
                                 <tr class="">
                                    <th colspan="2" width="60%"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
                                    <th width="20%"><?php echo Labels::getLabel('LBL_Amount',$siteLangId);?></th>
                                    <th width="20%"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></th>
                                  </tr>
                                  <?php if( count( $orders ) > 0 ){
                                            foreach( $orders as $orderId => $row ){
                                                $orderDetailUrl = CommonHelper::generateUrl('seller', 'viewOrder', array($row['op_id']) );
                                                $prodOrBatchUrl = 'javascript:void(0)';
                                                if( $row['op_is_batch'] ){
                                                    $prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($row['op_selprod_id']));
                                                    $prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','BatchProduct', array($row['op_selprod_id'],$siteLangId, "SMALL"),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
                                               } else {
                                                    if(Product::verifyProductIsValid($row['op_selprod_id']) == true){
                                                        $prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($row['op_selprod_id']));
                                                    }
                                                    $prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($row['selprod_product_id'], "SMALL", $row['op_selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
                                               }
                                                /* $prodName = '';
                                               if($row['op_selprod_title']!=''){
                                                $prodName.= $row['op_selprod_title'].'<br/>';
                                               }
                                               $prodName.= $row['op_product_name']; */
                                        ?>
                                          <tr>
                                            <td>
                                                <figure class="item__pic"><a href="<?php echo $prodOrBatchUrl;?>"><img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $row['op_product_name'];?>" alt="<?php echo $row['op_product_name']; ?>"></a></figure>
                                            </td>
                                            <td><div class="item__description"> <div class="item__date"><?php echo FatDate::format($row['order_date_added']);?></div>
                                                <div class="item__title">
                                                <?php if($row['op_selprod_title'] != ''){ ?>
                                                <a title="<?php echo $row['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $row['op_selprod_title']; ?></a></div>

                                                <div class="item__sub_title"><?php echo $row['op_product_name']; ?>
                                                <?php } else { ?>
                                                <a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl; ?>"><?php echo $row['op_product_name']; ?>
                                                </a>
                                                <?php } ?>
                                                </div>

                                                <div class="item__brand"><?php echo Labels::getLabel('Lbl_Brand',$siteLangId)?>: <?php echo CommonHelper::displayNotApplicable($siteLangId,$row['op_brand_name']);?></div>
                                                <?php if( $row['op_selprod_options'] != '' ){ ?>
                          <div class="item__specification"><?php echo $row['op_selprod_options'];?></div><?php } ?>
                                                <div class="item__specification"><?php echo Labels::getLabel('Lbl_Payment_Status',$siteLangId)?>: <?php echo $row['orderstatus_name'];?></div>
                                              </div>
                                             </td>
                                            <td><div class="item__price"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row,'netamount',false,USER::USER_TYPE_SELLER)); ?></div></td>
                                            <td>
                                              <ul class="actions">
                                                <li><a title="<?php echo Labels::getLabel('LBL_View_Order',$siteLangId);?>" href="<?php echo $orderDetailUrl;?>"><i class="fa fa-eye"></i></a></li>
                                                <?php if (!in_array($row["op_status_id"],$notAllowedStatues)){ ?>
                                                <li><a href="<?php echo CommonHelper::generateUrl('seller','cancelOrder',array($row['op_id']));?>" title="<?php echo Labels::getLabel('LBL_Cancel_Order',$siteLangId);?>"><i class="fa fa-close"></i></a></li>
                                                <?php }	?>
                                              </ul>
                                             </td>
                                          </tr>
                                      <?php }
                                  }else{ ?>
                                    <tr>
                                        <td colspan="3">
                                            <?php $this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                <span class="scroll-hint-icon">
                                  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
                                </span>
                            </div>
                        </table>
                    </div>
                </div>
			</div>
		</div>
        <div class="row mb-3">
			<div class="col-lg-12 col-md-12">
                <div class="cards">
                    <div class="cards-header p-3">
                        <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Transaction_History',$siteLangId);?></h5>
                        <?php if( count( $transactions ) > 0 ){ ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('Account','credits');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cards-content p-3">
                        <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                            <tbody>
                                 <tr class="">
                                    <th><?php echo Labels::getLabel('LBL_Txn._Id',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Date',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Credit',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Debit',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Balance',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></th>
                                    <th><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></th>
                                  </tr>
                                  <?php if( count( $transactions ) > 0 ){
                                            foreach( $transactions as $row ){ ?>
                                            <tr>
                                                <td>
                                                    <div class="txn__id">
                                                        <?php echo Labels::getLabel('Lbl_Txn._Id',$siteLangId)?>: <?php echo Transactions::formatTransactionNumber($row['utxn_id']); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__date">
                                                        <?php echo FatDate::format($row['utxn_date']);?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__credit">
                                                        <?php echo CommonHelper::displayMoneyFormat($row['utxn_credit']);?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__debit">
                                                        <?php echo CommonHelper::displayMoneyFormat($row['utxn_debit']);?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__balance">
                                                        <?php echo CommonHelper::displayMoneyFormat( $row['balance'] );?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__comments">
                                                        <?php echo $row['utxn_comments'];?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="txn__status">
                                                        <?php echo $txnStatusArr[$row['utxn_status']];?>
                                                    </div>
                                                </td>
                                            </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                          <td colspan="7">
                                              <?php $this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false); ?>
                                          </td>
                                      </tr>
                                  <?php } ?>
                            </tbody>
                            <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                <span class="scroll-hint-icon">
                                  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
                                </span>
                            </div>
                        </table>
                    </div>
                </div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-12">
                <div class="cards">
                    <div class="cards-header p-3">
                        <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Return_requests',$siteLangId);?></h5>
                        <?php if( count( $returnRequests ) > 0 ){ ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('seller','orderReturnRequests');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cards-content p-3">
                        <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                            <tbody>
                                 <tr class="">
                                    <th width="60%"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
                                    <th width="10%"><?php echo Labels::getLabel('LBL_Qty',$siteLangId);?></th>
                                    <th width="20%"><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></th>
                                    <th width="10%"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></th>
                                  </tr>
                                  <?php if( count( $returnRequests ) > 0 ){
                                            foreach( $returnRequests as $row ){
                                                $orderDetailUrl = CommonHelper::generateUrl('seller', 'viewOrder', array($row['op_id']) );
                                                $prodOrBatchUrl = 'javascript:void(0)';
                                                if( $row['op_is_batch'] ){
                                                    $prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($row['op_selprod_id']));
                                                } else {
                                                    if(Product::verifyProductIsValid($row['op_selprod_id']) == true){
                                                        $prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($row['op_selprod_id']));
                                                    }
                                                }
                                        ?>
                                          <tr>
                                            <td>
                                                <div class="item__description">
                                                    <div class="request__date"><?php echo FatDate::format($row['orrequest_date']);?></div>
                                                    <div class="item__title">
                                                        <a title="<?php echo Labels::getLabel('LBL_Invoice_number',$siteLangId);?>" href="<?php echo $orderDetailUrl; ?>"><?php echo $row['op_invoice_number'];?></a>
                                                    </div>
                                                    <div class="item__title">
                                                        <?php if($row['op_selprod_title'] != ''){ ?>
                                                            <a title="<?php echo $row['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>">
                                                                <?php echo $row['op_selprod_title']; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl; ?>">
                                                                <?php echo $row['op_product_name']; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                             </td>
                                            <td>
                                                <div class="request__qty">
                                                    <?php echo $row['orrequest_qty'];?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="request__status">
                                                    <?php echo $OrderReturnRequestStatusArr[$row['orrequest_status']];?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                    $url = CommonHelper::generateUrl('Seller', 'ViewOrderReturnRequest', array($row['orrequest_id']) );
                                                ?>
                                              <ul class="actions">
                                                <li>
                                                    <a title="<?php echo Labels::getLabel('LBL_View_Request',$siteLangId);?>" href="<?php echo $url;?>">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </li>
                                              </ul>
                                             </td>
                                          </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                          <td colspan="4">
                                              <?php $this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false); ?>
                                          </td>
                                      </tr>
                                  <?php } ?>
                            </tbody>
                            <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                <span class="scroll-hint-icon">
                                  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
                                </span>
                            </div>
                        </table>
                    </div>
                </div>
			</div>
			<div class="col-lg-6 col-md-12">
				<!-- <div class="cards">
					<?php // $this->includeTemplate('_partial/userDashboardMessages.php'); ?>
				</div> -->
                <div class="cards">
                    <div class="cards-header p-3">
                        <h5 class="cards-title "><?php echo Labels::getLabel('LBL_Cancellation_requests',$siteLangId);?></h5>
                        <?php if( count( $cancellationRequests ) > 0 ){ ?>
                            <div class="action">
                                <a href="<?php echo CommonHelper::generateUrl('seller','orderCancellationRequests');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cards-content p-3">
                        <table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
                            <tbody>
                                 <tr class="">
                                    <th width="40%"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
                                    <th width="50%"><?php echo Labels::getLabel('LBL_Request_detail',$siteLangId);?></th>
                                    <th width="10%"><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></th>
                                  </tr>
                                  <?php if( count( $cancellationRequests ) > 0 ){
                                            foreach( $cancellationRequests as $row ){
                                                $orderDetailUrl = CommonHelper::generateUrl('seller', 'viewOrder', array($row['op_id']) );
                                                $prodOrBatchUrl = 'javascript:void(0)';
                                                if( $row['op_is_batch'] ){
                                                    $prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($row['op_selprod_id']));
                                                } else {
                                                    if(Product::verifyProductIsValid($row['op_selprod_id']) == true){
                                                        $prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($row['op_selprod_id']));
                                                    }
                                                }
                                            ?>
                                          <tr>
                                            <td>
                                                <div class="item__description">
                                                    <div class="request__date"><?php echo FatDate::format($row['ocrequest_date']);?></div>
                                                    <div class="item__title">
                                                        <a title="<?php echo Labels::getLabel('Lbl_Invoice_number',$siteLangId)?>" href="<?php echo $orderDetailUrl; ?>">
                                                            <?php echo $row['op_invoice_number']; ?>
                                                        </a>
                                                    </div>
                                                    <div class="item__title">
                                                        <?php if($row['op_selprod_title'] != ''){ ?>
                                                            <a title="<?php echo $row['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>">
                                                                <?php echo $row['op_selprod_title']; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl; ?>">
                                                                <?php echo $row['op_product_name']; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="request__reason">
                                                    <?php echo Labels::getLabel('Lbl_Reason',$siteLangId)?>: <?php echo $row['ocreason_title']; ?>
                                                </div>
                                                <div class="request__comments">
                                                    <?php echo Labels::getLabel('Lbl_Comments',$siteLangId)?>: <?php echo $row['ocrequest_message']; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="request__status">
                                                    <?php echo $OrderCancelRequestStatusArr[$row['ocrequest_status']];?>
                                                </div>
                                            </td>
                                          </tr>
                                      <?php }
                                    }else{ ?>
                                      <tr>
                                          <td colspan="3">
                                             <?php $this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false); ?>
                                          </td>
                                      </tr>
                                  <?php } ?>
                            </tbody>
                            <div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
                                <span class="scroll-hint-icon">
                                  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
                                </span>
                            </div>
                        </table>
                    </div>
                </div>
			</div>
		</div>
	</div>
  </div>
</main>
<script>
 /******** for tooltip ****************/

$('.info--tooltip-js').hover(function(){
    $(this).toggleClass("is-active");
    return false;
},function(){
    $(this).toggleClass("is-active");
    return false;
});

</script>
