<?php defined('SYSTEM_INIT') or die('Invalid usage');

$optionsString = '<option value="">'.Labels::getLabel("LBL_Select_State", $siteLangId).'</option>';
foreach( $statesArr as $state ){
	$id = $state['state_id'];
	$selected = '';
    $stateName = $state['state_name'];
    $stateCode = $state['state_code'];
	if( $stateId == $id ){
		$selected = 'selected';
	}
	$optionsString .= "<option value='".$id."' ".$selected." state-code=".$stateCode.">".$stateName."</option>";
}

echo $optionsString;