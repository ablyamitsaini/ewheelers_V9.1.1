<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-auto ">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Dashboard',$siteLangId);?></h2>
		</div>
		<div class="content-header-right col-auto">
			<div class="btn-group">
				<a href="<?php echo CommonHelper::generateUrl('Account','wishlist');?>" class="btn btn--sm"><?php echo $totalFavouriteItems;?> <?php echo Labels::getLabel('LBL_Favorite_Items',$siteLangId);?> </a>
				<a href="<?php echo CommonHelper::generateUrl('Buyer','orders');?>" class="btn btn--secondary btn--sm"><?php echo $totalPurchasedItems['totalPurchasedItems'];?> <?php echo Labels::getLabel('LBL_Purchased_Items',$siteLangId);?> </a>
			</div>
		</div>
	</div>
	<div class="content-body">
		<div class="widget-wrapper mb-3">
			<div class="widget widget-stats">
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
								<?php echo CommonHelper::displayMoneyFormat($userBalance);?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="widget widget-stats">
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Today_Orders',$siteLangId);?> </h6>
								<?php echo $todayOrderCount;?>
								<h6 class="total"><?php echo Labels::getLabel('LBL_Today_Orders',$siteLangId);?> </h6>
								<?php echo $todayOrderCount;?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="widget widget-stats">
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Unread_Notification_Today',$siteLangId);?></h6>
								<?php echo $todayUnreadMessageCount;?>
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
								<?php echo $totalMessageCount;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="cards">
					<div class="cards-header p-3">
						<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Latest_Orders',$siteLangId);?></h5>
						<div class="action">
							<?php if( $ordersCount > 5 ){?>
							<a href="<?php echo CommonHelper::generateUrl('buyer','orders');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
							<?php }?>
						</div>
					</div>
					<div class="cards-content p-3">
					<?php if(count($orders)>0){ ?>
						<table class="table table--orders js-scrollable scroll-hint" style="position: relative; overflow: auto;">
							<tbody>
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
								<td>
								<?php
								$prodOrBatchUrl = 'javascript:void(0)';
								if($row['op_is_batch']){

										$prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($row['op_selprod_id']));
										$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','BatchProduct', array($row['op_selprod_id'],$siteLangId, "SMALL"),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
								}else{
										if(Product::verifyProductIsValid($row['op_selprod_id']) == true){
											$prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($row['op_selprod_id']));
										}
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
										<a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $prodName;?></a></div>
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
									<td><span class="item__price"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row)) /* CommonHelper::displayMoneyFormat($row['order_net_amount']) */;?></span></td>
									<td>
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
							</tbody>
							<div class="scroll-hint-icon-wrap" data-target="scrollable-icon">
								<span class="scroll-hint-icon">
								  <div class="scroll-hint-text"><?php echo Labels::getLabel('LBL_Scrollable',$siteLangId);?></div>
								</span>
							</div>
						</table>
						<?php } else{
							$this->includeTemplate('_partial/no-record-found.php',array('siteLangId'=>$siteLangId),false);
						} ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12">
				<div class="cards">
					<?php $this->includeTemplate('_partial/userDashboardMessages.php'); ?>
				</div>
			</div>
		</div>
	</div>
 </div>
</main>
