<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				 <div class="section__heading"><?php echo Labels::getLabel('Lbl_All_Shops' , $siteLangId); ?></div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
	 			<div id="listing"> </div>
			<div id="loadMoreBtnDiv"></div>
		</div>
	</section>
</div>
<?php echo $searchForm->getFormHtml();?>
