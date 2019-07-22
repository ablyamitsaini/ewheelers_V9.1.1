<?php defined('SYSTEM_INIT') or die('Invalid Usage');?>
<?php $catBannerArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '', $siteLangId);
$desktop_url = '';
$tablet_url = '';
$mobile_url = '';
foreach ($catBannerArr as $slideScreen) {
    switch ($slideScreen['afile_screen']) {
        case applicationConstants::SCREEN_MOBILE:
            $mobile_url = '<736:' .FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'ORIGINAL', 0, applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg').",";
            break;
        case applicationConstants::SCREEN_IPAD:
            $tablet_url = ' >768:' .FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'ORIGINAL', 0, applicationConstants::SCREEN_IPAD))).",";
            break;
        case applicationConstants::SCREEN_DESKTOP:
            $desktop_url = ' >1025:' .FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'ORIGINAL', 0, applicationConstants::SCREEN_DESKTOP)), CONF_IMG_CACHE_TIME, '.jpg').",";
            break;
    }
} ?>

<?php if (!empty($catBannerArr)) { ?>
<section class="bg-shop">
   <div class="shop-banner">
       <img data-ratio="4:1" data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url . $tablet_url  . $desktop_url; ?>" src="<?php echo CommonHelper::generateUrl('image', 'shopBanner', array($shop['shop_id'],$siteLangId,'ORIGINAL', 0, applicationConstants::SCREEN_DESKTOP)); ?>">
   </div>
</section>
<?php } ?>
<section class="bg--second">
    <div class="container">
        <div class="shop-nav">
            <?php
            $variables= array('template_id'=>$template_id, 'shop_id'=>$shop['shop_id'], 'shop_user_id'=>$shop['shop_user_id'], 'collectionData'=>$collectionData,'action'=>$action,'siteLangId'=>$siteLangId);
            $this->includeTemplate('shops/shop-layout-navigation.php', $variables, false); ?>
        </div>
    </div>
</section>
