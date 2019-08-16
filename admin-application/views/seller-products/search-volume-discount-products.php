<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_Sr.', $adminLangId),
    'name' => Labels::getLabel('LBL_Name', $adminLangId),
    'volumeDiscountCount' => Labels::getLabel('LBL_Volume_Discounts', $adminLangId),
    'selprod_price' => Labels::getLabel('LBL_Price', $adminLangId),
);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive table--hovered'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $key => $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arrListing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr', array());

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'name':
                $variantStr = ($row['selprod_title'] != '') ? $row['selprod_title'].'<br/>' : '';
                if (is_array($row['options']) && count($row['options'])) {
                    foreach ($row['options'] as $op) {
                        $variantStr .= $op['option_name'].': '.$op['optionvalue_name'].'<br/>';
                    }
                }
                $td->appendElement('plaintext', array(), $variantStr, true);
                if ($canViewSellerProducts) {
                    $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectfunc("'.CommonHelper::generateUrl('Products').'", '.$row['selprod_product_id'].')'), $row['product_name'], true);
                } else {
                    $td->appendElement('plaintext', array(), $row['product_name'], true);
                }
                break;
            case 'selprod_price':
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true), true);
                break;
            case 'volumeDiscountCount':
                $td->appendElement('a', array('href' => CommonHelper::generateUrl('SellerProducts', 'volumeDiscountList', array($row['selprod_id'])), 'target' => '_blank'), $row[$key], true);
                break;
            case 'selprod_available_from':
                $td->appendElement('plaintext', array(), FatDate::format($row[$key], false), true);
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
        Labels::getLabel('LBL_No_Record_Found', $adminLangId)
    );
}

$frm = new Form('frmSelProdListing', array('id'=>'frmSelProdListing'));
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap');
// $frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList); return(false);');

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array ('name' => 'frmSearchVolumeDiscountPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
