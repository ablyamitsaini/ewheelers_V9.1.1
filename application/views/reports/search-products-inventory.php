<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'sr'	=>	Labels::getLabel('LBL_SrNo.', $siteLangId),
	'name'	=>	Labels::getLabel('LBL_Product', $siteLangId),
	'selprod_stock'	=>	Labels::getLabel('LBL_Stock_Quantity', $siteLangId)
);

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arrListing as $sn => $listing){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' =>'' ));
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'sr':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$sr_no,true);
			break;
			case 'name':
				$name = '<div class="item-yk-head-title">'.$listing['product_name'].'</div>';
				if( $listing['selprod_title'] != '' ){
					$name .= '<div class="item-yk-head-sub-title"><strong>'.Labels::getLabel('LBL_Custom_Title', $siteLangId).": </strong>".$listing['selprod_title'].'</div>';
				}
			
				if( $listing['brand_name'] != '' ){
					$name .= '<div class="item-yk-head-brand">'.Labels::getLabel('LBL_Brand', $siteLangId).": </strong>".$listing['brand_name'].'</div>';
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$name,true);
			break;
			
			case 'selprod_stock':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing['selprod_stock'],true);
			break;
			
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing[$key],true);
			break;
		}
	}
}
if( count($arrListing) == 0 ){
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	echo '<div class="box__head"><div class="group--btns"><a href="javascript:void(0)" onClick="exportProductsInventoryReport()" class="btn btn--secondary btn--sm">'.Labels::getLabel('LBL_Export',$siteLangId).'</a></div></div>';
	echo $tbl->getHtml();
}
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmProductInventorySrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToProductsInventorySearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
?>