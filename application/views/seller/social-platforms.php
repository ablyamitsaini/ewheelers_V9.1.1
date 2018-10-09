<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>                      
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Seller',$siteLangId); ?></h2>							   
						</div>
						<div class="panel__body">
							<div class="box box--white box--space" id="listing">
								<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>