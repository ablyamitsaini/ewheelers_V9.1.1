<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body bg--gray">
    <section class="section section--pagebar">
		<div class="container">
			<div class="section-head justify-content-center mb-0">
				<div class="section__heading">
					<h2 class="mb-0"><?php echo $collection['collection_name']; ?></h2>
				</div>
			</div>
		</div>
	</section>
	<section class="top-space">
		<div class="container">
			<div id="listing"></div>
            <span class="gap"></span>
            <div id="loadMoreBtnDiv"></div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<?php echo $searchForm->getFormHtml();?>
