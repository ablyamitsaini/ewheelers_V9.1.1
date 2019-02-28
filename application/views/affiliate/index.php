<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/affiliate/affiliateDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
  <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-auto ">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Affiliate' , $siteLangId); ?></h2>
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
									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#my-sales" href="
									<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#my-sales"></use>
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
						<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_Revenue',$siteLangId);?></h5>
					</div>
					<div class="cards-content p-3">
						<div class="stats">
							<i class="icn"><svg class="svg">
									<use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#credits" href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.svg#Credits"></use>
								</svg></i>

							<div class="stats-number">
								<h6 class="total"><?php echo Labels::getLabel('LBL_Total_Revenue',$siteLangId);?></h6>
								<?php echo CommonHelper::displayMoneyFormat($userRevenue);?>
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
						<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Information',$siteLangId);?></h5>
						<div class="action">
							<a href="<?php echo CommonHelper::generateUrl('account','profileInfo');?>" class="link"><?php echo Labels::getLabel('LBL_Edit',$siteLangId);?>  <i class="fa fa-pencil"></i></a>
						</div>
					</div>
					<div class="cards-content p-3">
						<div class="tabs tabs--small   tabs--scroll clearfix setactive-js">
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
</main>