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
				<a  href="<?php echo  CommonHelper::generateUrl('Seller','shop');?>" class="btn btn--border btn--sm"><?php echo Labels::getLabel('LBL_Create_Shop',$siteLangId); ?></a>
				<?php  } ?>
				<a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>" class="btn btn--border btn--sm"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></a>
				<a href="<?php echo CommonHelper::generateUrl('seller','products' );?>" class="btn btn--border btn--sm"><?php echo Labels::getLabel('LBL_My_Products',$siteLangId);?></a>
			</div>
		</div>
	</div>
	<div class="content-body">
		<div class="widget-wrapper mb-3">
			<div class="widget widget-stats">
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
								<?php echo CommonHelper::displayMoneyFormat($totalSoldSales);?>
							</div>
						</div>
					</div>
				</div>
			</div>
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Today_Orders',$siteLangId);?></h6>
								<?php echo $todayOrderCount;?>
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></h6>
								<?php echo $ordersCount;?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="widget widget-stats">
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
			</div>
			<?php /* if( FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE') ){ ?>
			<div class="widget widget-stats">
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
								<h6 class="total"><?php echo Labels::getLabel('LBL_Expired_On:',$siteLangId).' '; ?></h6>
								<?php echo (isset($subscriptionTillDate))? $subscriptionTillDate:''; ?>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<?php } */ ?>
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
					<div class="cards-header  p-3">
						<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Profile',$siteLangId);?></h5>
						<div class="action"><a href="<?php echo CommonHelper::generateUrl('Account','Profile');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a></div>
					</div>
					<div class="cards-content p-3">
						<div class="profile-wrapper">
							<div class="profile__dp"><img src="<?php echo CommonHelper::generateUrl('Image','user',array($data['user_id'],'MEDIUM',true));?>" title="<?php echo $data['user_name']?>" class=""></div>
							<div class="profile__bio">
								<div class="profile__title">
									<h6><?php echo $data['user_name']?> </h6>

								</div>
								<?php if($data['user_profile_info']!=''){ ?>
									<div class="profile__desc"><?php echo $data['user_profile_info'];?>
									<div class="gap"></div>
									<a href="<?php echo CommonHelper::generateUrl('Account','Profile');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('Lbl_Edit',$siteLangId);?></a></div>
								<?php }?>
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
							<a href="<?php echo CommonHelper::generateUrl('seller','sales');?>" class="link"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
							<?php }?>
						</div>
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
											<td><div class="item__description"> <span class="item__date"><?php echo FatDate::format($row['order_date_added']);?></span>
												<span class="item__title">
												<?php if($row['op_selprod_title'] != ''){ ?>
												<a title="<?php echo $row['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $row['op_selprod_title']; ?></a></span>
												<span class="item-yk-head-sub-title"><?php echo $row['op_product_name']; ?>
												<?php } else { ?>
												<a title="<?php echo $row['op_product_name'];?>" href="<?php echo $prodOrBatchUrl; ?>"><?php echo $row['op_product_name']; ?>
												</a>
												<?php } ?>
												</span>

												<p><?php echo Labels::getLabel('Lbl_Brand',$siteLangId)?>: <?php echo CommonHelper::displayNotApplicable($siteLangId,$row['op_brand_name']);?></p>
												<?php if( $row['op_selprod_options'] != '' ){ ?><p><?php echo $row['op_selprod_options'];?></p><?php } ?>
												<p><?php echo Labels::getLabel('Lbl_Payment_Status',$siteLangId)?>: <?php echo $row['orderstatus_name'];?></p>
											  </div>
											 </td>
											<td><span class="item__price"><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row,'netamount',false,USER::USER_TYPE_SELLER)); ?></span></td>
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
									} ?>
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
				<div class="cards">
					<?php $this->includeTemplate('_partial/userDashboardMessages.php'); ?>
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
