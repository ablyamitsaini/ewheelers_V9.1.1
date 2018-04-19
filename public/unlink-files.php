<?php 

 /* $dir = str_replace('test','bwmarts/',$_SERVER['DOCUMENT_ROOT']); */
 $dir = $_SERVER['DOCUMENT_ROOT'].'/user-uploads/caching/yokartv81anuprawat4demobiz/ke';
 $arr = scandir($dir);
 if(!empty($arr)){
	foreach($arr as $val){
		$file = $dir.'/'.$val;
		if(is_file($file)){
			unlink($file);
		}else{
			rmdir($file);
		}
	}
 }
?>