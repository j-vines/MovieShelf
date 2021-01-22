<?php
	//save the given profile information to the database
	//make sure to process the post information to avoid sql injection
	include "scripts/db_connect.php";

	//update display name
	if($_POST["display_name"] != "") {
		$update_display = "UPDATE user SET display_name = '".$_POST["display_name"]."' WHERE iduser ='".$_COOKIE["user"]."';";
			if($update_display_result = mysqli_query($con, $update_display)) {
				//display name was successfully updated
			} else {
				echo("Display name could not be updated.");
				echo mysqli_error();
			}
	}
	
	//update the bio
	if($_POST["bio"] != "") {
		$update_bio = "UPDATE user SET bio = '".$_POST["bio"]."' WHERE iduser ='".$_COOKIE["user"]."';"; //SOMETHING'S NOT RIGHT HERE
			if($update_bio_result = mysqli_query($con, $update_bio)) {
				//bio was successfully updated
			} else {
				echo("Bio could not be updated.");
				echo mysqli_error();
			}
	}
	include "scripts/db_close.php";
	header("Location: profile.php");
	 
?>