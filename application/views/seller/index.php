<div id="body" class="body bg--gray">
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="container">
      <div class="row">
        <?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
        <div class="col-xs-10 panel__right--full" >
          <div class="cols--group">
            <div class="panel__head">
              <h2><?php echo Labels::getLabel('LBL_Seller',$siteLangId);?></h2>
              <ul class="links--inline">
			<?php if(!Shop::isShopActive(UserAuthentication::getLoggedUserId(),0,true)){ ?>
                <li><a  href="<?php echo  CommonHelper::generateUrl('Seller','shop');?>"><?php echo Labels::getLabel('LBL_Create_Shop',$siteLangId); ?></a></li>
				<?php  } /* else { ?>
				<li><a href="javascript:void(0)" onclick="addCatalogPopup()"><?php echo Labels::getLabel('LBL_Add_A_Product',$siteLangId); ?></a></li>
				<?php
				} */ ?>
			   <li><a href="<?php echo CommonHelper::generateUrl('Seller','sales'); ?>"><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></a></li>
                <li><a href="<?php echo CommonHelper::generateUrl('seller','products' );?>"><?php echo Labels::getLabel('LBL_My_Products',$siteLangId);?></a></li>
              </ul>
            </div>
            <div class="panel__body">
				<div class="col__right">
					<div class="statistics">
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Seller','Sales');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_my_sales',$siteLangId); ?>" >
							<h4><span><?php echo Labels::getLabel('LBL_My_Sales',$siteLangId);?></span></h4>
							<span class="value--total"><?php echo CommonHelper::displayMoneyFormat($totalSoldSales);?></span> <span class="text--normal"><br>
							<strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span> </a>
						</div>
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Account','credits');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_credits',$siteLangId); ?>">
							<h4><span><?php echo Labels::getLabel('LBL_Credits',$siteLangId);?></span></h4>
							<span class="value--total"><?php echo CommonHelper::displayMoneyFormat($userBalance);?></span> <span class="text--normal"><br>
							<strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span> </a>
						</div>
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Seller','Sales');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_orders',$siteLangId); ?>">
							<h4><span><?php echo Labels::getLabel('LBL_Order',$siteLangId);?></span></h4>
							<span class="value--total"> <?php echo $ordersCount;?></span> <span class="text--normal"><?php echo Labels::getLabel('LBL_Yesterday_Orders',$siteLangId);?> <?php echo $yesterdayOrderCount;?> <br>
							<strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span> </a>
						</div>
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Seller','Sales');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_sold',$siteLangId); ?>">
							<h4><span><?php echo Labels::getLabel('LBL_Sold',$siteLangId);?></span></h4>
							<span class="value--total"><?php echo $totalSoldCount;?></span> <span class="text--normal"><?php echo Labels::getLabel('LBL_Yesterday_Sold',$siteLangId);?> <?php echo $yesterdaySoldCount;?> <br>
							<strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span> </a>
						</div>
						<?php if( FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE') ){ ?>
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Seller','subscriptions');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_subscription',$siteLangId); ?>">
							<h4><span><?php echo Labels::getLabel('LBL_Active_Subscription',$siteLangId);?></span></h4>
							<?php if($pendingDaysForCurrentPlan >= 0) {?>
							<span class="text--normal"> <strong><?php echo ($remainingAllowedProducts > 0)? $remainingAllowedProducts:0 ; ?></strong> <?php echo Labels::getLabel('LBL_Products',$siteLangId);?> & <strong><?php echo $pendingDaysForCurrentPlan; ?> <?php echo Labels::getLabel('LBL_Days',$siteLangId);?></strong> <?php echo Labels::getLabel('LBL_Remaining',$siteLangId);?> </span></a>
							<?php } else {?>
							<span class="text--normal"> <strong><?php echo Labels::getLabel('LBL_Expired_On:',$siteLangId).' '; ?> </strong> <?php echo (isset($subscriptionTillDate))? $subscriptionTillDate:''; ?></span></a>
							<?php }?>
						</div>
						<?php } ?>
						<div class="statistics__box">
							<a href="<?php echo CommonHelper::generateUrl('Account','Messages');?>" class="box box--white box--space info--tooltip info--tooltip-js" title="<?php echo Labels::getLabel('Lbl_tooltip_seller_dashboard_my_reviews',$siteLangId); ?>">
							<h4><span><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></span></h4>
							<span class="value--total"><?php echo $totalMessageCount;?></span> <span class="text--normal"><?php echo $todayUnreadMessageCount;?> <?php echo Labels::getLabel('LBL_Unread_Notification_Today',$siteLangId);?> <br>
							<strong><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></strong></span> </a>
						</div>
					</div>
				</div>
              <div class="col__left">
			    <div class="box box--white box--space">
                  <div class="box__head">
                    <h4><?php echo Labels::getLabel('LBL_Sales_Graph',$siteLangId);?></h4>
                  </div>
                  <div class="graph">
                    <?php $this->includeTemplate('_partial/seller/sellerSalesGraph.php'); ?>
                  </div>
                </div>
                <div class="box box--white box--space">
                  <div class="box__head">
                    <h4><?php echo Labels::getLabel('LBL_Latest_Orders',$siteLangId);?></h4>
                    <?php if( $ordersCount > 5 ){?>
                    <a href="<?php echo CommonHelper::generateUrl('seller','sales');?>" class="link--arrow"><?php echo Labels::getLabel('Lbl_View_All',$siteLangId);?></a>
                    <?php }?>
                  </div>
                  <div class="box__body">
                    <table class="table table--orders">
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
                    </table>
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
