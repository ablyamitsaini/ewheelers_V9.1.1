<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'listserial'=>'Sr.',
    'product_identifier' => Labels::getLabel('LBL_Product', $siteLangId),
    'user_name' => Labels::getLabel('LBL_Name', $siteLangId),
    'ptdr_location' => Labels::getLabel('LBL_Location', $siteLangId),
    'ptdr_status' => Labels::getLabel('LBL_Status', $siteLangId),
    'ptdr_contact' => Labels::getLabel('LBL_Contact', $siteLangId),
    'ptdr_date' => Labels::getLabel('LBL_Date_Time', $siteLangId),
    'action' => Labels::getLabel('LBL_Action', $siteLangId)
);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--orders'));
$th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arr_listing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr', array('class' => ''));

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no, true);
                break;
            case 'product_identifier':
                $td->appendElement('plaintext', array(), $row['product_name'] . '<br>', true);
                $td->appendElement('plaintext', array(), '('.$row[$key].')', true);
                break;
            case 'user_name':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($siteLangId, $row[$key]), true);
                break;
            case 'product_approved':
                $approveUnApproveArr = Product::getApproveUnApproveArr($siteLangId);
                $td->appendElement('plaintext', array(), $approveUnApproveArr[$row[$key]], true);
                break;
            case 'ptdr_status':
                $testDriveStatusArr = TestDrive::getStatusArr($siteLangId);
                $td->appendElement('plaintext', array(), $testDriveStatusArr[$row[$key]], true);
                break;
			case 'ptdr_contact':
                $td->appendElement('plaintext', array(), $row['ptdr_contact'], true);
                break;
			case 'ptdr_date':
                $td->appendElement('plaintext', array(), $row['ptdr_date'], true);
                break;
            case 'action':
                $ul = $td->appendElement("ul", array('class'=>'actions'), '', true);
                $li = $ul->appendElement("li");
                $li->appendElement(
                    'a',
                    array('href'=>'javascript:void(0)', 'onclick'=>'tdRequestInfo('.$row['ptdr_id'].')', 'class'=>'','title'=>Labels::getLabel('LBL_product_Info', $siteLangId), true),
                    '<i class="fa fa-eye"></i>',
                    true
                );

                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
echo $tbl->getHtml();
if (count($arr_listing) == 0) {
    $message = Labels::getLabel('LBL_Searched_product_is_not_found_in_catalog', $siteLangId);
    $linkArr = array();
    
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId,'linkArr'=>$linkArr,'message'=>$message));
}


$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmTestDriveSearchPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'callBackJsFunc' => 'goToTestDriveSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
