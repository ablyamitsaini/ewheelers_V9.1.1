<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$arr_flds = array(
    'listserial'=>'Sr.',
    'product_identifier' => Labels::getLabel('LBL_Product', $adminLangId),
    'buyername' => Labels::getLabel('LBL_Buyer_Name', $adminLangId),
	'sellername' => Labels::getLabel('LBL_Seller_Name', $adminLangId),
    //'ptdr_location' => Labels::getLabel('LBL_Location', $adminLangId),
    'ptdr_status' => Labels::getLabel('LBL_Status', $adminLangId),
    /* 'ptdr_contact' => Labels::getLabel('LBL_Contact', $adminLangId), */
    'ptdr_date' => Labels::getLabel('LBL_Requested_On', $adminLangId),
	'ptdr_request_added_on' => Labels::getLabel('LBL_Date_Time', $adminLangId),
    'action' => Labels::getLabel('LBL_Action', $adminLangId)
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
                $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectfunc("'.CommonHelper::generateUrl('Products').'", '.$row['product_id'].')'), $row['product_name'], true);
                break;
            case 'buyername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
			 case 'sellername':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
            case 'product_approved':
                $approveUnApproveArr = Product::getApproveUnApproveArr($adminLangId);
                $td->appendElement('plaintext', array(), $approveUnApproveArr[$row[$key]], true);
                break;
            case 'ptdr_status':
                $testDriveStatusArr = TestDrive::getStatusArr($adminLangId);
                $td->appendElement('plaintext', array(), $testDriveStatusArr[$row[$key]], true);
                break;
			/* case 'ptdr_contact':
                $td->appendElement('plaintext', array(), $row['ptdr_contact'], true);
                break; */
			case 'ptdr_date':
                $td->appendElement('plaintext', array(), FatDate::format($row['ptdr_date'],true), true);
                break;
			case 'ptdr_request_added_on':
                $td->appendElement('plaintext', array(), FatDate::format($row['ptdr_request_added_on'],true), true);
                break;
            case 'action':

               $ul = $td->appendElement("ul", array("class"=>"actions actions--centered"));

                    $li = $ul->appendElement("li", array('class'=>'droplink'));


                    $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_View_Details', $adminLangId)), '<i class="ion-android-more-horizontal icon"></i>', true);
                      $innerDiv=$li->appendElement('div', array('class'=>'dropwrap'));
                      $innerUl=$innerDiv->appendElement('ul', array('class'=>'linksvertical'));
                      //$innerLi=$innerUl->appendElement('li');

                if ($canViewUsers) {
                    $innerLiEdit = $innerUl->appendElement("li");
                    $innerLiEdit->appendElement(
                        'a',
                        array('href'=>'javascript:void(0)', 'onclick'=>'tdRequestInfo('.$row['ptdr_id'].')', 'class'=>'button small green','title'=>Labels::getLabel('LBL_View_Details', $adminLangId),"onclick"=>"viewTestDriveDetails(".$row['ptdr_id'].")"),
                        Labels::getLabel('LBL_View_Details', $adminLangId),
                        true
                    );
                }
				
				if($row['ptdr_status'] == TestDrive::STATUS_DELIVERED){
					$innerLiEdit = $innerUl->appendElement("li");
                    $innerLiEdit->appendElement(
                        'a',
                        array('href'=>'javascript:void(0)', '', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Mark_As_Completed', $adminLangId),"onclick"=>"completeRequest(".$row['ptdr_id'].")"),
                        Labels::getLabel('LBL_Mark_As_Completed', $adminLangId),
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
echo $tbl->getHtml();
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_listing)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}


$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmTestDriveSearchPaging'));

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'adminLangId'=>$adminLangId,'callBackJsFunc' => 'goToTestDriveSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
