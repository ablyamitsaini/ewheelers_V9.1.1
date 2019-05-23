<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $variables= array('language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false); ?>
<div class="tabs__content">
    <div class="form__content row">
        <div class="col-lg-10 col-md-10 mb-3">
            <div class="content-header justify-content-between row mb-4">
                <div class="content-header-left col-md-auto"><h5 class="cards-title"><?php echo Labels::getLabel('LBL_Shop_Collections', $siteLangId); ?></h5></div>
                <div class="content-header-right col-auto">
                    <div class="form__group">
                        <a href="javascript:void(0)" onClick="toggleBulkCollectionStatues(1)" class="btn btn--primary"><?php echo Labels::getLabel('LBL_Make_Active', $siteLangId);?></a>
                        <a href="javascript:void(0)" onClick="toggleBulkCollectionStatues(0)" class="btn btn--primary-border"><?php echo Labels::getLabel('LBL_Make_InActive', $siteLangId);?></a>
                        <a href="javascript:void(0)" onClick="getShopCollectionGeneralForm(0)" class="btn btn--primary"><?php echo Labels::getLabel('LBL_Add_Collection', $siteLangId);?></a>
                        <a href="javascript:void(0)" onClick="deleteSelectedCollection()" class="btn btn--primary-border"><?php echo Labels::getLabel('LBL_Delete_selected', $siteLangId);?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-10">
            <div class="" id="shopFormChildBlock"></div>
        </div>
    </div>
</div>
