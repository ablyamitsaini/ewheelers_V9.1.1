<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'listserial'=>'Sr.',
	'product_identifier' => Labels::getLabel('LBL_Product', $siteLangId),
	'product_added_on' => Labels::getLabel('LBL_Date', $siteLangId),
);
/* if( $CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL ){ */
	$arr_flds['product_approved'] = Labels::getLabel('LBL_Admin_Approval', $siteLangId);
/* } */
$arr_flds['product_active'] = Labels::getLabel('LBL_Status', $siteLangId);
$arr_flds['action'] = Labels::getLabel('LBL_Action', $siteLangId);

$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arr_listing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' => ($row['product_active'] != applicationConstants::ACTIVE) ? 'fat-inactive-row' : '' ));

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$sr_no,true);
			break;
			case 'product_identifier':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row['product_name'] . '<br>', true);
				$td->appendElement('plaintext', array(), '('.$row[$key].')', true);
			break;

			case 'product_approved':
					$approveUnApproveArr = Product::getApproveUnApproveArr($siteLangId);
					$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$approveUnApproveArr[$row[$key]] ,true);
			break;

			case 'product_active':
				$activeInactiveArr = applicationConstants::getActiveInactiveArr($siteLangId);
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$activeInactiveArr[$row[$key]] ,true);
			break;
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"),'<span class="caption--td">'.$val.'</span>',true);
				$li = $ul->appendElement("li");
				$li->appendElement('a', array( 'class'=>'',
				'title'=>Labels::getLabel('LBL_Edit',$siteLangId),"href"=>CommonHelper::generateUrl('seller','customProductForm',array($row['product_id']))),
				'<i class="fa fa-edit"></i>', true);

				$li = $ul->appendElement("li");
				$li->appendElement("a", array('title' => Labels::getLabel('LBL_Product_Images', $siteLangId),
				'onclick' => 'customProductImages('.$row['product_id'].')', 'href'=>'javascript:void(0)'),
				'<i class="fa fa-picture-o"></i>', true);

			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key],true);
			break;
		}
	}
}
if (count($arr_listing) == 0){ ?>
	<div class="block--empty align--center">
		<img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/empty_item.svg" alt="<?php Labels::getLabel('LBL_No_record_found', $siteLangId); ?>" width="80">
		<h4><?php echo Labels::getLabel("LBL_No_catalog_found.", $siteLangId); //; ?></h4>
	</div>
<?php
	// $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_No_products_found_under_your_publication', $siteLangId));
		//$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId));
} else {
	echo $tbl->getHtml();
}


echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmCustomProductSearchPaging') );

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'callBackJsFunc' => 'goToCustomProductSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
?>
