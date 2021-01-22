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
		
			echo("<h2 class='profileTitle'>".$username."'s Profile</h2>");
		?>
		<!-- Links to form for editing user profile -->
		<a href = 'edit_profile.php'> Edit </a>
		<div class="profilePic">
			<?php
			//look for profile picture -- if not found, put default pic
			
			?>
			<img src="default.png" alt="No profile picture found."> <!-- find profile picture in image_uploads -->
		</div>
		
		<div class="profileBio">
			<?php
			//look for bio -- if not found, fill with default text
			include "scripts/db_connect.php";
			
			$bio_search = "SELECT bio FROM user WHERE iduser ='".$_COOKIE["user"]."';";
			if($bio_search_result = mysqli_query($con, $bio_search)) {
				$bio = mysqli_fetch_array($bio_search_result)[0];
			} else {
				echo("No result.");
				echo mysqli_error();
			}
			
			if($bio == null) { //user has not defined a bio
				echo("<p>You have not written a bio.");
			} else {
				echo("<p>".$bio."<p>");
			}
			?>
		</div>
	</div>
	
</body>
</html>
