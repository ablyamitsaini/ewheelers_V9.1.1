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
							<h2><?php echo Labels::getLabel('LBL_My_Downloads', $siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
									<h5><?php echo Labels::getLabel('LBL_My_Downloads', $siteLangId); ?></h5>
								</div>
								<div class="box__body">
									<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
										<ul>
											<li class="is-active"><a href="javascript:void(0);" onclick="searchBuyerDownloads()"><?php echo Labels::getLabel('LBL_Downloadable_Files', $siteLangId); ?></a></li>
											<li><a href="javascript:void(0);" onclick="searchBuyerDownloadLinks()"><?php echo Labels::getLabel('LBL_Downloadable_Links', $siteLangId); ?></a></li>
										</ul>
									</div>
									<div id="listing"></div>
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