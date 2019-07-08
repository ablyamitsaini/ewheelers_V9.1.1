<?php defined('SYSTEM_INIT') or die('Invalid Usage');?>
<?php $banner = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '', $siteLangId); ?>
<?php if ($banner) { ?>
 <section class="bg-shop">
        <div class="shop-banner" style="background-image: url(<?php echo CommonHelper::generateUrl('image', 'shopBanner', array($banner['afile_record_id'], $siteLangId, 'TEMP1', $banner['afile_id'])); ?>)" data-ratio="4:1">
        </div>
   </section>

<?php } ?>
<section class="bg--second">
    <div class="container">
        <div class="shop-nav">
            <?php
            $variables= array('template_id'=>$template_id, 'shop_id'=>$shop['shop_id'],'collectionData'=>$collectionData,'action'=>$action,'siteLangId'=>$siteLangId);
            $this->includeTemplate('shops/shop-layout-navigation.php', $variables, false); ?>
        </div>
    </div>
</section>
