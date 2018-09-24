<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $this->includeTemplate('_partial/blogTopFeaturedCategories.php'); */
?>
<div class="posts--all" id='listing'></div>
<script>
	var bpCategoryId = <?php echo !empty($bpCategoryId) ? $bpCategoryId : 0; ?>;
	var keyword = '<?php echo !empty($keyword) ? $keyword : ''; ?>';
</script>
<?php $this->includeTemplate( '_partial/shareThisScript.php' );?>
