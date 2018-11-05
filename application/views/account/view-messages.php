<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> 						   
				<div class="col-xs-10 panel__right--full ">
				   <div class="cols--group">
					   <div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></h2>						   
					   </div>					   
					   <div class="panel__body">                            
						 <div class="box box--white box--space">
							   <div class="box__head">
								   <h4><?php echo Labels::getLabel('LBL_Messages',$siteLangId);?></h4>
								   <div class="group--btns"><a href="<?php echo CommonHelper::generateUrl('Account','messages');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Back_to_messages',$siteLangId);?></a></div>
							   </div>
							   <div class="box__body">                                     
								 <table class="table table--orders">
									   <tbody>
										<tr class="">
										   <th><?php echo Labels::getLabel('LBL_Date',$siteLangId);?></th>
										   <th><?php echo $threadTypeArr[$threadDetails['thread_type']];?></th>
										   <th><?php echo Labels::getLabel('LBL_Subject',$siteLangId);?></th>
										   <th><?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
												echo Labels::getLabel('LBL_Amount',$siteLangId); 
											}  elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT) { 
												echo Labels::getLabel('LBL_Price',$siteLangId);
											}?></th>
											<th>
												<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT){
													echo Labels::getLabel('LBL_Status',$siteLangId) ; 
												} ?>
											</th>
									   </tr>
									   <tr>
										   <td><span class="caption--td"><?php echo Labels::getLabel('LBL_Date',$siteLangId);?></span><?php echo FatDate::format($threadDetails["thread_start_date"],false);?>
										   </td>
											<td>
												<span class="caption--td"><?php echo $threadTypeArr[$threadDetails['thread_type']];?></span>
												<div class="item__description">
													<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT){?>
														<span class="item__title"><?php echo $threadDetails["op_invoice_number"];?></span>
													<?php }else if($threadDetails["thread_type"] == THREAD::THREAD_TYPE_SHOP){?>
														<span class="item__title"><?php echo $threadDetails["shop_name"];?></span>
													<?php }else if($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT){?>
														<span class="item__title"><?php echo $threadDetails["selprod_title"];?></span>
													<?php }?>
												</div>
											</td>
											<td><span class="caption--td"><?php echo Labels::getLabel('LBL_Subject',$siteLangId);?></span><?php echo $threadDetails["thread_subject"];?>
											</td>
											<td>
												<span class="caption--td">
													<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT) {
														echo Labels::getLabel('LBL_Amount',$siteLangId); 
													}  elseif ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT) { 
														echo Labels::getLabel('LBL_Price',$siteLangId);
													}?>
												</span> 
												<span class="item__price">
													<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT){?>
													
													<?php }else if($threadDetails["thread_type"] == THREAD::THREAD_TYPE_SHOP){?>
														
													<?php }else if($threadDetails["thread_type"] == THREAD::THREAD_TYPE_PRODUCT){?>
															<p><?php echo $threadDetails['selprod_price']; ?></p>
													<?php }?>
												</span>
											</td>
											<td>
												<span class="caption--td">
												<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT){
													echo Labels::getLabel('LBL_Status',$siteLangId) ; 
												} ?>
												</span>
												<?php if ($threadDetails["thread_type"] == THREAD::THREAD_TYPE_ORDER_PRODUCT){?>
												<?php echo $threadDetails["orders_status_name"]?>
												<?php }?>
											</td>
										</tr>
								   </tbody></table>
								 
									<?php echo $frmSrch->getFormHtml();?>
									<div id="loadMoreBtnDiv"></div>
									<ul class="media media--details" id="messageListing">
										
									</ul>
									<ul class="media media--details" >  
									   <li>
										   <div class="grid grid--first">
											   <div class="avtar"><img src="<?php echo CommonHelper::generateUrl('Image','user',array($loggedUserId,'thumb',true));?>" alt="<?php echo $loggedUserName; ?>"></div>
										   </div>
										   <div class="grid grid--second">
											   <span class="media__title"><?php echo $loggedUserName;?></span>
										   </div>
										   <div class="grid grid--third">
											   <div class="form__cover">
													<?php 
													$frm->setFormTagAttribute('onSubmit','sendMessage(this); return false;');
													$frm->setFormTagAttribute('class', 'form'); 
													$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
													$frm->developerTags['fld_default_col'] = 12;
													echo $frm->getFormHtml(); ?>
											   </div>
										   </div>
									   </li>
								   </ul>
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