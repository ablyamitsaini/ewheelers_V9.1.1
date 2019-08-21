<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<tr id="row-<?php echo $insertId; ?>">
    <?php if (0 < $selector) { ?>
        <td>
            <label class="checkbox">
                <input class="selectItem--js" type="checkbox" name="selprod_ids[<?php echo $insertId; ?>]" value="<?php echo $post['voldiscount_selprod_id']; ?>"><i class="input-helper"></i></label>
        </td>
    <?php } ?>
    <td>
        <?php echo html_entity_decode($post['product_name']); ?>
    </td>
    <td>
        <?php echo $post['voldiscount_min_qty']; ?>
    </td>
    <td>
        <?php echo number_format((float)$post['voldiscount_percentage'], 2, '.', ''); ?>
    </td>
    <td>
        <ul class="actions">
            <?php if (1 > $selector) { ?>
                <li><a title="Edit" href="javascript:void(0);" onclick="edit($(this), <?php echo $insertId; ?>, <?php echo $post['voldiscount_selprod_id']; ?>)"><i class="ion-edit"></i></a></li>
            <?php } if (1 > $edit) { ?>
                <li><a title="Delete" href="javascript:void(0);" onclick="deleteSellerProductVolumeDiscount(<?php echo $insertId; ?>, $(this), <?php echo $post['voldiscount_selprod_id']; ?>)"><i class="fa fa-trash"></i></a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
