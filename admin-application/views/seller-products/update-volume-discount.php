<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<tr id="row-<?php echo $insertId; ?>">
    <td>
        <label class="checkbox">
            <input class="selectItem--js" type="checkbox" name="selprod_ids[<?php echo $insertId; ?>]" value="<?php echo $post['voldiscount_selprod_id']; ?>"><i class="input-helper"></i></label>
    </td>
    <td>
        <?php echo html_entity_decode($post['product_name']); ?>
    </td>
    <td>
        <div class="js--editCol edit-hover"><?php echo $post['voldiscount_min_qty']; ?></div>
        <input type="text" data-id="<?php echo $insertId; ?>" value="<?php echo $post['voldiscount_min_qty']; ?>" data-selprodid="<?php echo $post['voldiscount_selprod_id']; ?>" name="voldiscount_min_qty" class="js--volDiscountCol hide vd-input" data-val="<?php echo $post['voldiscount_min_qty']; ?>"/>
    </td>
    <td>
        <div class="js--editCol edit-hover"><?php echo number_format((float)$post['voldiscount_percentage'], 2, '.', ''); ?></div>
        <input type="text" data-id="<?php echo $insertId; ?>" value="<?php echo $post['voldiscount_percentage']; ?>" data-selprodid="<?php echo $post['voldiscount_selprod_id']; ?>" name="voldiscount_percentage" class="js--volDiscountCol hide vd-input" data-val="<?php echo $post['voldiscount_percentage']; ?>"/>
    </td>
    <td>
        <ul class="actions actions--centered">
            <li class="droplink">
                <a href="javascript:void(0)" class="button small green" title="Edit">
                    <i class="ion-android-more-horizontal icon"></i>
                </a>
                <div class="dropwrap">
                    <ul class="linksvertical">
                        <li>
                            <a href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_Remove', $adminLangId); ?>" onclick="deleteSellerProductVolumeDiscount(<?php echo $insertId; ?>)"><?php echo Labels::getLabel('LBL_Remove', $adminLangId); ?></a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </td>
</tr>
