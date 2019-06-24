<div class="tabs tabs--small clearfix">
    <ul>
        <li class="<?php echo ($controllerName == 'seller' && $action == 'catalog') ? 'is-active' : ''; ?>">
            <a href="<?php echo CommonHelper::generateUrl('seller', 'catalog');?>">
                <?php echo Labels::getLabel('LBL_Marketplace_Products', $siteLangId); ?>
            </a>
            <a href="javascript:void(0)" onClick="productInstructions(<?php echo Extrapage::MARKETPLACE_PRODUCT_INSTRUCTIONS; ?>)"> <i class="fa fa-question-circle"></i></a>
        </li>
        <li class="<?php echo ($controllerName == 'seller' && $action == 'products') ? 'is-active' : ''; ?>">
            <a href="<?php echo CommonHelper::generateUrl('seller', 'products');?>">
                <?php echo Labels::getLabel('LBL_My_Inventory', $siteLangId); ?>
            </a>
            <a href="javascript:void(0)" onClick="productInstructions(<?php echo Extrapage::SELLER_INVENTORY_INSTRUCTIONS; ?>)"> <i class="fa fa-question-circle"></i></a>
        </li>
        <?php if (User::canAddCustomProductAvailableToAllSellers()) {?>
            <li class="<?php echo ($controllerName == 'seller' && $action == 'customCatalogProducts') ? 'is-active' : '';?>">
                <a href="<?php echo CommonHelper::generateUrl('seller', 'customCatalogProducts'); ?>">
                    <?php echo Labels::getLabel('LBL_Send_Products_Request', $siteLangId); ?>
                </a>
                <a href="javascript:void(0)" onClick="productInstructions(<?php echo Extrapage::PRODUCT_REQUEST_INSTRUCTIONS; ?>)"> <i class="fa fa-question-circle"></i></a>
            </li>
        <?php } ?>
    </ul>
</div>
