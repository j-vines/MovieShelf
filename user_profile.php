<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Profile page for other users */
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
			
			//follow button
			if($following == 0) { //you are not following this user
				echo("<form action='user_profile.php' method='post'>
					<input type='hidden' name='userid' value='".$userid."'>
					<input type='hidden' name='follow' value='1'>
					<input type='submit' value='Follow'>
					</form>");
			} else { //you are following this user
				echo("<form action='user_profile.php' method='post'>
					<input type='hidden' name='userid' value='".$userid."'>
					<input type='hidden' name='unfollow' value='1'>
					<input type='submit' value='Unfollow'>
					</form>");
			}
			
			//following count
			if($follow_num == 1) {
				echo("<br>1 follower<br><br>");
			} else {
				echo("<br>" . $follow_num . " followers<br><br>");
			}
			
		
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
			<img width=80% src="images/default.png" alt="No profile picture found."> <!-- find profile picture in image_uploads -->
		</div>
		
		<div class="profileBio">
			<?php
			//look for bio -- if not found, fill with default text
			if($bio != null) { //user has not defined a bio
				echo("<p>".$bio."</p>");
			}
			?>
		</div>
		</div>
		<?php 
			//only show another user's collection if you're signed in
			if(isset($_COOKIE["user"])) {
				include("scripts/displayCollection.php"); 
				displayCollection();
			} else {
				echo("<h3>Sign in to view ".$display_name."'s collection</h3>");
			}
		
		?>
	</div>
</body>
</html>
<?php include "common_footer.php"; ?>