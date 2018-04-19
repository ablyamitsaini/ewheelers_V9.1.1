<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?> 
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> 						   
				<div class="col-md-10 panel__right--full">
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_Products_Performance_Report',$siteLangId);?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head">
									<h4><?php echo Labels::getLabel('LBL_Products_Performance_Report',$siteLangId);?></h4>
									<div class="group--btns">
										<a href="javascript:void(0)" id="performanceReportExport" onclick="exportProdPerformanceReport('DESC')" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Export',$siteLangId);?></a>
									</div>
								</div>
								<div class="box__body">
									<div class="tabs tabs--small tabs--offset tabs--scroll clearfix setactive-js">
										<ul>
											<li class="is-active"><a href="javascript:void(0);" onClick="topPerformingProducts()"><?php echo Labels::getLabel('LBL_Top_Performing_Products',$siteLangId);?></a></li>
											<li><a href="javascript:void(0);" onClick="badPerformingProducts()"><?php echo Labels::getLabel('LBL_Bad_Performing_Products',$siteLangId);?></a></li>
											<li><a href="javascript:void(0);" onClick="mostWishListAddedProducts()"><?php echo Labels::getLabel('LBL_Most_WishList_Added_Products',$siteLangId);?></a></li>
										</ul>
									</div>
									<div class="grids--profile">
										<?php echo $srchFrm->getFormHtml(); ?>
										<div class="grid" >
											<div class="row">
												<div class="col-md-12" id="listingDiv">
													<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
												</div>
											</div>
										</div>
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