<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$arr_flds = array(
	'listserial'=>'Sr.',
	'prodcat_name' => Labels::getLabel('LBL_Category', $siteLangId),
	'banner' => Labels::getLabel('LBL_Banner', $siteLangId),
	'action' => Labels::getLabel('LBL_Action', $siteLangId)
);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--orders'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => ''));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arr_listing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' => ''));

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no,true);
			break;
			case 'banner':
				$td->appendElement('plaintext', array(), '<img src="'.CommonHelper::generateUrl('category','sellerBanner',array($row['shop_id'], $row['prodcat_id'], $siteLangId, 'thumb')).'?'.time().'">',true);
			break;
			case 'action':
				$ul = $td->appendElement("ul",array('class'=>'actions'),'',true);
				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=>'javascript:void(0)','onClick'=>'addCategoryBanner('.$row['prodcat_id'].')', 'class'=>'','title'=>Labels::getLabel('LBL_Media',$siteLangId)),
				'<i class="fa fa-edit"></i>', true);
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key],true);
			break;
		}
	}
}
?>
<?php
	$variables= array('language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
	$this->includeTemplate('seller/_partial/shop-navigation.php',$variables,false);
?>
<?php
if (count($arr_listing) == 0){
	$tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds), 'class'=>'text-center'), Labels::getLabel('LBL_No_record_found', $siteLangId));
}
echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmCategoryBannerSrchPaging') );

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'callBackJsFunc' => 'goToCategoryBannerSrchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
