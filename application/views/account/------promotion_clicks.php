<?php defined('SYSTEM_INIT') or die('Invalid Usage'); $prm_budget_dur_arr = Promotion::getPromotionBudgetDurationArr($siteLangId);  ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_My_Promotion_Clicks',$siteLangId) ?></h2>
							<div class="padding20 fr">  <a href="<?php echo CommonHelper::generateUrl('account', 'promote')?>" class="btn small blue"><?php echo Labels::getLabel('LBL_Back_To_Promotions',$siteLangId) ?></a> </div>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__body">
								  <?php if (!empty($arr_listing) && is_array($arr_listing)):?>
								  <div class="darkgray-form clearfix">
									<div class="left-txt"> <?php echo sprintf(Labels::getLabel('LBL_L_Items_x_to_y_of_z_total',$siteLangId),$start_record,$end_record,$total_records)?> </div>
								  </div>
								  <div class="tbl-listing">
									<table>
									  <tr>
										<th><?php echo Labels::getLabel('LBL_SN',$siteLangId) ?></th>
										<th><?php echo Labels::getLabel('LBL_IP_Address',$siteLangId) ?></th>
										<th><?php echo Labels::getLabel('LBL_Date',$siteLangId) ?></th>
										<th><?php echo Labels::getLabel('LBL_CPC',$siteLangId) ?></th>
									  </tr>
									  <?php $cnt=0; foreach ($arr_listing as $sn=>$row): $cnt++; $sn=($page-1)*$pagesize+$cnt;   ?>
									  <tr>
										<td><span class="cellcaption"><?php echo Labels::getLabel('LBL_SN',$siteLangId) ?></span> <?php echo $sn; ?></td>
										<td><span class="cellcaption"><?php echo Labels::getLabel('LBL_IP_Address',$siteLangId) ?></span> <?php echo $row["pclick_ip"] ?></td>
										<td><span class="cellcaption"><?php echo Labels::getLabel('LBL_Date',$siteLangId) ?></span> <?php echo displayDate($row["pclick_datetime"],true) ?></td>
										<td><span class="cellcaption"><?php echo Labels::getLabel('LBL_CPC',$siteLangId) ?></span> <?php echo Utilities::displayMoneyFormat($row["pclick_cost"]) ?></td>
									  </tr> 
									  <?php endforeach;?>
									</table>
									<?php if ($pages>1):?>
									<div class="pager">
									  <ul>
									  <?php echo getPageString('<li><a href="javascript:void(0)" onclick="listPages(xxpagexx);">xxpagexx</a></li>', $pages, $page,'<li class="active"><a  href="javascript:void(0)">xxpagexx</a></li>', '<li>...</li>');?>
									  </ul>
									</div>
									<?php endif;?>
								  </div>
								  <?php else:?>    
										<div class="space-lft-right">
											<div class="notification informationfullwidth">
												<p><strong><?php echo Labels::getLabel('LBL_Information',$siteLangId) ?></strong><br/>
												<?php echo Labels::getLabel('LBL_Unable_To_Find_Any_Record',$siteLangId) ?></p>
											</div>
										</div>
								  <?php endif;?>
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
