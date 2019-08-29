<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<tr id='row-<?php echo $splPriceId; ?>'>
    <td>
        <label class="checkbox">
            <input class="selectItem--js" type="checkbox" name="selprod_ids[<?php echo $splPriceId; ?>]" value="<?php echo $post['splprice_selprod_id']; ?>"><i class="input-helper"></i></label>
    </td>
    <td>
        <?php echo html_entity_decode($post['product_name']); ?>
    </td>
    <td>
       <div class="js--editCol edit-hover"><?php echo FatDate::format($post['splprice_start_date'], false); ?></div>
       <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $post['splprice_start_date']; ?>" data-selprodid="<?php echo $post['splprice_selprod_id']; ?>" name="splprice_start_date" class="js--splPriceCol hide sp-input" data-val="<?php echo $post['splprice_start_date']; ?>"/>
    </td>
    <td>
       <div class="js--editCol edit-hover"><?php echo FatDate::format($post['splprice_end_date'], false); ?></div>
       <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $post['splprice_end_date']; ?>" data-selprodid="<?php echo $post['splprice_selprod_id']; ?>" name="splprice_end_date" class="js--splPriceCol hide sp-input" data-val="<?php echo $post['splprice_end_date']; ?>"/>
    </td>
    <td>
        <?php echo CommonHelper::displayMoneyFormat($post['splprice_price']); ?>
        <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $post['splprice_price']; ?>" data-selprodid="<?php echo $post['splprice_selprod_id']; ?>" name="splprice_price" class="js--splPriceCol hide sp-input" data-val="<?php echo $post['splprice_price']; ?>"/>
    </td>
    <td>
        <ul class="actions actions--centered">
            <li class="droplink">
                <a href="javascript:void(0)" class="button small green" title="<?php echo Labels::getLabel('LBL_Edit', $adminLangId); ?>">
                    <i class="ion-android-more-horizontal icon"></i>
                </a>
                <div class="dropwrap">
                    <ul class="linksvertical">
                        <li>
                            <a href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_Remove', $adminLangId); ?>" onclick="deleteSellerProductSpecialPrice(<?php echo $splPriceId; ?>)"><?php echo Labels::getLabel('LBL_Remove', $adminLangId); ?></a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </td>
</tr>
