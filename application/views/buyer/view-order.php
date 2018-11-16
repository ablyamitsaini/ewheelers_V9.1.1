<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="container">
      <div class="row">
        <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
        <div class="col-xs-10 panel__right--full" >
          <div class="cols--group">
            <div class="panel__head no-print">
              <h2><?php echo Labels::getLabel('LBL_View_Order',$siteLangId);?></h2>
            </div>
            <div class="panel__body">
              <div class="box box--white box--space">
                <div class="box__head no-print" >
                  <h4><?php echo Labels::getLabel('LBL_Order_Details',$siteLangId);?></h4>
                  <div class="group--btns"> <a href="javascript:window.print();" class="btn btn--primary  btn--sm no-print"><?php echo Labels::getLabel('LBL_Print',$siteLangId);?></a> <a href="<?php echo CommonHelper::generateUrl('Buyer','orders');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Back_to_order',$siteLangId);?></a> </div>
                </div>
                <div class="box__body">
                  <div class="grids--offset">
                    <div class="grid-layout">
                      <?php if($primaryOrder){?>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <p><strong><?php echo Labels::getLabel('LBL_Customer_Name',$siteLangId);?>: </strong><?php echo $childOrderDetail['user_name'];?></p>
                          <?php
								$paymentMethodName = $childOrderDetail['pmethod_name']?:$childOrderDetail['pmethod_identifier'];
								if( $childOrderDetail['order_pmethod_id'] > 0 && $childOrderDetail['order_is_wallet_selected'] > 0 ){
									$paymentMethodName .= ' + ';
								}
								if( $childOrderDetail['order_is_wallet_selected'] > 0 ){
									$paymentMethodName .= Labels::getLabel("LBL_Wallet",$siteLangId);
								}
							?>
                          <p><strong><?php echo Labels::getLabel('LBL_Payment_Method',$siteLangId);?>: </strong><?php echo $paymentMethodName;?></p>
                          <p><strong><?php echo Labels::getLabel('LBL_Status',$siteLangId);?>: </strong><?php echo $orderStatuses[$childOrderDetail['op_status_id']];?></p>
                          <p><strong><?php echo Labels::getLabel('LBL_Cart_Total',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrderDetail,'CART_TOTAL'));?></p>
                          <p><strong><?php echo Labels::getLabel('LBL_Delivery',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrderDetail,'SHIPPING'));?></p>
                          <p><strong><?php echo Labels::getLabel('LBL_Tax',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrderDetail,'TAX')); ?></p>
                          <p><strong><?php echo Labels::getLabel('LBL_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrderDetail,'DISCOUNT'));?></p>
                          <?php $volumeDiscount = CommonHelper::orderProductAmount($childOrderDetail,'VOLUME_DISCOUNT');
						  if( $volumeDiscount ){ ?>
                          <p><strong><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat($volumeDiscount);?></p>
                          <?php } ?>
                          <?php $rewardPointDiscount = CommonHelper::orderProductAmount($childOrderDetail,'REWARDPOINT');
													 if($rewardPointDiscount != 0){?>
                          <p><strong><?php echo Labels::getLabel('LBL_Reward_Point_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat($rewardPointDiscount);?></p>
                          <?php }?>
                          <p><strong><?php echo Labels::getLabel('LBL_Order_Total',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrderDetail));?></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <div class="info--order">
                            <p><strong><?php echo Labels::getLabel('LBL_Invoice',$siteLangId);?> #: </strong><?php echo $childOrderDetail['op_invoice_number'];?></p>
                            <p><strong><?php echo Labels::getLabel('LBL_Date',$siteLangId);?>: </strong><?php echo FatDate::format($childOrderDetail['order_date_added']);?></p>
                          </div>
                        </div>
                      </div>
                      <?php }else{?>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <p><strong><?php echo Labels::getLabel('LBL_Order',$siteLangId);?>: </strong><?php echo $orderDetail['order_id'];?></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <div class="info--order">
                            <p><strong><?php echo Labels::getLabel('LBL_Date',$siteLangId);?>: </strong><?php echo FatDate::format($orderDetail['order_date_added']);?></p>
                          </div>
                        </div>
                      </div>
                      <?php }?>
                    </div>
                  </div>
                  <table class="table">
                    <tbody>
                      <tr class="">
                        <th><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
                        <th class="no-print"></th>
                        <th><?php echo Labels::getLabel('LBL_Qty',$siteLangId);?></th>
                        <th><?php echo Labels::getLabel('LBL_Price',$siteLangId);?></th>
                        <th><?php echo Labels::getLabel('LBL_Shipping_Charges',$siteLangId);?></th>
                        <th><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?></th>
                        <th> <?php echo Labels::getLabel('LBL_Tax_Charges',$siteLangId);?></th>
                        <th> <?php echo Labels::getLabel('LBL_Reward_Point_Discount',$siteLangId);?></th>
                        <th><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></th>
                      </tr>
                      <?php
						$cartTotal = 0;
						$shippingCharges = 0;
						$total = 0;
						if($primaryOrder){
							$arr[] = $childOrderDetail;
						} else {
							$arr = $childOrderDetail;
						}
						foreach($arr as $childOrder){
						$cartTotal = $cartTotal + CommonHelper::orderProductAmount($childOrder,'cart_total');
						$shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($childOrder,'shipping');
						$volumeDiscount = CommonHelper::orderProductAmount($childOrder,'VOLUME_DISCOUNT');
						$rewardPointDiscount = CommonHelper::orderProductAmount($childOrder,'REWARDPOINT');
					?>
                      <tr>
                        <td class="no-print"><span class="caption--td"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></span>
                          <div class="pic--cell-left">
                            <?php
								$prodOrBatchUrl = 'javascript:void(0)';
								if($childOrder['op_is_batch']){
									$prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($childOrder['op_selprod_id']));
									$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','BatchProduct', array($childOrder['op_selprod_id'],$siteLangId, "SMALL"),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
								} else {
									if(Product::verifyProductIsValid($childOrder['op_selprod_id']) == true){
										$prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($childOrder['op_selprod_id']));
									}
									$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($childOrder['selprod_product_id'], "SMALL", $childOrder['op_selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
								}  ?>
                            <figure class="item__pic"><a href="<?php echo $prodOrBatchUrl;?>"><img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $childOrder['op_product_name'];?>" alt="<?php echo $childOrder['op_product_name']; ?>"></a></figure>
                          </div></td>
                        <td><div class="item__description">
                            <?php if($childOrder['op_selprod_title']!=''){ ?>
                            <div class="item-yk-head-title"><a title="<?php echo $childOrder['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $childOrder['op_selprod_title'].'<br/>'; ?></a></div>
                            <div class="item-yk-head-sub-title"><?php echo $childOrder['op_product_name']; ?></div>
                            <?php } else { ?>
                            <div class="item-yk-head-title"><a title="<?php echo $childOrder['op_product_name'];?>" href="<?php echo CommonHelper::generateUrl('Products','view',array($childOrder['op_selprod_id']));?>"><?php echo $childOrder['op_product_name']; ?> </a></div>
                            <?php } ?>
                            <div class="item-yk-head-brand"><?php echo Labels::getLabel('Lbl_Brand',$siteLangId)?>: <?php echo CommonHelper::displayNotApplicable($siteLangId,$childOrder['op_brand_name']);?></div>
                            <?php if( $childOrder['op_selprod_options'] != '' ){ ?>
                            <div class="item-yk-head-specification"><?php echo $childOrder['op_selprod_options'];?></div>
                            <?php } ?>
                            <div class="item-yk-head-specification"><?php echo Labels::getLabel('LBL_Sold_By', $siteLangId).': '.$childOrder['op_shop_name']; ?></div>
							<?php if($childOrder['op_shipping_duration_name'] != ''){?>
                            <div class="item-yk-head-specification"><?php echo Labels::getLabel('LBL_Shipping_Method',$siteLangId);?>: <?php echo $childOrder['op_shipping_durations'].'-'. $childOrder['op_shipping_duration_name'];?></div>
							<?php }?>
                          </div></td>
                        <!--<td style="width:20%;" ><span class="caption--td"><?php echo Labels::getLabel('LBL_Shipping_Method',$siteLangId);?></span><?php echo $childOrder['op_shipping_durations'].'-'. $childOrder['op_shipping_duration_name'];?></td>-->
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Qty',$siteLangId);?></span><?php echo $childOrder['op_qty'];?></td>
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Price',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat($childOrder['op_unit_price']);?></td>
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Shipping_Charges',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder,'shipping'));?></td>
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat($volumeDiscount);?></td>
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Tax_Charges',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder,'tax'));?></td>
						<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Reward_Point_Discount',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat($rewardPointDiscount);?></td>
                        <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder));?></td>
                      </tr>
                      <?php } if(!$primaryOrder){?>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('Lbl_Cart_Total',$siteLangId)?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat($cartTotal);?></td>
                      </tr>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('LBL_Shipping_Charges',$siteLangId)?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat($shippingCharges);?></td>
                      </tr>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('LBL_Tax_Charges',$siteLangId)?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat($orderDetail['order_tax_charged']);?></td>
                      </tr>
                      <?php if($orderDetail['order_discount_total']){ ?>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('LBL_Discount',$siteLangId)?></td>
                        <td>-<?php echo CommonHelper::displayMoneyFormat($orderDetail['order_discount_total']);?></td>
                      </tr>
                      <?php }?>
                      <?php if($orderDetail['order_volume_discount_total']){ ?>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId)?></td>
                        <td>-<?php echo CommonHelper::displayMoneyFormat($orderDetail['order_volume_discount_total']);?></td>
                      </tr>
                      <?php }?>
                      <tr>
                        <td colspan="7"><?php echo Labels::getLabel('LBL_Total',$siteLangId)?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat($orderDetail['order_net_amount']);?></td>
                      </tr>
                      <?php }?>
                    </tbody>
                  </table>
                  <div class="grids--colum">
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="grid">
                          <h5><?php echo Labels::getLabel('LBL_Billing_Details',$siteLangId);?></h5>
                          <?php $billingAddress = $orderDetail['billingAddress']['oua_name'].'<br>';
								if($orderDetail['billingAddress']['oua_address1']!=''){
									$billingAddress.=$orderDetail['billingAddress']['oua_address1'].'<br>';
								}

								if($orderDetail['billingAddress']['oua_address2']!=''){
									$billingAddress.=$orderDetail['billingAddress']['oua_address2'].'<br>';
								}

								if($orderDetail['billingAddress']['oua_city']!=''){
									$billingAddress.=$orderDetail['billingAddress']['oua_city'].',';
								}

								if($orderDetail['billingAddress']['oua_zip']!=''){
									$billingAddress.=$orderDetail['billingAddress']['oua_state'];
								}

								if($orderDetail['billingAddress']['oua_zip']!=''){
									$billingAddress.= '-'.$orderDetail['billingAddress']['oua_zip'];
								}

								if($orderDetail['billingAddress']['oua_phone']!=''){
									$billingAddress.= '<br>'.$orderDetail['billingAddress']['oua_phone'];
								}
							?>
                          <p><?php echo $billingAddress;?></p>
                        </div>
                      </div>
                      <?php if(!empty($orderDetail['shippingAddress'])){?>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="grid">
                          <h5><?php echo Labels::getLabel('LBL_Shipping_Details',$siteLangId);?></h5>
                          <?php $shippingAddress = $orderDetail['shippingAddress']['oua_name'].'<br>';
								if($orderDetail['shippingAddress']['oua_address1']!=''){
									$shippingAddress.=$orderDetail['shippingAddress']['oua_address1'].'<br>';
								}

								if($orderDetail['shippingAddress']['oua_address2']!=''){
									$shippingAddress.=$orderDetail['shippingAddress']['oua_address2'].'<br>';
								}

								if($orderDetail['shippingAddress']['oua_city']!=''){
									$shippingAddress.=$orderDetail['shippingAddress']['oua_city'].',';
								}

								if($orderDetail['shippingAddress']['oua_zip']!=''){
									$shippingAddress.=$orderDetail['shippingAddress']['oua_state'];
								}

								if($orderDetail['shippingAddress']['oua_zip']!=''){
									$shippingAddress.= '-'.$orderDetail['shippingAddress']['oua_zip'];
								}

								if($orderDetail['shippingAddress']['oua_phone']!=''){
									$shippingAddress.= '<br>'.$orderDetail['shippingAddress']['oua_phone'];
								}
							?>
                          <p><?php echo $shippingAddress;?></p>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <?php if(!empty($orderDetail['comments'])){ ?>
                  <div class="section--repeated">
                    <h5><?php echo Labels::getLabel('LBL_Posted_Comments',$siteLangId);?></h5>
                    <table class="table align--left">
                      <tbody>
                        <tr class="">
                          <th><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Customer_Notified',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></th>
                        </tr>
                        <?php foreach($orderDetail['comments'] as $row){ ?>
                        <tr>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></span><?php echo FatDate::format($row['oshistory_date_added']);?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Customer_Notified',$siteLangId);?></span><?php echo $yesNoArr[$row['oshistory_customer_notified']];?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></span><?php echo ($row['oshistory_orderstatus_id']>0)?$orderStatuses[$row['oshistory_orderstatus_id']]:CommonHelper::displayNotApplicable($siteLangId,''); echo ($row['oshistory_tracking_number'])? ': '.Labels::getLabel('LBL_Tracking_Number',$siteLangId).' '.$row['oshistory_tracking_number']." VIA <em>".$row['op_shipping_duration_name']."</em>" :'' ?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></span> <?php echo !empty(trim(($row['oshistory_comments']))) ? nl2br($row['oshistory_comments']) : Labels::getLabel('LBL_NA',$siteLangId) ;?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } ?>
                  <?php if( !empty( $orderDetail['payments'] ) ){ ?>
				  <span class="gap"></span>
                  <div class="section--repeated">
                    <h5><?php echo Labels::getLabel('LBL_Payment_History',$siteLangId);?></h5>
                    <table class="table align--left">
                      <tbody>
                        <tr class="">
                          <th><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Txn_Id',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Payment_Method',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Amount',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></th>
                        </tr>
                        <?php foreach( $orderDetail['payments'] as $row ){ ?>
                        <tr>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></span><?php echo FatDate::format($row['opayment_date']);?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Txn_Id',$siteLangId);?></span><?php echo $row['opayment_gateway_txn_id'];?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Payment_Method',$siteLangId);?></span><?php echo $row['opayment_method'];?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Amount',$siteLangId);?></span><?php echo CommonHelper::displayMoneyFormat($row['opayment_amount']);?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></span> <?php echo nl2br($row['opayment_comments']);?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } ?>
				  <?php if( !empty( $digitalDownloads ) ){ ?>
				  <span class="gap"></span>
                  <div class="section--repeated">
                    <h5><?php echo Labels::getLabel('LBL_Downloads',$siteLangId);?></h5>
                    <table class="table align--left">
                      <tbody>
                        <tr class="">
                          <th><?php echo Labels::getLabel('LBL_Sr_No',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_File',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Language',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Download_times',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Downloaded_count',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Expired_on',$siteLangId);?></th>
                          <th><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></th>
                        </tr>
                        <?php $sr_no = 1;
							foreach( $digitalDownloads as $key=>$row ){
								$lang_name = Labels::getLabel('LBL_All',$siteLangId);
								if( $row['afile_lang_id'] > 0 ){
									$lang_name = $languages[$row['afile_lang_id']];
								}

								if($row['downloadable']){
									$fileName = '<a href="'.CommonHelper::generateUrl('Buyer','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'])).'">'.$row['afile_name'].'</a>';
								}else{
									$fileName = $row['afile_name'];
								}
								$downloads = '<li><a href="'.CommonHelper::generateUrl('Buyer','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'])).'"><i class="fa fa-download"></i></a></li>';

								$expiry = Labels::getLabel('LBL_N/A',$siteLangId) ;
								if($row['expiry_date']!=''){
									$expiry = FatDate::Format($row['expiry_date']);
								}

								$downloadableCount = Labels::getLabel('LBL_N/A',$siteLangId) ;
								if($row['downloadable_count'] != -1){
									$downloadableCount = $row['downloadable_count'];
								}
								?>
                        <tr>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Sr_No',$siteLangId);?></span><?php echo $sr_no;?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_File',$siteLangId);?></span><?php echo $fileName;?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Language',$siteLangId);?></span><?php echo $lang_name;?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Download_times',$siteLangId);?></span><?php echo $downloadableCount;?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Downloaded_count',$siteLangId);?></span><?php echo $row['afile_downloaded_times'];?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Expired_on',$siteLangId);?></span><?php echo $expiry;?></td>
                          <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></span><?php if($row['downloadable']){?><ul class="actions"><?php echo $downloads;?></ul><?php }?></td>
                        </tr>
                        <?php $sr_no++; } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } ?>

					<?php if( !empty( $digitalDownloadLinks ) ){ ?>
					<span class="gap"></span>
					  <div class="section--repeated">
						<h5><?php echo Labels::getLabel('LBL_Download_Links',$siteLangId);?></h5>
						<table class="table align--left">
						  <tbody>
							<tr class="">
							  <th><?php echo Labels::getLabel('LBL_Sr_No',$siteLangId);?></th>
							  <th><?php echo Labels::getLabel('LBL_Link',$siteLangId);?></th>
							  <th><?php echo Labels::getLabel('LBL_Download_times',$siteLangId);?></th>
							  <th><?php echo Labels::getLabel('LBL_Downloaded_count',$siteLangId);?></th>
							  <th><?php echo Labels::getLabel('LBL_Expired_on',$siteLangId);?></th>
							</tr>
							<?php $sr_no = 1;
							foreach( $digitalDownloadLinks as $key=>$row ){

								$expiry = Labels::getLabel('LBL_N/A',$siteLangId) ;
								if($row['expiry_date']!=''){
									$expiry = FatDate::Format($row['expiry_date']);
								}

								$downloadableCount = Labels::getLabel('LBL_N/A',$siteLangId) ;
								if($row['downloadable_count'] != -1){
									$downloadableCount = $row['downloadable_count'];
								}

								$link = ($row['downloadable']!=1) ? Labels::getLabel('LBL_N/A',$siteLangId) : $row['opddl_downloadable_link'];
								$linkUrl = ($row['downloadable']!=1) ? 'javascript:void(0)' : $row['opddl_downloadable_link'];
								$linkOnClick = ($row['downloadable']!=1) ? '' : 'return increaseDownloadedCount('.$row['opddl_link_id'].','.$row['op_id'].'); ';
								$linkTitle = ($row['downloadable']!=1) ? '' : Labels::getLabel('LBL_Click_to_download',$siteLangId);
							?>
							<tr>
							  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Sr_No',$siteLangId);?></span><?php echo $sr_no;?></td>
							  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Link',$siteLangId);?></span><a target="_blank" onClick="<?php echo $linkOnClick; ?> " href="<?php echo $linkUrl; ?>" data-link="<?php echo $linkUrl; ?>" title="<?php echo $linkTitle; ?>"><?php echo $link;?></a></td>
							  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Download_times',$siteLangId);?></span><?php echo $downloadableCount;?></td>
							  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Downloaded_count',$siteLangId);?></span><?php echo $row['opddl_downloaded_times'];?></td>
							  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Expired_on',$siteLangId);?></span><?php echo $expiry;?></td>
							</tr>
							<?php $sr_no++; } ?>
						  </tbody>
						</table>
					  </div>
					  <?php } ?>
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
<script>
	function increaseDownloadedCount( linkId, opId ){
		fcom.ajax(fcom.makeUrl('buyer', 'downloadDigitalProductFromLink', [linkId,opId]), '', function(t) {
			var ans = $.parseJSON(t);
			if( ans.status == 0 ){
				$.systemMessage( ans.msg, 'alert--danger');
				return false;
			}
			/* var dataLink = $(this).attr('data-link');
			window.location.href= dataLink; */
			location.reload();
			return true;
		});
	}
</script>
