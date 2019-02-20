<?php defined('SYSTEM_INIT') or die('Invalid Usage');?>
<section class="section--gray">
	<div class="container">
		<div class="shop-nav">
			<?php
			$variables= array('template_id'=>$template_id, 'shop_id'=>$shop['shop_id'],'collectionData'=>$collectionData,'action'=>$action,'siteLangId'=>$siteLangId);
			$this->includeTemplate('shops/shop-layout-navigation.php',$variables,false);  ?>
		</div>
	</div>
</section>
<script>
$currentPageUrl = '<?php echo CommonHelper::generateFullUrl('Shops','view',array($shopId)); ?>';
</script>
