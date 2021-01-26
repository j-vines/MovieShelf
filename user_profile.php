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
			echo("Member since: ".date("F d, Y", strtotime($date_joined))."<br>");
			
			//display when user was last active
			$days = floor((strtotime(date("Y-m-d")) - strtotime($last_login))/(60*60*24));

			if($days == 0) { //user active less than 24 hours ago
				echo("Last active: today");
			} else if($days == 1) {
				echo("Last active: yesterday");
			} else { //user last active more than 1 day ago
				echo("Last active: ".$days." days ago");
			}
			
		?>
		<div class="personalInfo">
		<div class="profilePic">
			<?php
			//look for profile picture -- if not found, put default pic
			
			?>
			<img width=80% src="images/default.png" alt="No profile picture found."> <!-- find profile picture in image_uploads -->
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
	</div>
</body>
</html>