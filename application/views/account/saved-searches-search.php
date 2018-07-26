<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="saved-search-list">
	<ul>
	  <?php foreach ($arrListing as $sn => $row){ ?>
		<li>
			<div class="detail-side">
				<div class="heading3"><?php echo $row['pssearch_name']; ?> - Round, IGI, SL1, D, 0.30-0.49, cut G</div>
				<div class="date"><?php echo FatDate::format($row['pssearch_added_on']); ?></div>
			</div>
			<div class="results-side">
				<span class="newly-added">20</span>
				<strong><?php echo Labels::getLabel('LBL_New_results', $siteLangId); ?></strong> out of 345
			</div>
		</li>
	  <?php }?>
	</ul>
</div>




<?php
/* $arr_flds = array(
	'listserial'=>'Sr.',
	'pssearch_name' => Labels::getLabel('LBL_Search_Title', $siteLangId),
	'pssearch_url' => Labels::getLabel('LBL_Search_URL', $siteLangId),
	'pssearch_added_on' => Labels::getLabel('LBL_Added_On', $siteLangId),
	'action' => Labels::getLabel('LBL_Action', $siteLangId)
);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => 'hide--mobile'));
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page == 1) ? 0 : ($pageSize*($page-1));
foreach ($arrListing as $sn => $row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' => ''));

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$sr_no,true);
			break;
			case 'pssearch_name':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key], true);
			break;
			case 'pssearch_url':
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key], true);
			break;
			case 'pssearch_added_on':
				$td->appendElement( 'plaintext', array(), '<span class="caption--td">'.$val.'</span>'.FatDate::format($row[$key]),true );
			break;
			case 'action':
				$ul = new HtmlElement( 'ul', array('class'=>'actions'), '<span class="caption--td">' . $val . '</span>', true );
				
				$li = $ul->appendElement( 'li', array(), '');
				$li->appendElement( 'a', array('href'=>'javascript:void(0)', 'title' => Labels::getLabel('LBL_Delete', $siteLangId), 'onClick' => 'deleteSavedSearch(' .$row['pssearch_id']. ')' ), '<i class="fa fa-trash"></i>', true );
				
				$li = $ul->appendElement('li', array(), '');
				$li->appendElement( 'a', array('href' => $row['pssearch_url'], 'title' => Labels::getLabel('LBL_Proceed', $siteLangId), 'target' => '_blank', 'onClick' => 'proceedToSearchPage('.$row['pssearch_id'].')' ), '<i class="fa fa-external-link"></i>', true );
				$td->appendElement('plaintext', array(), $ul->getHtml(), true);
				
			break;
			default:
				$td->appendElement('plaintext', array(), '<span class="caption--td">'.$val.'</span>'.$row[$key],true);
			break;
		}
	}
}
if ( count($arrListing) == 0 ){
	$tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), Labels::getLabel('LBL_No_Record_found', $siteLangId));
}
echo $tbl->getHtml();

$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'callBackJsFunc' => 'goToProductSavedSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false); */
