<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body bg--gray">
	<div class="section section--pagebar">
      <div class="container container--fixed">
        <h4><?php echo $collection['collection_name']; ?></h4>
      </div>
    </div>
	<section class="dashboard">
		<div class="container">
			<div class="box box--white box--space">

					<div id="listing">
					</div>
					<span class="gap"></span>
					<div id="loadMoreBtnDiv"></div>


			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<?php echo $searchForm->getFormHtml();?>
