<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$html = new HtmlElement('ul');

foreach($brands as $key => $value){
	$li=$html->appendElement('li');
	$li->appendElement('a',array('href'=>'javascript:selectBrand('.$key.',"'.$value['brand_name'].'");'),$value['brand_name']);	
}
echo $html->getHtml();