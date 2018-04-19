<?php
class CustomRouter{	
	static function setRoute(&$controller, &$action, &$queryString){
		if(defined('SYSTEM_FRONT') && SYSTEM_FRONT === true && !FatUtility::isAjaxCall()){
			
			$url = $_SERVER['REQUEST_URI'];			
			
			$url = substr($url, strlen(CONF_WEBROOT_URL));
			$url = rtrim($url, '/');
			
			$srch = UrlRewrite::getSearchObject();
			$srch->addCondition(UrlRewrite::DB_TBL_PREFIX . 'custom', 'LIKE', $url);
			$rs = $srch->getResultSet();
			if (!$row = FatApp::getDb()->fetch($rs)) {
				return;
			}
			
			$url = $row['urlrewrite_original'];
			$arr = explode('/', $url);
			
			$controller = (isset($arr[0]))?$arr[0]:'';
			array_shift($arr);
			
			$action = (isset($arr[0]))?$arr[0]:'';
			array_shift($arr);
			
			$queryString = $arr;
			
			if ($controller != '' && $action == '') { $action = 'index';}
			
			if ($controller == '') { $controller = 'Content'; }
			
			if ($action == ''){ $action = 'error404'; }
			
		}
	}
	
}	