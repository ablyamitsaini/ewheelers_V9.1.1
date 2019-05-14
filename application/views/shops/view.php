<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$bgUrl = CommonHelper::generateFullUrl('Image', 'shopBackgroundImage', array($shop['shop_id'], $siteLangId, 0, 0, $template_id)); ?>
<div id="body" class="body template-<?php echo $template_id;?>" role="main">
    <?php
        $shopData = array_merge($data, array( 'template_id'=>$template_id,'collectionData'=>$collectionData,'action'=>$action,'shopTotalReviews'=>$shopTotalReviews,'shopRating'=>$shopRating));
        $this->includeTemplate('shops/templates/'.$template_id.'.php', $shopData, false);
    ?>
<?php echo $this->includeTemplate('products/listing-page.php', $shopData, false); ?>
