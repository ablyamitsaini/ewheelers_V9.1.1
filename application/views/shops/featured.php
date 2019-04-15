<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	<section class="section">
		<div class="container">
			<div class="section-head">
			 <div class="section__heading"><h2><?php echo Labels::getLabel('Lbl_Featured_Shops' , $siteLangId); ?></h2></div>
			</div>
			<div id="listing"> </div>
			<div id="loadMoreBtnDiv"></div>
		</div>
	</section>
</div>
<?php echo $searchForm->getFormHtml();?>
