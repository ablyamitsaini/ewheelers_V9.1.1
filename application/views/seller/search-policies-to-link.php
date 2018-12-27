<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
		'listserial'=>Labels::getLabel('LBL_Sr._no.',$siteLangId),
		'ppoint_title'=>Labels::getLabel('LBL_Policy',$siteLangId),
		'action' => Labels::getLabel('LBL_Action',$siteLangId),
	);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive'));

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = $page==1?0:$pageSize*($page-1);
foreach ($arr_listing as $sn=>$row){
	$sr_no++;
	$tr = $tbl->appendElement('tr');
	if($row['ppoint_active'] != applicationConstants::ACTIVE) {
		$tr->setAttribute ("class","fat-inactive");
	}
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
			break;
			case 'ppoint_identifier':
				if(!empty($row['ppoint_title'])){
					$td->appendElement('plaintext', array(), $row['ppoint_title'].'<br/>('.$row['ppoint_identifier'].')',true);
				}else{
					$td->appendElement('plaintext', array(), $row['ppoint_identifier'], true);
				}
			break;
			case 'action':
				$active = "";
				if($row['sppolicy_ppoint_id']){
					$active = 'checked';
				}
				$statucAct = (!$row['sppolicy_ppoint_id']) ? 'addPolicyPoint('.$selprod_id.",".$row['ppoint_id'].')' : 'removePolicyPoint('.$selprod_id.",".$row['ppoint_id'].')' ;

				$str = '<div class="checkbox-switch"><input '.$active.' type="checkbox" id="switch'.$row['ppoint_id'].'" onclick="'.$statucAct.'"/><label for="switch'.$row['ppoint_id'].'">Toggle</label></div>';
				$td->appendElement('plaintext', array(), $str,true);

			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key], true);
			break;
		}
	}
}
if (count($arr_listing) == 0){
	$tbl->appendElement('tr')->appendElement('td', array(
	'colspan'=>count($arr_flds)),
	'No records found'
	);
}
echo $tbl->getHtml();
$postedData['page']=$page;
echo FatUtility::createHiddenFormFromData ( $postedData, array (
		'name' => 'frmPolicyToLinkSearchPaging'
) );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToNextPolicyToLinkPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
