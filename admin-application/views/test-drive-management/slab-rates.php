<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Seller_Credit_Slab_Rates',$adminLangId); ?></h4>
		<ul class="actions actions--centered"><li class="droplink"><a href="javascript:void(0)" class="button small green" title="Edit"><i class="ion-android-more-horizontal icon"></i></a><div class="dropwrap"><ul class="linksvertical"><li><a href="javascript:void(0)" class="button small green" title="Export" onclick="slabRateForm()"><?php echo Labels::getLabel('LBL_Add',$adminLangId); ?></a></li></ul></div></li></ul>
	</div>
<?php
$arr_flds = array(
		'listserial'=> Labels::getLabel('LBL_Sr._No',$adminLangId),
		'tdcs_min_rides' => Labels::getLabel('LBL_Min_Rides',$adminLangId),
		'tdcs_max_rides'=>Labels::getLabel('LBL_Max_Rides',$adminLangId),	
		'tdcs_amount'=>Labels::getLabel('LBL_Amount',$adminLangId),	
		'action' => Labels::getLabel('LBL_Action',$adminLangId),
	);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive table--hovered'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arr_listing as $sn=>$row){
	$sr_no++;
	$tr = $tbl->appendElement('tr');
	$recordId = FatUtility::int($row['tdcs_id']);
	$tr->setAttribute ("id",$recordId);

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
			break;
			case 'tdcs_min_rides':
				$td->appendElement('plaintext', array(), $row['tdcs_min_rides']);
			break;
			case 'tdcs_max_rides':
				$td->appendElement('plaintext', array(), $row['tdcs_max_rides']);
			break;
			case 'tdcs_amount':
				$td->appendElement('plaintext', array(), $row['tdcs_amount']);
			break;
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions actions--centered"));
				if($canEdit){
					$li = $ul->appendElement("li",array('class'=>'droplink'));
					$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
              		$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));
              		$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
              		$innerLiEdit=$innerUl->appendElement('li');
					$innerLiEdit->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green', 
					'title'=>Labels::getLabel('LBL_Edit',$adminLangId),"onclick"=>"editSlabRates($recordId)"),Labels::getLabel('LBL_Edit',$adminLangId), 
					true);
					$innerLiDelete=$innerUl->appendElement('li');
					$innerLiDelete->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green', 
					'title'=>Labels::getLabel('LBL_Edit',$adminLangId),"onclick"=>"deleteSlabRates($recordId)"),Labels::getLabel('LBL_Delete',$adminLangId), 
					true);
				}
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key],true);
			break;
		}
	}
}
if (count($arr_listing) == 0){
	$tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_No_Records_Found',$adminLangId));
}
echo $tbl->getHtml();

/* if(isset($pageCount)){
	$postedData['page']=$page;
	echo FatUtility::createHiddenFormFromData ( $postedData, array (
			'name' => 'frmMetaTagSearchPaging'
	) );
	$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'adminLangId'=>$adminLangId);
	$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
} */
?>
</section>