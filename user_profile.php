<?php
	include "common_header.php";
	include "scripts/get_user_info.php";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo($display_name."'s Profile"); ?></title>
</head>
<link rel="stylesheet" href="css/profile_styles.css">

<body>
	<div class="profileContent">
		<?php
			//Title of user's profile
			echo("<h2 class='profileTitle'>".$display_name."'s Profile</h2>");
			echo("Member since: ".$date_joined."<br>");
			echo("Last active: ".$last_login);
		?>
		<div class="profilePic">
			<?php
			//look for profile picture -- if not found, put default pic
			
			?>
			<img src="images/default.png" alt="No profile picture found."> <!-- find profile picture in image_uploads -->
		</div>
		
		<div class="profileBio">
			<?php
			//look for bio -- if not found, fill with default text
			if($bio == null) { //user has not defined a bio
				echo("<p>User has not written a bio.");
			} else {
				echo("<p>".$bio."<p>");
			}
			?>
		</div>
	</div>
</body>
</html>