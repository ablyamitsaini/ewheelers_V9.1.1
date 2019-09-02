<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<tr id='row-<?php echo $splPriceId; ?>'>
    <td>
        <label class="checkbox">
            <input class="selectItem--js" type="checkbox" name="selprod_ids[<?php echo $splPriceId; ?>]" value="<?php echo $data['splprice_selprod_id']; ?>"><i class="input-helper"></i></label>
    </td>
    <td>
        <?php echo html_entity_decode($data['product_name']); ?>
    </td>
    <td>
        <?php $startDate = date('Y-m-d', strtotime($data['splprice_start_date'])); ?>
        <div class="js--editCol edit-hover"><?php echo $startDate; ?></div>
        <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $startDate; ?>" data-selprodid="<?php echo $data['splprice_selprod_id']; ?>" name="splprice_start_date" class="js--splPriceCol hide sp-input" data-val="<?php echo $startDate; ?>"/>
    </td>
    <td>
        <?php $endDate = date('Y-m-d', strtotime($data['splprice_end_date'])); ?>
        <div class="js--editCol edit-hover"><?php echo $endDate; ?></div>
        <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $endDate; ?>" data-selprodid="<?php echo $data['splprice_selprod_id']; ?>" name="splprice_end_date" class="js--splPriceCol hide sp-input" data-val="<?php echo $endDate; ?>"/>
    </td>
    <td>
        <?php echo CommonHelper::displayMoneyFormat($data['splprice_price']); ?>
        <input type="text" data-id="<?php echo $splPriceId; ?>" value="<?php echo $data['splprice_price']; ?>" data-selprodid="<?php echo $data['splprice_selprod_id']; ?>" name="splprice_price" class="js--splPriceCol hide sp-input" data-val="<?php echo $data['splprice_price']; ?>"/>
    </td>
    <td>
        <ul class="actions">
            <li>
                <a title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>" href="javascript:void(0);" onclick="deleteSellerProductSpecialPrice(<?php echo $splPriceId; ?>)">
                    <i class="fa fa-trash"></i>
                </a>
            </li>
        </ul>
    </td>
</tr>
