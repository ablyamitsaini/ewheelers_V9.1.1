<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<tr>
    <td>
        <?php echo $post['product_name']; ?>
    </td>
    <td>
        <?php echo date('Y-m-d', strtotime($post['splprice_start_date'])); ?>
    </td>
    <td>
        <?php echo date('Y-m-d', strtotime($post['splprice_end_date'])); ?>
    </td>
    <td>
        <?php echo CommonHelper::displayMoneyFormat($post['splprice_price']); ?>
    </td>
    <td>
        <ul class="actions">
            <li><a title="Edit" href="javascript:void(0);" onclick="edit($(this), <?php echo $insertId; ?>, <?php echo $post['splprice_selprod_id']; ?>)"><i class="ion-edit"></i></a></li>
            <?php if (1 > $edit) { ?>
                <li><a title="Remove" href="javascript:void(0);" onclick="remove($(this), <?php echo $insertId; ?>, <?php echo $post['splprice_selprod_id']; ?>)"><i class="ion-close-round"></i></a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
