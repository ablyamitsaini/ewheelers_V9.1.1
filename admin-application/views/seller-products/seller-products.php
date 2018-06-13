<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'listserial' => Labels::getLabel( 'LBL_Sr.', $adminLangId ),
);
/* if( count($arrListing) && is_array($arrListing) && is_array($arrListing[0]['options']) && count($arrListing[0]['options']) ){ */
	$arr_flds['name'] = Labels::getLabel('LBL_Name', $adminLangId);
/* } */
$arr_flds['user'] = Labels::getLabel('LBL_Seller', $adminLangId);
$arr_flds['selprod_price'] = Labels::getLabel('LBL_Price', $adminLangId);
$arr_flds['selprod_stock'] = Labels::getLabel('LBL_Quantity', $adminLangId);
$arr_flds['selprod_available_from'] = Labels::getLabel('LBL_Available_From', $adminLangId);
$arr_flds['selprod_active'] = Labels::getLabel('LBL_Status', $adminLangId);
$arr_flds['action'] = Labels::getLabel('LBL_Action', $adminLangId);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive table--hovered'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arrListing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array() );
	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
			break;
			case 'name':
				$variantStr = $row['product_name'];
				$variantStr .= ( $row['selprod_title'] != '') ? '<br/><small>' . $row['selprod_title'].'</small><br/>' : '';
				if( is_array($row['options']) && count($row['options']) ){
					foreach($row['options'] as $op){
						$variantStr .= $op['option_name'].': '.$op['optionvalue_name'].'<br/>';
					}
				}
				$td->appendElement('plaintext', array(), $variantStr , true);
			break;
			case 'user':
				$userDetail = '<strong>'.Labels::getLabel('LBL_N:', $adminLangId).' </strong>'.$row['user_name'].'<br/>';
				$userDetail .= '<strong>'.Labels::getLabel('LBL_Email:', $adminLangId).' </strong>'.$row['credential_email'].'<br/>';
				$td->appendElement( 'plaintext', array(), $userDetail, true );
			break;
			case 'selprod_price':
				$td->appendElement( 'plaintext', array(), CommonHelper::displayMoneyFormat( $row[$key], true, true),true );
			break;
			case 'selprod_available_from':
				$td->appendElement( 'plaintext', array(), FatDate::format($row[$key], false),true );
			break;
			case 'selprod_active';
				$active = "";
				if( $row['selprod_active'] ) {
					$active = 'checked';
				}
				$statusAct = ( $canEdit === true ) ? 'toggleStatus(event,this,' .applicationConstants::YES. ')' : 'toggleStatus(event,this,' .applicationConstants::NO. ')';
				$statusClass = ( $canEdit === false ) ? 'disabled' : '';
				$str= '<label class="statustab -txt-uppercase">
					   <input '.$active.' type="checkbox" id="switch'.$row['selprod_id'].'" value="'.$row['selprod_id'].'" onclick="'.$statusAct.'" class="switch-labels"/>
                       <i class="switch-handles '.$statusClass.'"></i></label>';
				$td->appendElement('plaintext', array(), $str,true);
			break;
			case 'action':



				$ul = $td->appendElement("ul",array("class"=>"actions actions--centered"),'',true);
				if( $canEdit ){
					$li = $ul->appendElement("li",array('class'=>'droplink'));

					$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
						$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));
						$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
						$innerLiEdit=$innerUl->appendElement('li');



					$innerLiEdit->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
					'title'=>Labels::getLabel('LBL_Edit',$adminLangId),"onclick"=>"addSellerProductForm(" . $row['selprod_product_id'] . ",".$row['selprod_id'].")"),Labels::getLabel('LBL_Edit',$adminLangId), true);
					
					$innerLiSpecialPrice = $innerUl->appendElement("li");
					$innerLiSpecialPrice->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
					'title'=>Labels::getLabel('LBL_Special_Price',$adminLangId),"onclick"=>"addSellerProductSpecialPrices(".$row['selprod_id'].")"),
					Labels::getLabel('LBL_Special_Price',$adminLangId), true);
					
					$innerLiDelete = $innerUl->appendElement("li");
					$innerLiDelete->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
					'title'=>Labels::getLabel('LBL_Delete_Product',$adminLangId),"onclick"=>"sellerProductDelete(".$row['selprod_id'].")"),
					Labels::getLabel('LBL_Delete_Product',$adminLangId), true);
				}
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key],true);
			break;
		}
	}
}
if (count($arrListing) == 0){
	
	$tbl->appendElement('tr')->appendElement('td', array(
	'colspan'=>count($arr_flds)), 
	Labels::getLabel('LBL_No_Record_Found',$adminLangId)
	);
	echo $tbl->getHtml();
} else {
	echo $tbl->getHtml();
}
	
if( !$product_id ){
	$postedData['page'] = $page;
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmProductSearchPaging') );
	$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToSearchPage','adminLangId'=>$adminLangId);
	$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
}