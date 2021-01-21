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
			//Title of user's profile
			include "scripts/get_display_name.php";
		
			echo("<h2 class='profileTitle'>".$username."'s Profile<h2>");
		?>
		<!-- Links to form for editing user profile -->
		<a href = 'edit_profile.php'> Edit </a>
		<div class="profilePic">
		</div>
		<div class="profileBio">
		</div>
	</div>
	
</body>
</html>
