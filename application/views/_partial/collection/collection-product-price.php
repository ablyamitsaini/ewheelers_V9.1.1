  <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>
                  <?php if($product['special_price_found']){ ?>
                  <span class="product_price_old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
                  <div class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></div>
                  <?php } ?>
				  <?php if($product['selprod_sold_count']>0){?>
	<span class="product_price_sold"><?php echo $product['selprod_sold_count'];?> <?php echo Labels::getLabel('LBL_Sold',$siteLangId);?></span> 
	<?php }?>
                </div>