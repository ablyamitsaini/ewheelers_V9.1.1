<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'listserial' => Labels::getLabel('LBL_Sr.', $siteLangId),
);
/* if( count($arrListing) && is_array($arrListing) && is_array($arrListing[0]['options']) && count($arrListing[0]['options']) ){ */
    $arr_flds['name'] = Labels::getLabel('LBL_Name', $siteLangId);
/* } */
$arr_flds['selprod_price'] = Labels::getLabel('LBL_Price', $siteLangId);
$arr_flds['specialPriceCount'] = Labels::getLabel('LBL_Special_Prices', $siteLangId);
$arr_flds['selprod_stock'] = Labels::getLabel('LBL_Quantity', $siteLangId);
$arr_flds['selprod_available_from'] = Labels::getLabel('LBL_Available_From', $siteLangId);

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
                $td->appendElement('plaintext', array(), $row['product_name'], true);
                break;
            case 'selprod_price':
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true), true);
                break;
            case 'specialPriceCount':
                $td->appendElement('a', array('href' => CommonHelper::generateUrl('SellerProducts', 'specialPriceList', array($row['selprod_id'])), 'target' => '_blank'), $row[$key], true);
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
        Labels::getLabel('LBL_No_Record_Found', $siteLangId)
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
echo FatUtility::createHiddenFormFromData($postedData, array ('name' => 'frmSearchSpecialPricePaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
