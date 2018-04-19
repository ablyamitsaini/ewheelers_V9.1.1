<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'utxn_id'	=>	Labels::getLabel('LBL_Txn_ID', $siteLangId),
	'utxn_date'	=>	Labels::getLabel('LBL_Date', $siteLangId),
	'utxn_credit' =>	Labels::getLabel('LBL_Credit', $siteLangId),
	'utxn_debit'	=>	Labels::getLabel('LBL_Debit', $siteLangId),
	'balance'	=>	Labels::getLabel('LBL_Balance', $siteLangId),
	'utxn_comments'	=>	Labels::getLabel('LBL_Comments', $siteLangId),
	'utxn_status'	=>	Labels::getLabel('LBL_Status', $siteLangId),
);

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arrListing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' =>'' ));
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'utxn_id':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'. Transactions::formatTransactionNumber($row[$key]), true);
			break;
			case 'utxn_date':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.FatDate::format($row[$key]) , true);
			break;
			case 'utxn_status':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$statusArr[$row[$key]] , true);
			break;
			case 'utxn_credit':
				$txt = '<span class="caption--td">'.$val.'</span>'.CommonHelper::displayMoneyFormat( $row[$key] );
				$td->appendElement('plaintext', array(), $txt , true);
			break;
			case 'utxn_debit':
				$txt = '<span class="caption--td">'.$val.'</span>'.CommonHelper::displayMoneyFormat( $row[$key] );
				$td->appendElement('plaintext', array(), $txt , true);
			break;
			case 'balance':
				$txt = '<span class="caption--td">'.$val.'</span>'.CommonHelper::displayMoneyFormat( $row[$key] );
				$td->appendElement('plaintext', array(), $txt , true);
			break;
			case 'utxn_comments':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.Transactions::formatTransactionComments($row[$key]),true);
			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key],true);
			break;
		}
	}
}

if (count($arrListing) == 0){
	//$tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_Unable_to_find_any_record', $siteLangId));
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
}
else{
	echo $tbl->getHtml();
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmCreditSrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToOrderSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);