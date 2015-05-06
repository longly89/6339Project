<?php
	if (isset($_GET["term"])) {
		$term = $_GET["term"];
		$data = array();
		if (($handle = fopen("restaurant_review", "r")) !== FALSE) {
			while (($line = fgets($handle)) !== FALSE) {
				$json = json_decode($line, true);
				#check only zipcode or city
				$full_address = split("\n",$json["full_address"]);
				$zip = $full_address[count($full_address) - 1];
				
				if (strpos(strtolower($zip), strtolower($term)) !== false) {
					$zip = trim(preg_replace('/[0-9]+/', '', $zip));
					array_push($data, $zip);
					
				}
				
			}
			fclose($handle);
		}
		
		print json_encode(array_unique($data));
	}
?>