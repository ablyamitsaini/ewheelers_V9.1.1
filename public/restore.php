<?php 
require_once 'settings.php';
require_once dirname(__DIR__) . '/conf/conf.php';
//require_once dirname(__FILE__) . '/application-top.php';

function recursiveDelete($str) {
    if (is_file($str)) {
        return @unlink($str);
    }
    elseif (is_dir($str)) {
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path) {
            recursiveDelete($path);
        }
        return @rmdir($str);
    }
}

function full_copy( $source, $target,$empty_first=true) {
	if ($empty_first){	
		recursiveDelete($target);
	}
	
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }else {
        copy( $source, $target );
    }
}

function restoreDatabase($backupFile,$concate_path=true) {
	$db_server = CONF_DB_SERVER;
	$db_user = CONF_DB_USER;
	$db_password = CONF_DB_PASS;
	$db_databasename = CONF_DB_NAME;
	$mysqli = connectDatabase();
	$sql = "SHOW TABLES FROM $db_databasename";
	if($rs = $mysqli->query($sql)){
		  while($row = $rs->fetch_array()){
				$table_name=$row["Tables_in_".$db_databasename];
				 $mysqli->query("DROP TABLE $db_databasename.$table_name");
		  }
	}
	$cmd ="mysql --user=" . $db_user . " --password='" . $db_password . "' " . $db_databasename . " < " . $backupFile;
	//return system($cmd);	
	exec($cmd, $out, $status);
	if (0 === $status) {
		echo "Database restored.<br/>";
	} else {
		echo "Database restore failed with status: $status"; exit;
	}	
}


function isAutoRestoreEnabled(){
	$db_server = CONF_DB_SERVER;
	$db_user = CONF_DB_USER;
	$db_password = CONF_DB_PASS;
	$db_databasename = CONF_DB_NAME;
	$mysqli = connectDatabase();
	$sql = "SELECT * FROM `tbl_configurations` WHERE `conf_name` = 'CONF_AUTO_RESTORE_ON'";
	$rs = $mysqli->query($sql);
	$row = $rs->fetch_assoc();
	if(!empty($row) && $row['conf_val'] > 0){
		return true;
	}
	return false;
}

function restoreCssThemeFiles(){	
	$theme_detail = array(
		'tcolor_first_color'=>'FF3A59',
		'tcolor_second_color'=>'2D9FF3',
		'tcolor_third_color'=>'FFFFFF',
		'tcolor_text_color'=>'333333',
		'tcolor_text_light_color'=>'999999',
		'tcolor_border_first_color'=>'DCDCDC',
		'tcolor_border_second_color'=>'FFFFFF',
		'tcolor_second_btn_color'=>'FFFFFF',
		'tcolor_header_text_color'=>'FFFFFF',
	);
	
	$filesArr =  array(
		'common-css/1base.css'=>'css/css-templates/1base.css',
		'common-css/2nav.css'=>'css/css-templates/2nav.css',
		'common-css/3skeleton.css'=>'css/css-templates/3skeleton.css',
		'common-css/4phone.css'=>'css/css-templates/4phone.css'
	);
	
	foreach ($filesArr as $fileKey => $fileName){
		$str = '';	
		
		if (substr($fileName, '-4') != '.css'){
			continue;
		}	
		
		$oldFile = CONF_THEME_PATH . $fileName;
		
		if (file_exists($oldFile)){
			$str .= file_get_contents($oldFile);
		}
		
		$newFileName = CONF_THEME_PATH.$fileKey;
		$newFile = fopen($newFileName, 'w');
		
		$replace_arr = array(
			"var(--first-color)"=>$theme_detail['tcolor_first_color'],
			"var(--second-color)"=>$theme_detail['tcolor_second_color'],
			"var(--third-color)"=>$theme_detail['tcolor_third_color'],
			"var(--txt-color)"=>$theme_detail['tcolor_text_color'],
			"var(--txt-color-light)"=>$theme_detail['tcolor_text_light_color'],
			"var(--border-color)"=>$theme_detail['tcolor_border_first_color'],
			"var(--border-color-second)"=>$theme_detail['tcolor_border_second_color'],
			"var(--second-btn-color)"=>$theme_detail['tcolor_second_btn_color'],			
			"var(--header-txt-color)"=>$theme_detail['tcolor_header_text_color'],			
		);
			
		foreach ($replace_arr as $key => $val) {
			$str = str_replace($key, "#".$val, $str);
		}
		fwrite($newFile, $str);	
	}	
}

function connectDatabase(){
	$db_server = CONF_DB_SERVER;
	$db_user = CONF_DB_USER;
	$db_password = CONF_DB_PASS;
	$db_databasename = CONF_DB_NAME;
	$mysqli = new mysqli($db_server, $db_user,$db_password , $db_databasename);
	return $mysqli;
}

try{
	if(false === isAutoRestoreEnabled()){
		throw new Exception('Auto restore disabled by admin!');
	}		
	
	if(!isset($_GET['passkey']) || $_GET['passkey']!='fatbit2017') {		
		throw new Exception('Access denied!!');
	}
	
	set_time_limit(0);
	
	$source = CONF_INSTALLATION_PATH."restore/user-uploads";
	$target = CONF_UPLOADS_PATH;
	echo 'source:'.$source.'<br>target:-'.$target;
	//full_copy($source,$target);
	echo "Uploads folder restored.<br/>";  
	
	$f = fopen(CONF_UPLOADS_PATH.'database-restore-progress.txt', 'w');
	$rs = fwrite($f, time());
	fclose($f);
	
	echo $file = CONF_INSTALLATION_PATH."restore/database/db_withdata.sql";
	//echo $file = CONF_INSTALLATION_PATH."restore/database/yokart-db.sql";
	echo "Database restore in-process...<br/>"; 
	restoreDatabase($file,false);
			
	@unlink(CONF_UPLOADS_PATH.'database-restore-progress.txt');
	
}catch(Exception $e) {
   echo $e->getMessage();
} ?>