<?php
class DummyController extends AdminBaseController {

	public function index() {
		
		$srch = Product::getSearchObject($this->adminLangId);
		$cnd = $srch->addCondition('product_id','>','5');
		$cnd->attachCondition('mysql_func_product_brand_id','>=','mysql_func_product_added_by_admin_id','OR',true);
		echo $srch->getQuery(); exit;
		echo time();
		$arr1 = array('a'=>'1');
		$arr2 = array('b'=>'2');
		array_push($arr1,$arr2);
		var_dump($arr1);
		
		exit;
		
		
		echo "<br>";
		echo $colCount++;
		echo "<br>";
		echo $colCount++;		exit;
		$arr = unserialize(FatApp::getConfig('CONF_COMPLETED_ORDER_STATUS')); 
		var_dump($arr);
		exit;
		
		$statsObj = new Statistics();
		$data = $statsObj->getTopProducts('YEARLY');
		var_dump($data);	
	}

}