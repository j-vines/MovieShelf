<?php 

/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Page that contains form for updating information visible on a user's profile */

	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Your Profile</title>
</head>

<body>
	<div class="mainContent">
	<form autocomplete="off" action="save_profile.php" method="post" enctype="multipart/form-data">
		<label for="display_name">Display Name:</label>
		<input type="text" id="display_name" name="display_name"> <!-- NEEDS PATTERN -->
		<br>
		<label for="bio">Bio:</label>
		<textarea maxlength="250" rows = "5" cols = "60" id="bio" name = "bio"></textarea>
		<br>
		<!--<label for="pic">Profile picture:</label>
		<input type="file" id="pic" name="pic">
		<br>-->
		<input type="submit" value="Save Changes">
	</form>
	</div>
	
	
</body>
</html>
<?php include "common_footer.php"; ?>