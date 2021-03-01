<?php
	//save the given profile information to the database
	//make sure to process the post information to avoid sql injection
	include "scripts/db_connect.php";

	//update display name
	if($_POST["display_name"] != "") {
		$_POST["display_name"] = mysqli_real_escape_string($con, $_POST["display_name"]);
		$update_display = "UPDATE user SET display_name = '".$_POST["display_name"]."' WHERE iduser ='".$_COOKIE["user"]."';";
			if($update_display_result = mysqli_query($con, $update_display)) {
				//display name was successfully updated
			} else {
				echo("Display name could not be updated.");
				echo mysqli_error($con);
			}
	}
	
	//update the bio --> BIOS THAT HAVE APOSTROPHE'S ARE NOT BEING CREATED.
	if($_POST["bio"] != "") {
		$_POST["bio"] = mysqli_real_escape_string($con, $_POST["bio"]);
		$update_bio = "UPDATE user SET bio = '".$_POST["bio"]."' WHERE iduser ='".$_COOKIE["user"]."';"; //SOMETHING'S NOT RIGHT HERE
			if($update_bio_result = mysqli_query($con, $update_bio)) {
				//bio was successfully updated
			} else {
				echo("Bio could not be updated.");
				echo mysqli_error($con);
			}
	}

	//update the profile picture
	//THIS DOES NOT CURRENTLY WORK, PERMISSION DENIED ON ARDEN
	/*$target_dir = "image_uploads/";
	$file_name = basename($_FILES["pic"]["name"]);
	echo($file_name);
	$target_file = $target_dir . $file_name;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is an actual image or fake image
	if(isset($_POST["submit"])) {
  		$check = getimagesize($_FILES["pic"]["tmp_name"]);
  		if($check !== false) {
    		echo "File is an image - " . $check["mime"] . ".";
    		$uploadOk = 1;
  		} else {
    		echo "File is not an image.";
    		$uploadOk = 0;
  		}
	}
	
	// Check if file already exists
	if (file_exists($target_file)) {
  		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["pic"]["size"] > 500000) {
  		echo "Sorry, your file is too large.";
  		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  		echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
  		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
  		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
  		if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
			echo "The file ". htmlspecialchars( basename( $_FILES["pic"]["name"])). " has been uploaded.";
  		} else {
			echo "Sorry, there was an error uploading your file.";
  		}
	}*/

	include "scripts/db_close.php";
	header("Location: profile.php");
	 
?>