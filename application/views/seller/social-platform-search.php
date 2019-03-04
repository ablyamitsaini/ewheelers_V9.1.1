<div class="cards-header p-3">
	<h5 class="cards-title"><?php echo Labels::getLabel('LBL_Social_Platforms',$siteLangId);?></h5>
	<div class="action">
		<a href="javascript:void(0)" class="btn btn--primary btn--sm" onclick="addForm(0)"><?php echo Labels::getLabel('LBL_Add_Social_Platform',$siteLangId);?></a>
	</div>
</div>
<div class="cards-content p-3">
<?php
$arr_flds = array(
		'listserial'=>Labels::getLabel('LBL_Sr._no.',$siteLangId),
		'splatform_identifier'=>Labels::getLabel('LBL_Title',$siteLangId),
		'splatform_url'	=>	Labels::getLabel('LBL_URL',$siteLangId),
		'action' => Labels::getLabel('LBL_Action',$siteLangId),
	);
	
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--orders js-scrollable scroll-hint'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arr_listing as $sn=>$row){
	$sr_no++;
	$tr = $tbl->appendElement('tr',array('class' => ($row['splatform_active'] != applicationConstants::ACTIVE) ? 'fat-inactive' : '' ));
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
			break;
			case 'splatform_identifier':
				if($row['splatform_title']!=''){
					$td->appendElement('plaintext', array(), $row['splatform_title'],true);
					$td->appendElement('br', array());
					$td->appendElement('plaintext', array(), '('.$row[$key].')',true);
				}else{
					$td->appendElement('plaintext', array(), $row[$key],true);
				}
			break;		
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"));
				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green', 'title'=>Labels::getLabel('LBL_Edit',$siteLangId),"onclick"=>"addForm(".$row['splatform_id'].")"),'<i class="fa fa-edit"></i>', true);
				$li = $ul->appendElement("li");
				$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green', 'title'=>Labels::getLabel('LBL_Delete',$siteLangId),"onclick"=>"deleteRecord(".$row['splatform_id'].")"),'<i class="fa fa-trash"></i>', true);
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key],true);
			break;
		}
	}
}
if (count($arr_listing) == 0){
	// $tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), 'No records found');
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
} else {
	echo $tbl->getHtml();
}
?>
</div>