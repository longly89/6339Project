<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<style>
			.ui-autocomplete {
				max-height: 200px;
				overflow-y: auto;
				overflow-x: hidden;
			}
			.myButton{
				 background: url('img/search.png');
				 background-size: 100% 100%;
			}
		</style>
		
	</head>
	<body>
	 
		<div class="ui-widget">
			<form action="index.php" method="POST"	>
				Find: <input type="text" name="find" id="find">
				Near: <input type="text" name="location" id="location">
				<input type="submit" class="myButton" value="">
				<input type="hidden" name="name" id="name" value="">
				<input type="hidden" name="address" id="address" value="">
				
			</form>
			<script type="text/javascript">
				$(function() {
					$( "#find" ).autocomplete({
						source: "findName.php",
						minLength: 2,
						select: function(event, ui) {
							document.getElementById("name").value = ui.item.label;
					  }
					});
				});

				$(function() {
					$( "#location" ).autocomplete({
						source: "findLocation.php",
						minLength: 1,
						select: function(event, ui) {
							document.getElementById("address").value = ui.item.label;
					  }
					});
				});

			</script>
			
			<?php
				if (isset($_POST["name"]) && isset($_POST["address"])) {
					$name = $_POST["name"];
					$address = $_POST["address"];
					if (strcmp($name, "") != 0 && strcmp($address, "") != 0) {
						$data = array();
						if (($handle = fopen("restaurant_review", "r")) !== FALSE) {
							while (($line = fgets($handle)) !== FALSE) {
								$json = json_decode($line, true);
								$full_address = split("\n",$json["full_address"]);
								$zip = $full_address[count($full_address) - 1];
								if (strpos(strtolower($zip), strtolower($address)) !== false
									&& strpos(strtolower($json["name"]), strtolower($name)) !== false) {
										array_push($data, $json);
								}
								
							}
							fclose($handle);
						}
						
						$count = 1;
						foreach ($data as $obj) {
							echo '<br>';
							$text = $count.'. '.$obj["name"].' ('.$obj["full_address"].')';
							echo '<form id="form'.$count.'" action="restaurant.php" method="POST">';
							echo '<input type="hidden" name="id" id="id" value="'.$obj["business_id"].'">';
							echo '<a href="javascript:{}" onclick="document.getElementById(\'form'.$count.'\').submit();"> '.$text.'</a>';
							echo '</form>';
							
							
							$count++;
						}
					}
				}
			?>
			
		</div>
	</body>
</html>