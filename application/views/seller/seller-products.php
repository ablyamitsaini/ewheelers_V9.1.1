<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'listserial' => Labels::getLabel( 'LBL_Sr.', $siteLangId ),
);
/* if( count($arrListing) && is_array($arrListing) && is_array($arrListing[0]['options']) && count($arrListing[0]['options']) ){ */
	$arr_flds['name'] = Labels::getLabel('LBL_Name', $siteLangId);
/* } */
$arr_flds['selprod_price'] = Labels::getLabel('LBL_Price', $siteLangId);
$arr_flds['selprod_stock'] = Labels::getLabel('LBL_Quantity', $siteLangId);
$arr_flds['selprod_available_from'] = Labels::getLabel('LBL_Available_From', $siteLangId);
$arr_flds['selprod_active'] = Labels::getLabel('LBL_Status', $siteLangId);
$arr_flds['action'] = Labels::getLabel('LBL_Action', $siteLangId);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}
if($page ==1){

	$sr_no = 0;
}else{
	$sr_no = ($page-1) * $pageSize;
}
/* CommonHelper::printArray($arrListing); die; */
foreach ($arrListing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' => ( $row['selprod_active'] != applicationConstants::ACTIVE ) ? '' : '' ));

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), '<span class="caption--td">' . $val . '</span>' . $sr_no,true);
			break;
			case 'name':
				$variantStr = '<div class="item-yk-head-title">'.$row['product_name'].'</div>';
				$variantStr .= ( $row['selprod_title'] != '') ? '<div class="item-yk-head-sub-title">' . $row['selprod_title'].'</div>' : '';
				if( is_array($row['options']) && count($row['options']) ){
					foreach($row['options'] as $op){
						$variantStr .= '<div class="item-yk-head-specification">'.$op['option_name'].': '.$op['optionvalue_name'].'</div>';
					}
				}
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.wordwrap($variantStr,150,"<br>\n"), true);
			break;
			case 'selprod_price':
				$td->appendElement( 'plaintext', array(), '<span class="caption--td">'.$val.'</span>'.CommonHelper::displayMoneyFormat( $row[$key], true, true),true );
			break;
			case 'selprod_available_from':
				$td->appendElement( 'plaintext', array(), '<span class="caption--td">'.$val.'</span>'.FatDate::format($row[$key], false),true );
			break;
			case 'selprod_active';
				/* $td->appendElement( 'plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$activeInactiveArr[$row[$key]],true ); */
				$active = "";
				if(applicationConstants::ACTIVE == $row['selprod_active']){
					$active = 'checked';
				}


				$str = '<div class="checkbox-switch"><input '.$active.' type="checkbox" value="'.$row['selprod_id'].'" id="switch'.$row['selprod_id'].'" onclick="toggleSellerProductStatus(event,this)"/><label for="switch'.$row['selprod_id'].'">Toggle</label></div>';

				$td->appendElement('plaintext', array(), $str,true);
			break;
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"),'<span class="caption--td">'.$val.'</span>',true);
				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=>CommonHelper::generateUrl('seller','sellerProductForm',array($row['selprod_product_id'],$row['selprod_id'])), 'class'=>'',
				'title'=>Labels::getLabel('LBL_Edit',$siteLangId)),
				'<i class="fa fa-edit"></i>', true);

				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
				'title'=>Labels::getLabel('LBL_Delete',$siteLangId),"onclick"=>"sellerProductDelete(".$row['selprod_id'].")"),
				'<i class="fa fa-trash"></i>', true);
				$productOptions = Product::getProductOptions( $row['selprod_product_id'], $siteLangId );
				if( is_array($productOptions) && count($productOptions) ){
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'',
					'title'=>Labels::getLabel('LBL_Clone',$siteLangId),"onclick"=>"sellerProductCloneForm(".$row['selprod_product_id'].",".$row['selprod_id'].")"),
					'<i class="fa fa-clone"></i>', true);
				}

			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key],true);
			break;
		}
	}
}
if (count($arrListing) == 0){ ?>
	<div class="block--empty align--center">
		<img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/empty_item.svg" alt="<?php echo Labels::getLabel('LBL_No_record_found', $siteLangId); ?>" width="80">
		<h4><?php echo Labels::getLabel("LBL_No_Products_added_yet.", $siteLangId); //Labels::getLabel('LBL_No_record_found', $siteLangId); ?></h4>
	</div>
<?php
	// $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_No_products_found_under_your_publication', $siteLangId));
		//$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId));
} else {
	echo $tbl->getHtml();
}

if( !$product_id ){
  $postedData['page'] = $page;
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmSellerProductSearchPaging') );
	$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToSellerProductSearchPage');
	$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
}
