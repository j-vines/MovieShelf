<?php 
	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Profile</title>
</head>

<body>
	<form autocomplete="off" action="save_profile.php" method="post">
		<label for="display_name">Display Name:</label>
		<input type="text" id="display_name" name="display_name"> <!-- NEEDS PATTERN -->
		<br>
		<label for="bio">Bio:</label>
		<textarea maxlength="250" rows = "5" cols = "60" name = "bio">
            Write something about yourself...
        </textarea>
		<br>
			
		<input type="submit" value="Save Changes">
		
	
	
</body>
</html>