<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $variables= array('language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false); ?>
<div class="tabs__content">
    <div class="form__content row">
        <div class="col-lg-8 col-md-8 mb-3">
            <div class="row">
                <div class="col-md-10"><h5 class="cards-title"><?php echo Labels::getLabel('LBL_Shop_Collections', $siteLangId); ?></h5></div>
                <div class="col-md-2">
                    <div class="action">
                        <a href="javascript:void(0)" onClick="getShopCollectionGeneralForm(0)" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_Add_Collection', $siteLangId);?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="" id="shopFormChildBlock"></div>
        </div>
    </div>
</div>
