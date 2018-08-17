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
							<h2><?php echo Labels::getLabel('LBL_MY_Saved_Searches',$siteLangId);?></h2>
						</div>					   
						<div class="panel__body">                            
							<div class="box box--white box--space">
								<div class="box__head"><h4><?php echo Labels::getLabel('LBL_Saved_Searches',$siteLangId);?></h4></div>
								<div class="box__body">
									<div class="" id="SearchesListingDiv"></div>
								</div>
								<div class="gap"></div>
								<div id="loadMoreBtnDiv"></div>
							</div>
						</div>  
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>