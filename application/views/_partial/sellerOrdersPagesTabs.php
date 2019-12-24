<div class="row justify-content-between align-items-center">
       
    <div class="col-auto">
        <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_My_Sales', $siteLangId); ?></h2> 
        <div class="tabs tabs--small clearfix">
            <ul>
                <li class="<?php echo ($controllerName == 'seller' && $action == 'sales') ? 'is-active' : ''; ?>">
                    <a href="<?php echo CommonHelper::generateUrl('seller', 'sales');?>">
                        <?php echo Labels::getLabel('LBL_Sold_Items', $siteLangId); ?>
                    </a>
                </li>
                <li class="<?php echo ($controllerName == 'sellerorders' && $action == 'rentals') ? 'is-active' : ''; ?>">
                    <a href="<?php echo CommonHelper::generateUrl('sellerOrders', 'rentals');?>">
                        <?php echo Labels::getLabel('LBL_Rental_Items', $siteLangId); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
