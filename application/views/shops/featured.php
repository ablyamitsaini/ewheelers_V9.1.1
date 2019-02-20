<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
	<section class="section">
		<div class="container">
			<div class="section-head">
			 <div class="section__heading"><?php echo Labels::getLabel('Lbl_Featured_Shops' , $siteLangId); ?></div>
			</div>
			<div  id="listing" class="box "> </div>
			<div id="loadMoreBtnDiv"></div>
		</div>
	</section>
</div>
<?php echo $searchForm->getFormHtml();?>