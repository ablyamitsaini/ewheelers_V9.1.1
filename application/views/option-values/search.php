<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
		'dragdrop'=>'',
		'optionvalue_identifier'=>Labels::getLabel('LBL_OPTION_VALUE_NAME',$langId),			
		'action' => Labels::getLabel('LBL_ACTION',$langId),
	);
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table-responsive', 'id'=>'optionvalues'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arr_listing as $sn=>$row){
	$sr_no++;
	$tr = $tbl->appendElement('tr');
	$tr->setAttribute ("id",$row['optionvalue_id']);	
	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'dragdrop':
				$td->appendElement('i',array('class'=>'fa fa-arrows'));					
				$td->setAttribute ("class",'dragHandle');
			break;
			case 'optionvalue_identifier':
				if($row['optionvalue_name']!=''){
					$td->appendElement('plaintext', array(), $row['optionvalue_name'], true);
					$td->appendElement('br', array());
					$td->appendElement('plaintext', array(), '('.$row[$key].')', true);
				}else{
					$td->appendElement('plaintext', array(), $row[$key], true);
				}
				break;						
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions"));
				
					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=>'javascript:void(0)', 
					'class'=>'button small green', 'title'=>Labels::getLabel('LBL_EDIT',$langId),
					"onclick"=>"optionValueForm(".$row['optionvalue_option_id'].",".$row['optionvalue_id'].")"),'<i class="fa fa-edit"></i>', true);

					$li = $ul->appendElement("li");
					$li->appendElement('a', array('href'=>"javascript:void(0)", 
					'class'=>'button small green', 'title'=>Labels::getLabel('LBL_DELETE',$langId),"onclick"=>"deleteOptionValue(".$row['optionvalue_option_id'].",".$row['optionvalue_id'].")"),'<i class="fa fa-trash"></i>', true);
				
			break;
			default:
				$td->appendElement('plaintext', array(), $row[$key], true);
			break;
		}
	}
}
if (count($arr_listing) == 0){
	$tbl->appendElement('tr')->appendElement('td', array('colspan'=>count($arr_flds)), 
	Labels::getLabel('MSG_NO_RECORD_FOUND',$langId));
}
echo $tbl->getHtml();
?>
<script type="text/javascript">
$(document).ready(function(){
	fcom.resetFaceboxHeight();
});
</script>
<script>
$(document).ready(function(){	
	/* $('#optionvalues').tableDnD({
		onDrop: function (table, row) {
			
			var order = $.tableDnD.serialize('id');			
			fcom.ajax(fcom.makeUrl('OptionValues', 'setOptionsOrder'), order, function (res) {
				var ans =$.parseJSON(res);
				if(ans.status==1)
				{
					$.mbsmessage(ans.msg, true, 'alert alert--success');
				}else{
					$.mbsmessage(ans.msg, true, 'alert alert--danger');
				}
			});
		},
		dragHandle: ".dragHandle",		
	}); */
});
</script>