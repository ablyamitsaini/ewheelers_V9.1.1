<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="sectionhead" >
	<h4><?php echo Labels::getLabel('LBL_Navigation_Listing',$adminLangId); ?></h4>			
</div>
<div class="sectionbody">
	<div class="tablewrap" >
	<?php
	$arr_flds = array(
		'listserial'=> Labels::getLabel('LBL_Sr._No',$adminLangId),
		'nav_identifier'=> Labels::getLabel('LBL_Title',$adminLangId),
		'nav_active'	=>	Labels::getLabel('LBL_Status', $adminLangId),
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
		$tr = $tbl->appendElement( 'tr',array() );
		foreach ($arr_flds as $key=>$val){
			$td = $tr->appendElement('td');
			switch ($key){
				case 'listserial':
					$td->appendElement('plaintext', array(), $sr_no);
				break;
				case 'nav_identifier':
					if($row['nav_name']!=''){
						$td->appendElement('plaintext', array(), $row['nav_name'],true);
						$td->appendElement('br', array());
						$td->appendElement('plaintext', array(), '('.$row[$key].')',true);
					} else {
						$td->appendElement('plaintext', array(), $row[$key],true);
					}
				break;
				case 'nav_active':
					$active = "";
					if( $row['nav_active'] ) {
						$active = 'checked';
					}
					$statusAct = ( $canEdit === true ) ? 'toggleStatus(event,this,' .applicationConstants::YES. ')' : 'toggleStatus(event,this,' .applicationConstants::NO. ')';
					$statusClass = ( $canEdit === false ) ? 'disabled' : '';
					$str='<label class="statustab -txt-uppercase">
                     <input '.$active.' type="checkbox" id="switch'.$row['nav_id'].'" value="'.$row['nav_id'].'" onclick="'.$statusAct.'" class="switch-labels"/>
                    <i class="switch-handles '.$statusClass.'"></i> </label>';
					$td->appendElement('plaintext', array(), $str,true);
				break;
				case 'action':
								$ul = $td->appendElement("ul",array("class"=>"actions actions--centered"));

					$li = $ul->appendElement("li",array('class'=>'droplink'));
					$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
              		$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));
              		$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
					if($canEdit){
              		$innerLiEdit=$innerUl->appendElement('li');
						$innerLiEdit->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green', 'title'=>Labels::getLabel('LBL_Edit',$adminLangId),"onclick"=>"addFormNew(".$row['nav_id'].")"),Labels::getLabel('LBL_Edit',$adminLangId), true);
						
					}
						$innerLiPages = $innerUl->appendElement("li");
						$innerLiPages->appendElement('a', array('href'=>"javascript:void(0)", 'class'=>'button small green', 'title'=>Labels::getLabel('LBL_Pages',$adminLangId),"onclick"=>"pages(".$row['nav_id'].")"),Labels::getLabel('LBL_Pages',$adminLangId), true);
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
	</div> 
</div>	