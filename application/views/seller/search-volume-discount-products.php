<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$addVolDiscountfrm->setFormTagAttribute('id', 'frmAddVolumeDiscount');
$addVolDiscountfrm->setFormTagAttribute('name', 'frmAddVolumeDiscount');
$addVolDiscountfrm->setFormTagAttribute('onsubmit', 'updateVolumeDiscount(this); return(false);');
$addVolDiscountfrm->addHiddenField('', 'selector', 1);

$arr_flds = array(
    'select_all'=>Labels::getLabel('LBL_Select_all', $siteLangId),
    'product_name' => Labels::getLabel('LBL_Name', $siteLangId),
    'voldiscount_min_qty' => Labels::getLabel('LBL_Minimum_Quantity', $siteLangId),
    'voldiscount_percentage' => Labels::getLabel('LBL_Percentage', $siteLangId),
    'action' => Labels::getLabel('LBL_Action', $siteLangId),
);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive table--hovered volDiscountList-js'));
$thead = $tbl->appendElement('thead');
$th = $thead->appendElement('tr', array('class' => 'hide--mobile'));
$trForm = $thead->appendElement('tr', array());

foreach ($arr_flds as $key => $val) {
    $thForm = $trForm->appendElement('th');
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="'.$val.'" type="checkbox" onclick="selectAll($(this))" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', array(), $val);
        if ('action' != $key) {
            switch ($key) {
                case 'product_name':
                    $productName = $addVolDiscountfrm->getField($key);
                    $productName->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Select_Product', $siteLangId));
                    $thForm->appendElement('plaintext', array(), $addVolDiscountfrm->getFieldHtml($key), true);
                    break;
                case 'voldiscount_min_qty':
                    $minQty = $addVolDiscountfrm->getField($key);
                    $minQty->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Minimum_Quantity', $siteLangId));
                    $thForm->appendElement('plaintext', array(), $addVolDiscountfrm->getFieldHtml($key), true);
                    break;
                case 'voldiscount_percentage':
                    $minQty = $addVolDiscountfrm->getField($key);
                    $minQty->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Add_Discount_Percentage', $siteLangId));
                    $thForm->appendElement('plaintext', array(), $addVolDiscountfrm->getFieldHtml($key), true);
                    break;
                case 'action':
                    /*$btnUpdate = $addVolDiscountfrm->getField('btn_update');
                    $btnUpdate->setFieldTagAttribute('class', 'invisible');
                    $thForm->appendElement('plaintext', array(), $addVolDiscountfrm->getFieldHtml('btn_update'), true);*/
                    break;
            }
        }
    }
}

foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array());

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="selprod_ids['.$row['voldiscount_id'].']" value='.$row['selprod_id'].'><i class="input-helper"></i></label>', true);
                break;
            case 'product_name':
                $variantStr = ($row['selprod_title'] != '') ? $row['selprod_title'].'<br/>' : '';
                if (is_array($row['options']) && count($row['options'])) {
                    foreach ($row['options'] as $op) {
                        $variantStr .= $op['option_name'].': '.$op['optionvalue_name'].'<br/>';
                    }
                }
                $td->appendElement('plaintext', array(), $variantStr, true);
                $td->appendElement('plaintext', array(), $row['product_name'], true);
                break;
            case 'voldiscount_min_qty':
                $td->appendElement('plaintext', array(), "<span class='js--editCol' data-id='".$row['voldiscount_id']."' data-attribute='voldiscount_min_qty' data-selprodid='".$row['selprod_id']."'>".$row[$key]."</span>", true);
                break;
            case 'voldiscount_percentage':
                $td->appendElement('plaintext', array(), "<span class='js--editCol' data-id='".$row['voldiscount_id']."' data-attribute='voldiscount_percentage' data-selprodid='".$row['selprod_id']."'>".$row[$key]."</span>%", true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class"=>"actions actions--centered"), '', true);
                $li = $ul->appendElement('li');
                $li->appendElement(
                    'a',
                    array('href' => 'javascript:void(0)', 'class'=>'', 'title'=>Labels::getLabel('LBL_Edit', $siteLangId), "onclick"=>"sellerProductVolumeDiscountForm(".$row['selprod_id'].", ".$row['voldiscount_id'].")"),
                    '<i class="fa fa-edit"></i>',
                    true
                );

                $li = $ul->appendElement('li');
                $li->appendElement(
                    'a',
                    array('href'=>'javascript:void(0)', 'class'=>'',
                    'title'=>Labels::getLabel('LBL_Delete', $siteLangId),"onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"),
                    '<i class="fa fa-trash"></i>',
                    true
                );
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement(
        'td',
        array('colspan'=>count($arr_flds)),
        Labels::getLabel('LBL_No_Record_Found', $siteLangId)
    );
}

echo $addVolDiscountfrm->getFormTag();
echo $addVolDiscountfrm->getFieldHtml('voldiscount_selprod_id');
echo $addVolDiscountfrm->getFieldHtml('selector'); ?>
</form>
<?php

$frm = new Form('frmVolDiscountListing', array('id'=>'frmVolDiscountListing'));
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap');

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array ('name' => 'frmSearchVolumeDiscountPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
