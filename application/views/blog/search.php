<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if(isset($keyword)) { ?>
	<section class="">
		<div class="query-container">
			<div class="container">
				<h3 class="query-heading"><?php echo Labels::getLabel('LBL_Search_For',$siteLangId); ?></h3>
				<input class="query no--focus" id="search-keyword-js" placeholder="<?php echo $keyword ?>" value="<?php echo $keyword ?>" type="search">
			</div>
		</div>
	</section>	
<?php } ?>
<div id="blogs-listing-js"></div>

<script type="text/javascript">
	var keyword = '<?php echo $keyword; ?>';
</script>