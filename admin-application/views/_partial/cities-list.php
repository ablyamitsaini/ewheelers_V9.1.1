<?php defined('SYSTEM_INIT') or die('Invalid usage');
echo "<option value = '' >Select</option>";
foreach($statesArr as $id => $cityName){
	$selected = '';
	if($cityId == $id){
		$selected = 'selected';
	}
	echo "<option value='".$id."' ".$selected.">".$cityName."</option>";
}