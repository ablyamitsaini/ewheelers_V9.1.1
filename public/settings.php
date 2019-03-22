<?php 
// DB
define('CONF_WEBROOT_FRONTEND', '/');
define('CONF_WEBROOT_BACKEND', '/admin/');
if(file_exists(dirname(__DIR__) . '/conf/'.$_SERVER['SERVER_NAME'].'.php')){
	require_once(dirname(__DIR__) . '/conf/'.$_SERVER['SERVER_NAME'].'.php');
	/* 	define('CONF_DB_SERVER', 'localhost');
		define('CONF_DB_USER', 'staging');
		define('CONF_DB_PASS', 'staging');
		define('CONF_DB_NAME', 'staging_yokart_v8_1_test');
	 */	
}else{	
	//die('Domain specific settings file missing');
	define('CONF_DB_SERVER', 'localhost');
	define('CONF_DB_USER', 'staging');
	define('CONF_DB_PASS', 'staging');
	define('CONF_DB_NAME', 'staging_yokart_v8_1');
}
?>
