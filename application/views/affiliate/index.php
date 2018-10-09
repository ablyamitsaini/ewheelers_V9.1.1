<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/affiliateDashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full ">
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_Affiliate',$siteLangId);?></h2>
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
										<div class="box box--white box--space info--tooltip info--tooltip-js">
											<h4><span><?php echo Labels::getLabel('LBL_Revenue',$siteLangId);?></span></h4>
											<span class="value--total"><?php echo CommonHelper::displayMoneyFormat($userRevenue);?></span>
											<span class="text--normal"><br><strong><?php echo Labels::getLabel('LBL_Total_Revenue',$siteLangId);?></strong></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col__left">
								<div class="box box--white box--space">
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
												<li><a href="javascript:void(0);" onClick="addressInfo(this)"><?php echo Labels::getLabel( 'LBL_Address_Information', $siteLangId ); ?></a></li>
											</ul>
										</div>
										<div class="tabs__content" id="tabListing"><?php echo Labels::getlabel('LBL_loading..',$siteLangId);?></div>
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