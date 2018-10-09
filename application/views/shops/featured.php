<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body bg--gray">
	<div class="section section--pagebar">
      <div class="container container--fixed">
        <h4><?php echo Labels::getLabel('Lbl_Featured_Shops' , $siteLangId); ?></h4>
      </div>
    </div>
	<section class="dashboard">
		<div class="container">
			<div class="box box--white box--space">
			   <div class="row">           
					<div class="panel panel--centered clearfix">
						<div class="container container--fluid">
							<div class="section section--info clearfix">                         
								<div class="section__body">
									<div id="listing">
										 
									</div>
									<span class="gap"></span>
									<div id="loadMoreBtnDiv"></div>
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
<?php echo $searchForm->getFormHtml();?>