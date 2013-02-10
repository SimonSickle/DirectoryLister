<?php

function directoryToArray($directory, $recursive) {
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
					}
					$file = $directory . "/" . $file;
					$array_items[] = $file;
				} else {
					$file = $directory."/".$file;
					$array_items[] = $file;
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}

header('Content-type: application/json');
echo str_replace("//", "/", str_replace("\/", "/", json_encode(directoryToArray("./", "y"))));


?>
