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
		<script>
			$(function() {
				$( "#find" ).autocomplete({
				  source: "readData.php",
				  minLength: 3,
				  select: function(event, ui) {
					  $temp = ui.item.id;
				  }
				});
			});

			$(function() {
				$( "#location" ).autocomplete({
				  source: "readData.php",
				  minLength: 3
				});
			  });
			
			function searchFunction(){
				alert($temp);
			}
		</script>
	</head>
	<body>
	 
		<div class="ui-widget">
				Find: <input type="text" name="find" id="find">
				Near: <input type="text" name="location" id="location">
				<input type="submit" class="myButton" value="" onclick="searchFunction()">
		</div>

	</body>
</html>