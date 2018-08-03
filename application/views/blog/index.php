<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
?>
<div id="body" class="body bg--grey">
	<div class="container--fluid">
		<div class="gap"></div>
		<div class="posts--all" id='listing'></div>
	</div>
	<div class="gap"></div>
</div>
	<script>
	var bpCategoryId = <?php echo !empty($bpCategoryId) ? $bpCategoryId : 0; ?>;
	</script>
	<?php $this->includeTemplate( '_partial/shareThisScript.php' );?>
</div>
