<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $variables= array('language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false); ?>
<div class="tabs__content">
    <div class="row row" id="shopFormChildBlock"></div>
</div>
