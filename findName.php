<?php
	if (isset($_GET["term"])) {
		$term = $_GET["term"];
		$data = array();
		if (($handle = fopen("restaurant_name", "r")) !== FALSE) {
			while (($line = fgetcsv($handle)) !== FALSE) {
				if (strpos(strtolower($line[1]), strtolower($term)) !== false) {
					array_push($data, $line[1]);
				}
			}
			fclose($handle);
		}
		
		print json_encode(array_unique($data));
	}
?>