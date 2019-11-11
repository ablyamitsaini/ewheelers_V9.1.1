<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'listserial'=>'Sr.',
    'ptdr_request_added_on' => Labels::getLabel('LBL_Date', $adminLangId),
	'ptdr_id' => Labels::getLabel('LBL_Test_Drive_Number', $adminLangId),
	'product_name' => Labels::getLabel('LBL_Product', $adminLangId),
	'sellername' => Labels::getLabel('LBL_Dealer', $adminLangId),
	'buyername' => Labels::getLabel('LBL_Buyer', $adminLangId),
	'ptdr_date' => Labels::getLabel('LBL_Requested_On', $adminLangId),
	'ptdr_status' => Labels::getLabel('LBL_Status', $adminLangId),
	'utxn_id' => Labels::getLabel('LBL_Payment_Status', $adminLangId)
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
			case 'ptdr_request_added_on':
                $td->appendElement('plaintext', array(), FatDate::format($row['ptdr_request_added_on'],true), true);
                break;
			case 'product_name':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
            case 'buyername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
			case 'sellername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
            case 'ptdr_status':
                $testDriveStatusArr = TestDrive::getStatusArr($adminLangId);
                $td->appendElement('plaintext', array(), $testDriveStatusArr[$row[$key]], true);
                break;
			
			case 'ptdr_date':
                $td->appendElement('plaintext', array(), FatDate::format($row['ptdr_date'],true), true);
                break;
           case 'utxn_id':
				if(!empty($row['utxn_id'])){
					$td->appendElement('plaintext', array(),Labels::getLabel('LBL_Settled', $adminLangId), true); 
				}else{ 
					$td->appendElement('plaintext', array(),Labels::getLabel('LBL_Payment_Label', $adminLangId), true), true); 
				}
                
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}
echo $tbl->getHtml();
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_listing)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}


$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmTestDriveReportSearchPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'adminLangId'=>$adminLangId,'callBackJsFunc' => 'goToSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
