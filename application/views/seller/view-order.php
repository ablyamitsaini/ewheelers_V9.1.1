<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
                <?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>                                 
				<div class="col-xs-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head no-print">
						   <h2><?php echo Labels::getLabel('LBL_View_Sale_Order',$siteLangId);?></h2>                       
						</div>
						<div class="panel__body">                            
                             <div class="box box--white box--space">
                               <div class="box__head no-print" >
                                   <h4><?php echo Labels::getLabel('LBL_Order_Details',$siteLangId);?></h4>
                                   <div class="group--btns"><a href="<?php echo CommonHelper::generateUrl('Seller','sales');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Back_to_order',$siteLangId);?></a></div>
                               </div>
                                <div class="box__body">                                    
                                     <div class="grids--offset">
                                         <div class="grid-layout">
                                             <div class="row">
                                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p><strong><?php echo Labels::getLabel('LBL_Customer_Name',$siteLangId);?>: </strong><?php echo $orderDetail['user_name'];?></p>
                                                    <?php
													$paymentMethodName = ($orderDetail['pmethod_name'] !='')?$orderDetail['pmethod_name']:$orderDetail['pmethod_identifier'];
													if( $orderDetail['order_pmethod_id'] > 0 && $orderDetail['order_is_wallet_selected'] > 0 ){
														$paymentMethodName .= ' + ';
													}
													if( $orderDetail['order_is_wallet_selected'] > 0 ){
														$paymentMethodName .= Labels::getLabel("LBL_Wallet",$siteLangId);
													}
													?>
													<p><strong><?php echo Labels::getLabel('LBL_Payment_Method',$siteLangId);?>: </strong><?php echo $paymentMethodName;?></p>
													<p><strong><?php echo Labels::getLabel('LBL_Status',$siteLangId);?>: </strong><?php echo $orderStatuses[$orderDetail['op_status_id']];?></p>
                                                    <p><strong><?php echo Labels::getLabel('LBL_Cart_Total',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'CART_TOTAL'));?></p>
													
													<?php if($shippedBySeller){?>
														<p><strong><?php echo Labels::getLabel('LBL_Delivery',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'SHIPPING'));?></p>
													<?php }?>
													
													<?php if($orderDetail['op_tax_collected_by_seller']){?>
														<p><strong><?php echo Labels::getLabel('LBL_Tax',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'TAX'));?></p>
													<?php }?>
													<?php /* 
													<p><strong><?php echo Labels::getLabel('LBL_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'DISCOUNT'));?></p>  */?>
													<?php $volumeDiscount = CommonHelper::orderProductAmount($orderDetail, 'VOLUME_DISCOUNT'); 
														if( $volumeDiscount ){ ?>
														<p><strong><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat($volumeDiscount);?></p>
														<?php } ?>
													<?php 
													/* $rewardPointDiscount = CommonHelper::orderProductAmount($orderDetail,'REWARDPOINT');
													if($rewardPointDiscount != 0){?>
													<p><strong><?php echo Labels::getLabel('LBL_Reward_Point_Discount',$siteLangId);?>:</strong> <?php echo CommonHelper::displayMoneyFormat($rewardPointDiscount);?></p>
													 <?php }  */?>
                                                     <p><strong><?php echo Labels::getLabel('LBL_Order_Total',$siteLangId);?>: </strong><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'netamount',false,USER::USER_TYPE_SELLER));?></p>
                                                 </div>
                                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                                     <div class="info--order">
                                                         <p><strong><?php echo Labels::getLabel('LBL_Invoice',$siteLangId);?> #: </strong><?php echo $orderDetail['op_invoice_number'];?></p>
                                                         <p><strong><?php echo Labels::getLabel('LBL_Date',$siteLangId);?>: </strong><?php echo FatDate::format($orderDetail['order_date_added']);?></p>
                                                         <span class="gap"></span>
                                                         <a href="javascript:window.print();" class="btn btn--primary no-print"><?php echo Labels::getLabel('LBL_Print',$siteLangId);?></a>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     
                                     <table class="table">
                                           <tbody><tr class="">
                                               <th><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></th>
                                               <th></th>
                                               <th><?php echo Labels::getLabel('LBL_Qty',$siteLangId);?></th>
                                               <th><?php echo Labels::getLabel('LBL_Price',$siteLangId);?></th>
												<?php if($shippedBySeller){?>
												<th><?php echo Labels::getLabel('LBL_Shipping_Charges',$siteLangId);?></th>
												<?php }?>
                                               <?php if( $volumeDiscount ){ ?>
													<th><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?></th>
												<?php } ?>
												<?php if($orderDetail['op_tax_collected_by_seller']){?>	
													<th><?php echo Labels::getLabel('LBL_Tax_Charges',$siteLangId);?></th>
												<?php }?>
											    <th><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></th>
                                           </tr>
                                           <tr>
                                               <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Order_Particulars',$siteLangId);?></span>
											   <div class="pic--cell-left">
												<?php 
												$prodOrBatchUrl = 'javascript:void(0)';
												if($orderDetail['op_is_batch']){
													$prodOrBatchUrl = CommonHelper::generateUrl('Products','batch',array($orderDetail['op_selprod_id']));
													$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','BatchProduct', array($orderDetail['op_selprod_id'],$siteLangId, "SMALL"),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
											   }else{
													if(Product::verifyProductIsValid($orderDetail['op_selprod_id']) == true){
														$prodOrBatchUrl = CommonHelper::generateUrl('Products','view',array($orderDetail['op_selprod_id']));
													}
													$prodOrBatchImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('image','product', array($orderDetail['selprod_product_id'], "SMALL", $orderDetail['op_selprod_id'], 0, $siteLangId),CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg');
											   }  ?>
                                               <figure class="item__pic"><a href="<?php echo $prodOrBatchUrl;?>"><img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $orderDetail['op_product_name'];?>" alt="<?php echo $orderDetail['op_product_name']; ?>"></a></figure><!--</td>
                                               <td>-->
											   </div>
                                               </td>
                                                
												<td>
													<span class="caption--td"></span>
													<div class="item__description">
														
														<?php if($orderDetail['op_selprod_title'] != ''){ ?>
														<div class="item-yk-head-title"><a title="<?php echo $orderDetail['op_selprod_title'];?>" href="<?php echo $prodOrBatchUrl;?>"><?php echo $orderDetail['op_selprod_title']; ?></a></div>
														<div class="item-yk-head-sub-title"><?php echo $orderDetail['op_product_name']; ?></div>
														<?php } else { ?>
														<div class="item-yk-head-title"><a title="<?php echo $orderDetail['op_product_name'];?>" href="<?php echo $prodOrBatchUrl; ?>"><?php echo $orderDetail['op_product_name']; ?>
														</a></div>
														<?php } ?>
														</div>
														<div class="item-yk-head-brand"><?php echo Labels::getLabel('Lbl_Brand',$siteLangId)?>: <?php echo CommonHelper::displayNotApplicable($siteLangId,$orderDetail['op_brand_name']);?></div>
														<?php if( $orderDetail['op_selprod_options'] != '' ){ ?>
														<div class="item-yk-head-specification"><?php echo $orderDetail['op_selprod_options'];?></div>
														<?php }?>
														<?php if($orderDetail['op_shipping_duration_name'] != '' ){?>
														<div class="item-yk-head-specification"><?php echo Labels::getLabel('LBL_Shipping_Method',$siteLangId);?>: <?php echo $orderDetail['op_shipping_durations'].'-'. $orderDetail['op_shipping_duration_name'];?></div>
														<?php }?>
													</div>
											   </td>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Qty',$siteLangId);?></span><?php echo $orderDetail['op_qty'];?></td>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Price',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat($orderDetail['op_unit_price']);?></td>
                                                
												<?php if($shippedBySeller){?>
												<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Shipping_Charges',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'shipping'));?></td>
												<?php }?>
												
												<?php if( $volumeDiscount ){ ?>
												<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Volume/Loyalty_Discount',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat($volumeDiscount);?></td>
												<?php } ?>
												
												<?php if($orderDetail['op_tax_collected_by_seller']){?>
												<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Tax_Charges',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'tax')); 
												?></td>
												<?php }?>
												
												<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Total',$siteLangId);?></span> <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($orderDetail,'netamount',false,USER::USER_TYPE_SELLER));?></td>
                                            </tr>                                            
                                     </tbody></table>                                     
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
                                     <?php if($displayForm){?>
                                     <div class="section--repeated no-print">
										<h5><?php echo Labels::getLabel('LBL_Comments_on_order',$siteLangId);?></h5>
                                        <?php 
										$frm->setFormTagAttribute('onsubmit', 'updateStatus(this); return(false);');
										$frm->setFormTagAttribute('class','form');
										$frm->developerTags['colClassPrefix'] = 'col-md-';
										$frm->developerTags['fld_default_col'] = 12; 
	
										$fld = $frm->getField('op_status_id');
										$fld->developerTags['col'] = 6;
										
										$fld1 = $frm->getField('customer_notified');
										$fld1->developerTags['col'] = 6;
										
										$fldTracking = $frm->getField('tracking_number');
										$fldTracking->setWrapperAttribute('class','div_tracking_number');
										echo $frm->getFormHtml();?>                                         
                                     </div>
									 <?php }?>
                                     <span class="gap"></span>
									 <?php if(!empty($orderDetail['comments'])){?>
                                     <div class="section--repeated no-print">
                                         <h5><?php echo Labels::getLabel('LBL_Posted_Comments',$siteLangId);?></h5>                                         <table class="table align--left">
                                            <tbody><tr class="">
                                                <th><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></th>
                                                <th><?php echo Labels::getLabel('LBL_Customer_Notified',$siteLangId);?></th>
                                                <th><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></th>
                                                <th><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></th>
                                            </tr>
											<?php 											
											foreach($orderDetail['comments'] as $row){?>
                                            <tr>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Date_Added',$siteLangId);?></span><?php echo FatDate::format($row['oshistory_date_added'],true);?></td>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Customer_Notified',$siteLangId);?></span><?php echo $yesNoArr[$row['oshistory_customer_notified']];?></td>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Status',$siteLangId);?></span><?php echo $orderStatuses[$row['oshistory_orderstatus_id']]; echo ($row['oshistory_tracking_number'])? ': '.Labels::getLabel('LBL_Tracking_Number',$siteLangId).' '.$row['oshistory_tracking_number']." VIA <em>".$row['op_shipping_duration_name']."</em>" :''?></td>
                                                <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Comments',$siteLangId);?></span> <?php echo !empty($row['oshistory_comments']) ? nl2br($row['oshistory_comments']) : Labels::getLabel('LBL_NA' , $siteLangId);?></td>
                                              </tr>
											  <?php } ?>											  
											</tbody></table>
                                    </div>
									<?php }?>
									 <span class="gap"></span>
									<?php if( !empty( $digitalDownloads ) ){ ?>
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
													
													$fileName = '<a href="'.CommonHelper::generateUrl('Seller','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'],AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)).'">'.$row['afile_name'].'</a>';
													$downloads = '<li><a href="'.CommonHelper::generateUrl('Seller','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'],AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)).'"><i class="fa fa-download"></i></a></li>';
													
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
											  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Action',$siteLangId);?></span><ul class="actions"><?php echo $downloads;?></ul></td>                          
											</tr>
											<?php $sr_no++; } ?>
										  </tbody>
										</table>
									  </div>
									  <?php } ?>
									  
									<span class="gap"></span>
									<?php if( !empty( $digitalDownloadLinks ) ){ ?>
									  <div class="section--repeated">
										<h5><?php echo Labels::getLabel('LBL_Downloads',$siteLangId);?></h5>
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
													
													/* $fileName = '<a href="'.CommonHelper::generateUrl('Seller','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'],AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)).'">'.$row['afile_name'].'</a>'; */
													/* $downloads = '<li><a href="'.CommonHelper::generateUrl('Seller','downloadDigitalFile',array($row['afile_id'],$row['afile_record_id'],AttachedFile::FILETYPE_ORDER_PRODUCT_DIGITAL_DOWNLOAD)).'"><i class="fa fa-download"></i></a></li>'; */
													
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
											  <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Link',$siteLangId);?></span><a target="_blank" href="<?php echo $row['opddl_downloadable_link'];?>" title="<?php echo Labels::getLabel('LBL_Click_to_download',$siteLangId);?>"><?php echo $row['opddl_downloadable_link'];?></a></td>
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