<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
    'select_all'=>Labels::getLabel('LBL_Select_all', $adminLangId),
    'product_name' => Labels::getLabel('LBL_Name', $adminLangId),
    'voldiscount_min_qty' => Labels::getLabel('LBL_Minimum_Quantity', $adminLangId),
    'voldiscount_percentage' => Labels::getLabel('LBL_Discount', $adminLangId).' (%)',
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--orders table--hovered volDiscountList-js'));
$thead = $tbl->appendElement('thead');
$th = $thead->appendElement('tr', array('class' => ''));

foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="'.$val.'" type="checkbox" onclick="selectAll($(this))" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}

foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array());

    foreach ($arr_flds as $key => $val) {
        $tr->setAttribute('id', 'row-'.$row['voldiscount_id']);
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
            case 'voldiscount_percentage':
                $input = '<input type="text" data-id="'.$row['voldiscount_id'].'" value="'.$row[$key].'" data-selprodid="'.$row['selprod_id'].'" name="'.$key.'" class="js--volDiscountCol hidden vd-input" data-val="'.$row[$key].'"/>';
                $td->appendElement('div', array("class" => 'js--editCol edit-hover', "title" => Labels::getLabel('LBL_Click_To_Edit', $adminLangId)), $row[$key], true);
                $td->appendElement('plaintext', array(), $input, true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array("class"=>"actions actions--centered"));

                $li = $ul->appendElement("li", array('class'=>'droplink'));


                $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                  $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                  $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));

                if ($canEdit) {
                    $innerLiEdit = $innerUl->appendElement("li");
                    $innerLiEdit->appendElement(
                        'a',
                        array('href'=>'javascript:void(0)', 'class'=>'',
                        'title'=>Labels::getLabel('LBL_Delete', $adminLangId),"onclick"=>"deleteSellerProductVolumeDiscount(".$row['voldiscount_id'].")"),
                        Labels::getLabel('LBL_Remove', $adminLangId),
                        true
                    );
                }
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

$frm = new Form('frmVolDiscountListing', array('id'=>'frmVolDiscountListing'));
$frm->setFormTagAttribute('class', 'form');

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array ('name' => 'frmSearchVolumeDiscountPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
