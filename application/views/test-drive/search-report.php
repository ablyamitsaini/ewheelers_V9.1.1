<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'listserial'=>'Sr.',
    'ptdr_request_added_on' => Labels::getLabel('LBL_Date', $siteLangId),
	'ptdr_id' => Labels::getLabel('LBL_Test_Drive_Number', $siteLangId),
	'product_name' => Labels::getLabel('LBL_Product', $siteLangId),
	//'sellername' => Labels::getLabel('LBL_Dealer', $siteLangId),
	'buyername' => Labels::getLabel('LBL_Buyer', $siteLangId),
	'ptdr_date' => Labels::getLabel('LBL_Requested_On', $siteLangId),
	'ptdr_status' => Labels::getLabel('LBL_Status', $siteLangId),
	'utxn_id' => Labels::getLabel('LBL_Payment_Status', $siteLangId)
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
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($siteLangId, $row[$key]), true);
                break;
            case 'buyername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($siteLangId, $row[$key]), true);
                break;
			case 'sellername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($siteLangId, $row[$key]), true);
                break;
            case 'ptdr_status':
                $testDriveStatusArr = TestDrive::getStatusArr($siteLangId);
                $td->appendElement('plaintext', array(), $testDriveStatusArr[$row[$key]], true);
                break;
			
			case 'ptdr_date':
                $td->appendElement('plaintext', array(), FatDate::format($row['ptdr_date'],true), true);
                break;
           case 'utxn_id':
				if(!empty($row['utxn_id'])){
					$td->appendElement('plaintext', array(),Labels::getLabel('LBL_Settled', $siteLangId), true); 
				}else{ 
					$td->appendElement('plaintext', array(),Labels::getLabel('LBL_Payment_Label', $siteLangId), true); 
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
    $message = Labels::getLabel('LBL_Searched_Report_is_not_found_in_catalog', $siteLangId);
    $linkArr = array();
    
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId,'linkArr'=>$linkArr,'message'=>$message));
}


$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmTestDriveReportSrchPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'callBackJsFunc' => 'goToTestDriveReportSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
