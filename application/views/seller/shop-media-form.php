<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $shopLogoFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopLogoFrm->setFormTagAttribute('class', 'form');
    $shopLogoFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopLogoFrm->developerTags['fld_default_col'] = 12;
    $fld = $shopLogoFrm->getField('shop_logo');
    $fld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');
    $shopBannerFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopBannerFrm->setFormTagAttribute('class', 'form');
    $shopBannerFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopBannerFrm->developerTags['fld_default_col'] = 12;
    $fld = $shopBannerFrm->getField('shop_banner');
    $fld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');
    $shopBackgroundImageFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
    $shopBackgroundImageFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopBackgroundImageFrm->developerTags['fld_default_col'] = 12;
    $fld = $shopBackgroundImageFrm->getField('shop_background_image');
    $fld->addFieldTagAttribute('class', 'btn btn--primary btn--sm');
    // $bannerSize = applicationConstants::getShopBannerSize();
    // $shopLayout= ($shopDetails['shop_ltemplate_id'])?$shopDetails['shop_ltemplate_id']:SHOP::TEMPLATE_ONE;
    $shopLayout= SHOP::TEMPLATE_ONE;
?>
<?php $variables= array( 'language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false); ?>
<div class="cards">
    <div class="cards-content pt-4 pl-4 pr-4 ">
        <div class="tabs__content">
            <div class="row" id="shopFormBlock">
                <div id="mediaResponse"></div>
                <div class="col-md-6">
                    <div class="preview">
                      <small class="text--small"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_banner_text', $siteLangId), '2000*500')?></small>
                        <?php echo $shopBannerFrm->getFormHtml();?>
                        <div id="banner-image-listing" class="row"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="preview">
                        <small class="text--small"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_logo_text', $siteLangId), '150*150')?></small>
                        <?php echo $shopLogoFrm->getFormHtml();?>
                           <div id="logo-image-listing" class="row" ></div>
                    </div>
                </div>
                <?php /* <div class="col-md-4">    <div class="preview">
                        <small class="text--small"><?php echo sprintf(Labels::getLabel('MSG_Upload_shop_background_text',$siteLangId),'60*60')?></small>
                        <?php echo $shopBackgroundImageFrm->getFormHtml();?>
                            <div id="bg-image-listing" class="row"></div>
                    </div></div> */ ?>
            </div>
        </div>
    </div>
</div>
