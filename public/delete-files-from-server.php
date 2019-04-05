<?php 
function removeFileAndDirectories($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir); 
		foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
				if (is_dir($dir."/".$object)){
					echo $dir."/".$object.'<br>';	
					removeFileAndDirectories($dir."/".$object);
				}else{
					echo $dir."/".$object.'<br>';
					unlink($dir."/".$object); 
				}
			} 
		}
		rmdir($dir); 
	}
}
$fileUrl = $_SERVER['DOCUMENT_ROOT'].'/user-uploads';
removeFileAndDirectories($fileUrl);
?>