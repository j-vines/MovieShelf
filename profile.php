<?php 
	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Profile</title>
</head>
<body>
	<div class="profileContent">
		<?php
			echo("<h2 class='profileTitle'>".$_COOKIE["user"]."'s Profile<h2>");
		?>
	</div>
	
</body>
</html>
