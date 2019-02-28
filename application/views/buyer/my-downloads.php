<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/buyerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header justify-content-between row mb-3">
		<div class="content-header-left col-auto ">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_My_Downloads', $siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header">
				<h5 class="cards-title p-3"><?php echo Labels::getLabel('LBL_My_Downloads', $siteLangId); ?></h5>
			</div>
			<div class="cards-content p-3">
				<div class="tabs tabs--small   tabs--scroll clearfix">
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
</main>