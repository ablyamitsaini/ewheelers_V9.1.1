<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
				<div class="col-md-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_Buyer',$siteLangId);?></h2>
							<ul class="links--inline">
							  <li><a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>"><strong><?php echo $totalFavouriteItems;?></strong> <?php echo Labels::getLabel('LBL_Favorite_Items',$siteLangId);?> </a></li>
							  <li><a href="<?php echo CommonHelper::generateUrl('Buyer','orders');?>"><strong><?php echo $totalPurchasedItems['totalPurchasedItems'];?></strong> <?php echo Labels::getLabel('LBL_Purchased_Items',$siteLangId);?> </a></li>
							</ul>
						</div>                           
						<div class="panel__body">
							<div class="col__right">
								<div class="statistics">
									<div class="statistics__box">
									<a href="<?php echo CommonHelper::generateUrl('Account','Credits');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_buyer_dashboard_credits',$siteLangId); ?>">
										<h4><span><?php echo Labels::getLabel('LBL_Credits',$siteLangId);?></span></h4>
										<span class="value--total"><?php echo CommonHelper::displayMoneyFormat($userBalance);?></span>
										<span class="text--normal"><br><strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span>
									</a>
									</div>
									<div class="statistics__box">
									<a href="<?php echo CommonHelper::generateUrl('Buyer','Orders');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_buyer_dashboard_orders',$siteLangId); ?>">
										<h4><span><?php echo Labels::getLabel('LBL_Order',$siteLangId);?></span></h4>
										<span class="value--total"> <?php echo $ordersCount;?></span>
										<span class="text--normal"><?php echo Labels::getLabel('LBL_Yesterday_Orders',$siteLangId);?> <?php echo $yesterdayOrderCount;?>  <br><strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span>
									</a>
									</div>
									<div class="statistics__box">
									<a href="<?php echo CommonHelper::generateUrl('Account','Messages');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_buyer_dashboard_messages',$siteLangId); ?>">
										<h4><span><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></span></h4>
										<span class="value--total"><?php echo $totalMessageCount;?></span>
										<span class="text--normal"><?php echo $todayUnreadMessageCount;?> <?php echo Labels::getLabel('LBL_Unread_Notification_Today',$siteLangId);?> <br><strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span>
									</a>
									</div>
								</div>
							</div>
							<div class="col__left">
								<!-- <div class="box box--white box--space">
									<div class="box__head">
										<h4><?php echo Labels::getLabel('LBL_Information',$siteLangId);?></h4>
										<div class="group--btns">
											<ul class="links--inline">
												<li><a href="<?php echo CommonHelper::generateUrl('account','profileInfo');?>"><?php echo Labels::getLabel('LBL_Edit',$siteLangId);?>  <i class="fa fa-pencil"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="box__body">
										<div class="tabs tabs--small tabs--offset tabs--scroll clearfix setactive-js">
											<ul>
												<li class="is-active"><a href="javascript:void(0);" onClick="personalInfo(this)"><?php echo Labels::getLabel( 'LBL_Personal', $siteLangId ); ?></a></li>
												<li><a href="javascript:void(0);" onClick="bankInfo(this)"><?php echo Labels::getlabel('LBL_Bank',$siteLangId);?> </a></li>
												<?php if( User::isSeller() ){ ?>
												<li><a href="javascript:void(0);" onClick="returnAddress(this)"><?php echo Labels::getlabel('LBL_Return_Address',$siteLangId);?></a></li>
												<?php } ?>
											</ul>
										</div>
										<div class="tabs__content" id="tabListing">
											<?php echo Labels::getlabel('LBL_loading..',$siteLangId);?>
										</div>
									</div>
								</div> -->

								<div class="box box--white box--space">
									<div class="box__head">
										<h4><?php echo Labels::getLabel('LBL_Latest_Orders',$siteLangId);?></h4>
											<?php if( $ordersCount > 5 ){?>
											<a href="<?php echo CommonHelper::generateUrl('buyer','orders');?>" class="link--arrow"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
											<?php }?>
									</div>
									<div class="box__body">
										<?php if(count($orders)>0){ ?>
										<table class="table table--orders">
											<tr class="">
												<th colspan="2" width="60%"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
												<th width="20%"><?php echo Labels::getLabel('LBL_Amount',$siteLangId);?></th>
												<th width="20%"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></th>
											</tr>
											<?php
													$canCancelOrder = true;
													$canReturnRefund = true;
													foreach($orders as $orderId=>$row){
													$orderDetailUrl = CommonHelper::generateUrl('Buyer', 'viewOrder', array($row['order_id'],$row['op_id']) );	
													if( $row['op_product_type'] == Product::PRODUCT_TYPE_DIGITAL ){
														$canCancelOrder = ( in_array($row["op_status_id"],(array)Orders::getBuyerAllowedOrderCancellationStatuses(true)) );
														$canReturnRefund = ( in_array( $row["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses(true) ) );
													} else {
														$canCancelOrder = ( in_array($row["op_status_id"],(array)Orders::getBuyerAllowedOrderCancellationStatuses()) );
														$canReturnRefund = ( in_array( $row["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses() ) );
													}
												?>
											<tr>
											<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></span>
											<?php 
											if($row['op_is_batch']){
											
													$prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($row['op_selprod_id']));
													$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','BatchProduct', array($row['op_selprod_id'],$siteLangId, "SMALL"),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
											}else{
													$prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($row['op_selprod_id']));
													$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($row['selprod_product_id'], "SMALL", $row['op_selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
											}  ?>
											<figure class="item__pic"><a href="<?php echo $prodOrBatchUrl;?>"><img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $row['op_product_name'];?>" alt="<?php echo $row['op_product_name']; ?>"></a></figure></td>
												<td>
												<div class="item-yk item__description">
													<div class="item-yk-head-date"><?php echo FatDate::format($row['order_date_added']);?></div>
													<div class="item-yk-head-title">
													<?php $prodName =''; 
													if($row['op_selprod_title']!=''){
														$prodName.= $row['op_selprod_title'].'<br/>';
													}
													$prodName.= $row['op_product_name'];
													?>
													<a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $row['op_product_name'];?></a></div>
													<div class="item-yk-head-brand"><span><?php echo Labels::getLabel('Lbl_Brand',$siteLangId)?>:</span> <?php echo CommonHelper::displayNotApplicable($siteLangId,$row['op_brand_name']);?></div>
													<?php if( $row['op_selprod_options'] != '' ){ ?>
													<div class="item-yk-head-specification"><?php echo $row['op_selprod_options'];?></div>
													<?php }?>
													<?php if( $row['totOrders'] > 1 ){
													echo Labels::getLabel('LBL_Part_combined_order', $siteLangId).' <a title="'.Labels::getLabel('LBL_View_Order_Detail', $siteLangId).'" href="'.CommonHelper::generateUrl('Buyer', 'viewOrder', array($row['order_id'])).'">'.$row['order_id'].'</a>';
													}?>
													<div class="item-yk-head-specification"><span><?php echo Labels::getLabel('Lbl_Payment_Status',$siteLangId)?>:</span> <?php echo $row['orderstatus_name'];?></div>
													</div>
												</td>
												<td><span class="caption--td"><?php echo Labels::getLabel('Lbl_Amount',$siteLangId)?></span> <span class="item__price"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row)) /* CommonHelper::displayMoneyFormat($row['order_net_amount']) */;?></span></td>
												<td><span class="caption--td"><?php echo Labels::getLabel('Lbl_Action',$siteLangId)?></span>
												<ul class="actions">
													<li><a title="<?php echo Labels::getLabel('LBL_View_Order',$siteLangId);?>" href="<?php echo $orderDetailUrl;?>"><i class="fa fa-eye"></i></a></li>
													<?php if( $canCancelOrder ){ ?>
													<li><a href="<?php echo CommonHelper::generateUrl('buyer','orderCancellationRequest',array($row['op_id']));?>" title="<?php echo Labels::getLabel('LBL_Cancel_Order',$siteLangId);?>"><i class="fa fa-close"></i></a></li>
													<?php }?>
													<?php if(FatApp::getConfig('CONF_ALLOW_REVIEWS',FatUtility::VAR_INT,0)){?>
													<li><a href="<?php echo CommonHelper::generateUrl('Buyer','orderFeedback',array($row['op_id']));?>" title="<?php echo Labels::getLabel('LBL_Feedback',$siteLangId);?>"><i class="fa fa-star"></i></a></li>
													<?php }?>
													<?php if( $canReturnRefund ){ ?>
													<li><a href="<?php echo CommonHelper::generateUrl('Buyer','orderReturnRequest',array($row['op_id']));?>" title="<?php echo Labels::getLabel('LBL_Refund',$siteLangId);?>"><i class="fa fa-dollar"></i></a></li>
													<?php } ?>
												</ul>
												</td>
											</tr>
											<?php }
											?>
										</table>
										<?php } else{
											$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
										} ?>
									</div>
								</div>
							</div>
							<div class="col__right">
								<?php $this->includeTemplate('_partial/userDashboardMessages.php'); ?>
							</div>
					   </div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>