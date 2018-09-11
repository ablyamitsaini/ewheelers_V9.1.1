<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'name'	=>	Labels::getLabel('LBL_Product', $siteLangId),	
	'wishlist_user_counts'	=>	Labels::getLabel('LBL_WishList_User_Counts', $siteLangId)
);

if($topPerformed){
	$arr_flds['totSoldQty'] = Labels::getLabel('LBL_Sold_Quantity',$siteLangId);
}else{
	$arr_flds['totRefundQty'] = Labels::getLabel('LBL_Refund_Quantity',$siteLangId);
}

$tbl = new HtmlElement('table', array('class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arrListing as $sn => $listing){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' =>'' ));
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'name':
				$name ='';
				$name = '<div class="item-yk-head-title">'.$listing['op_product_name'].'</div>';
				if( $listing['op_selprod_title'] != '' ){
					$name .= '<div class="item-yk-head-sub-title"><strong>'.Labels::getLabel('LBL_Custom_Title', $siteLangId).": </strong>".$listing['op_selprod_title'].'</div>';
				}
				
				if( $listing['op_selprod_options'] != '' ){
					$name .= '<div class="item-yk-head-specification">'.Labels::getLabel('LBL_Options', $siteLangId).": </strong>".$listing['op_selprod_options'].'</div>';
				}
				
				if( $listing['op_brand_name'] != '' ){
					$name .= '<div class="item-yk-head-brand"><strong>'.Labels::getLabel('LBL_Brand', $siteLangId).": </strong>".$listing['op_brand_name'].'</div>';
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$name,true);
			break;
			
			case 'totSoldQty':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing['totSoldQty'],true);
			break;
			
			case 'totRefundQty':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing['totRefundQty'],true);
			break;
			
			case 'wishlist_user_counts':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing['wishlist_user_counts'],true);
			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$listing[$key],true);
			break;
		}
	}
}
if (count($arrListing) == 0){
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	$noteLbl = Labels::getLabel("LBL_Note:_Performance_Report_on_the_basis_of_Sold_Quantity", $siteLangId);
	echo $tbl->getHtml();
}
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSrchProdPerformancePaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToTopPerformingProductsSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
?>