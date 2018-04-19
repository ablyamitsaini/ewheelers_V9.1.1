<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/blogTopFeaturedCategories.php');
?>
<div id="body" class="body bg--grey">
	<div class="fixed-container">
		<div class="row">
		   <div class="panel">
			   <div class="colums clearfix">
				   <div class="col-md-3 colums__right">
				   <?php $this->includeTemplate('_partial/blogSidePanel.php'); ?>
				   </div>
					<div class="col-md-9 colums__left">
						<div class="posts--all" id='listing'>
						</div>
					</div>
					<div class="col-md-3 colums__right">
						<div class="wrapper--adds" >
							<div class="grids" id="div--banners">
							</div>
						</div>
					</div>
			   </div>
		   </div>
		</div>
	</div>
	<div class="gap"></div>
</div>
	<script>
	var bpCategoryId = <?php echo !empty($bpCategoryId) ? $bpCategoryId : 0; ?>;
	</script>
	<?php $this->includeTemplate( '_partial/shareThisScript.php' );?>
</div>