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

			#myCanvas
			{
				display: block;
				margin: 0 auto;
			}

			.myButton{
				 background: url('img/search.png');
				 background-size: 100% 100%;
			}
			
		</style>
	</head>
	<body>
		<form action="index.php" method="POST"	>
			Find: <input type="text" name="find" id="find">
			<input type="submit" class="myButton" value="">
			<input type="hidden" name="name" id="name" value="">
		</form>

		<canvas id="myCanvas" width="1200" height="1000" style="border:0	px solid #c3c3c3;">
					Your browser does not support the HTML5 canvas tag.
		</canvas>

		<script>
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

			function drawIcon(x, y, category) {
				var c = document.getElementById("myCanvas");
				var ctx = c.getContext("2d");
				var width = 300;  //fix length of a bar
				var height = 50; //fix length of a bar
				x = 50;
				
				var up = new Image();
				up.onload = function() {
					ctx.drawImage(up, x - 45, y - 25, 20, 20);
				};
				up.src = "img/up.png";
				
				var down = new Image();
				down.onload = function() {
					ctx.drawImage(down, x + width - 35, y - 25, 20, 20);
				};
				down.src = "img/down.png";

				ctx.font = "bold 15px Comic Sans MS";
				ctx.fillStyle = "blue";
				ctx.textAlign = "center";
				ctx.fillText(category, 175, y - 5);
			}
			
			function drawGraph(x,y,pos,neg,count,category) {
				var c = document.getElementById("myCanvas");
				var ctx = c.getContext("2d");
				var width = 300;  //fix length of a bar
				var height = 50; //fix length of a bar
				
				ctx.beginPath();
				ctx.strokeStyle="black";
				ctx.rect(x,y,width,height);
				ctx.stroke();
				
				var red_width = pos / (count * 2) * 150;
				ctx.beginPath();
				ctx.rect(x + width / 2 - red_width,y,red_width,height);
				ctx.fillStyle="greenyellow";
				ctx.fill(); 		
				ctx.stroke();

				var green_width = neg / (count * -2) * 150;
				ctx.beginPath();
				ctx.rect(x + width / 2,y,green_width,height);
				ctx.fillStyle="red";
				ctx.fill(); 		
				ctx.stroke();				
			}
			
			function drawTitle(name, address, zip, count) {
				var c = document.getElementById("myCanvas");
				var ctx = c.getContext("2d");
				ctx.font = "bold 30px Times New Roman";
				ctx.fillStyle = "red";
				ctx.textAlign = "center";
				ctx.fillText(name, name.length * 8, 50); 	
				
				ctx.font = "bold 15px Times New Roman";
				ctx.fillStyle = "grey";
				ctx.textAlign = "left";
				ctx.fillText(count + " reviews", name.length * 17, 50); 	
				
				
				ctx.font = "bold 20px Times New Roman";
				ctx.fillStyle = "black";
				ctx.textAlign = "left";
				ctx.fillText(address, 20, 80); 	
				ctx.fillText(zip, 20, 110); 
				
				
			}

		</script>
		<?php
			if ($_POST["id"]) {
				$id = $_POST["id"];
				$data = array();
				if (($handle = fopen("restaurant_review", "r")) !== FALSE) {
					while (($line = fgets($handle)) !== FALSE) {
						$json = json_decode($line, true);
						if (strcmp($json["business_id"], $id) == 0) {
							break;
						}
					}
					fclose($handle);
						
					$count = $json["num_rating"];
				}
				
				$name = $json["name"];
				list($address, $zip) = split("\n",$json["full_address"]);
				echo '<script> drawTitle("'.$name.'","'.$address.'","'.$zip.'", '.$count.'); </script>';
				
				$x = 20;
				$y = 200;
				$categories = ['Food', 'Service', 'Decoration', 'Cleanliness'];
				
				for ($i = 0; $i < 4; $i++) {
					$pos = $json["rating"][$i * 2];
					$neg = $json["rating"][$i * 2 + 1];

					echo "<script> drawGraph($x, $y, $pos, $neg, ".$json["num_rating"].",'$categories[$i]'); </script>";
					echo "<script> drawIcon($x, $y, '$categories[$i]'); </script>";
					
					
					$y += 80;
				}
				
			}
			
			
		?>
	</body>
</html>