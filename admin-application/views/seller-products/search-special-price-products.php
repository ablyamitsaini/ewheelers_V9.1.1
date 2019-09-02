<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$editListingFrm = new Form('editListingFrm', array('id'=>'editListingFrm'));

$arr_flds = array(
    'select_all'=>Labels::getLabel('LBL_Select_all', $adminLangId),
    'product_name' => Labels::getLabel('LBL_Name', $adminLangId),
    'splprice_start_date' => Labels::getLabel('LBL_Start_Date', $adminLangId),
    'splprice_end_date' => Labels::getLabel('LBL_End_Date', $adminLangId),
    'splprice_price' => Labels::getLabel('LBL_Special_Price', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId),
);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive table--hovered splPriceList-js'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => 'hide--mobile'));
foreach ($arr_flds as $key => $val) {
    if ('select_all' == $key) {
        $th->appendElement('th')->appendElement('plaintext', array(), '<label class="checkbox"><input title="'.$val.'" type="checkbox" onclick="selectAll($(this))" class="selectAll-js"><i class="input-helper"></i></label>', true);
    } else {
        $th->appendElement('th', array(), $val);
    }
}

foreach ($arrListing as $sn => $row) {
    $tr = $tbl->appendElement('tr', array());
    $splPriceID = $row['splprice_id'];
    foreach ($arr_flds as $key => $val) {
        $tr->setAttribute('id', 'row-'.$splPriceID);
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="selprod_ids['.$splPriceID.']" value='.$row['selprod_id'].'><i class="input-helper"></i></label>', true);
                break;
            case 'product_name':
                // last Param of getProductDisplayTitle function used to get title in html form.
                $productName = SellerProduct::getProductDisplayTitle($row['selprod_id'], $adminLangId, true);
                $td->appendElement('plaintext', array(), $productName, true);
                break;
            case 'splprice_start_date':
            case 'splprice_end_date':
                $date = date('Y-m-d', strtotime($row[$key]));
                $attr = array(
                    'readonly' => 'readonly',
                    'placeholder' => $val,
                    'data-selprodid' => $row['selprod_id'],
                    'data-id' => $splPriceID,
                    'data-oldval' => $date,
                    'id' => $key.'-'.$splPriceID,
                    'class' => 'date_js js--splPriceCol hide sp-input',
                );
                $editListingFrm->addDateField($val, $key, $date, $attr);

                /*$input = '<input readonly="readonly" data-id="'.$splPriceID.'"  data-selprodid="'.$row['selprod_id'].'"  placeholder="'.$val.'" id="'.$key.'-'.$splPriceID.'" class="date_js fld-date js--splPriceCol hide sp-input" title="'.$val.'"  data-val="'.$date.'" data-fatdateformat="yy-mm-dd" type="text" name="'.$key.'" value="'.$date.'">';*/

                $td->appendElement('div', array("class" => 'js--editCol edit-hover', "title" => Labels::getLabel('LBL_Click_To_Edit', $adminLangId)), $date, true);
                $td->appendElement('plaintext', array(), $editListingFrm->getFieldHtml($key), true);
                break;
            case 'splprice_price':
                $input = '<input type="text" data-id="'.$splPriceID.'" value="'.$row[$key].'" data-selprodid="'.$row['selprod_id'].'" name="'.$key.'" class="js--splPriceCol hide sp-input" data-val="'.$row[$key].'"/>';
                $td->appendElement('div', array("class" => 'js--editCol edit-hover', "title" => Labels::getLabel('LBL_Click_To_Edit', $adminLangId)), CommonHelper::displayMoneyFormat($row[$key]), true);
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
                        'title'=>Labels::getLabel('LBL_Delete', $adminLangId),"onclick"=>"deleteSellerProductSpecialPrice(".$splPriceID.")"),
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

$frm = new Form('frmSplPriceListing', array('id'=>'frmSplPriceListing'));
$frm->setFormTagAttribute('class', 'web_form last_td_nowrap');

echo $frm->getFormTag();
echo $tbl->getHtml(); ?>
</form>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSearchSpecialPricePaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
