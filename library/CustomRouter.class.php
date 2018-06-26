<?php
class CustomRouter{	
	static function setRoute(&$controller, &$action, &$queryString){		
		$userType = null;		
		if ('mobile-app-api' == $controller) {			
			define('MOBILE_APP_API_CALL', true);
            define('MOBILE_APP_API_VERSION', 'v1');
		}else if ('app-api' == $controller) {
			$controller = 'mobile-app-api';
			define('MOBILE_APP_API_CALL', true);
			define('MOBILE_APP_API_VERSION', $action);
			
			if (!array_key_exists(0, $queryString)) {
                $queryString[0] = '';
            }
            if (!array_key_exists(1, $queryString)) {
                $queryString[1] = '';
            }
			
            $action = $queryString[0];            
			if ($controller != '' && $action == '') { $action = 'index';}
            array_shift($queryString);	
			
			$token = null;
            
			if(array_key_exists('HTTP_X_USER_TYPE',$_SERVER)){
				$userType = intval($_SERVER['HTTP_X_USER_TYPE']);
			}
			
			if(array_key_exists('HTTP_X_TOKEN',$_SERVER)){
				$token = ($_SERVER['HTTP_X_TOKEN'] != '')?$_SERVER['HTTP_X_TOKEN']:null;
			}
			
            /* if (isset($_SERVER['HTTP_X_USER_TYPE'])) {
                $userType = intval($_SERVER['HTTP_X_USER_TYPE']);
            }
            if (isset($_SERVER['HTTP_X_TOKEN']) && !empty($_SERVER['HTTP_X_TOKEN'])) {
                $token = $_SERVER['HTTP_X_TOKEN'];
            } */

            if ($token) { 
                if (!UserAuthentication::doAppLogin($token)) {                    
					$arr = array('status'=>-1,'msg'=>"Invalid Token");	
					die(json_encode($arr));	
                }
            }	
		}else {
            define('MOBILE_APP_API_CALL', false);
            define('MOBILE_APP_API_VERSION', '');
        }
		
		define('MOBILE_APP_USER_TYPE', $userType);
		
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