<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arr_flds = array(
		'dragdrop'=>'',
		'listserial'=> Labels::getLabel('LBL_Sr._No',$adminLangId) ,
		'currency_code'=> Labels::getLabel('LBL_Currency',$adminLangId) ,	
		'currency_symbol_left'=> Labels::getLabel('LBL_Symbol_Left',$adminLangId),	
		'currency_symbol_right'=> Labels::getLabel('LBL_Symbol_Right',$adminLangId),	
		'currency_active'=> Labels::getLabel('LBL_Status',$adminLangId),	
		'action' => Labels::getLabel('LBL_Action',$adminLangId),
	);
if(!$canEdit){
	unset($arr_flds['dragdrop']);
}
$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table table--hovered table-responsive','id'=>'currencyList'));
$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
	$e = $th->appendElement('th', array(), $val);
}

$sr_no = 0;
foreach ($arr_listing as $sn=>$row){
	$sr_no++;
	$tr = $tbl->appendElement('tr', array());
	$tr->setAttribute ("id",$row['currency_id']);

	foreach ($arr_flds as $key=>$val){
		$td = $tr->appendElement('td');
		switch ($key){
			case 'dragdrop':
				if( $row['currency_active'] == applicationConstants::ACTIVE ){				
					$td->appendElement('i',array('class'=>'ion-arrow-move icon'));					
					$td->setAttribute ("class",'dragHandle');
				}
			break;
			case 'listserial':
				$td->appendElement('plaintext', array(), $sr_no);
			break;
			case 'currency_symbol_left':
				$td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable( $adminLangId, $row[$key] ), true);
			break;
			case 'currency_symbol_right':
				$td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable( $adminLangId, $row[$key] ), true);
			break;
			case 'currency_active':
				$active = "active";
				if( !$row['currency_active'] ) {
					$active = '';
				}
				$statucAct = ( $canEdit === true ) ? 'toggleStatus(this)' : '';
				$str = '<label id="'.$row['currency_id'].'" class="statustab '.$active.'" onclick="'.$statucAct.'">
				<span data-off="'. Labels::getLabel('LBL_Active', $adminLangId) .'" data-on="'. Labels::getLabel('LBL_Inactive', $adminLangId) .'" class="switch-labels"></span>
				<span class="switch-handles"></span>
				</label>';
				$td->appendElement('plaintext', array(), $str,true);
			break;			
			case 'currency_code':
				if($row['currency_name']!=''){
					$td->appendElement('plaintext', array(), $row['currency_name'],true);
					$td->appendElement('br', array());
					$td->appendElement('plaintext', array(), '('.$row[$key].')',true);
				}else{
					$td->appendElement('plaintext', array(), $row[$key],true);
				}
			break;		
			case 'action':
				$ul = $td->appendElement("ul",array("class"=>"actions actions--centered"));
				if($canEdit){
					$li = $ul->appendElement("li",array('class'=>'droplink'));						
    			    $li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
					$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));	
					$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
              		
					$innerLi=$innerUl->appendElement('li');
					$innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId),"onclick"=>"editCurrencyForm(".$row['currency_id'].")"),Labels::getLabel('LBL_Edit',$adminLangId), true);						
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
?>
<script>
$(document).ready(function(){	
	$('#currencyList').tableDnD({		
		onDrop: function (table, row) {
			fcom.displayProcessing();
			var order = $.tableDnD.serialize('id');
			fcom.ajax(fcom.makeUrl('CurrencyManagement', 'updateOrder'), order, function (res) {
				var ans =$.parseJSON(res);
				if(ans.status==1)
				{
					fcom.displaySuccessMessage(ans.msg);
				}else{
					fcom.displayErrorMessage(ans.msg);
				}
			});
		},
		dragHandle: ".dragHandle",		
	});
});
</script>