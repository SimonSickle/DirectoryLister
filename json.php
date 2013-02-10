<?php 

$ip = $_SERVER['REMOTE_ADDR'];

$x = 1; 

$ar = array();

foreach($lister->listDirectory() as $name=>$fileInfo) {

if(is_dir($fileInfo['file_path'])) {
	$dirarray = array(
		"type"=>"folder",
		"directory"=>$fileInfo['file_path'],
		"name"=>$name,
	);
} else {
	$filearray = array(
		"type"=>"file",
		"path"=>$fileInfo['file_path'],
		"name"=>$name,
	);
}

$ar = array_merge($dirarray, $filearray);
}
var_dump($ar);

?>
