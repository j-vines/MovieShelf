<?php
	session_start();
	include "scripts/db_connect.php";

	//process the $_POST info
	if($_POST["email"] != "" &&
	  $_POST["username"] != "" &&
	  $_POST["password"] != "") {
		
		//check to see if account with certain email already exists
		$email_search = "SELECT COUNT(*) FROM user WHERE email = '".$_POST["email"]."';";
		if($email_search_result = mysqli_query($con, $email_search)) {
			$num_email = mysqli_fetch_array($email_search_result)[0];
		} else {
			echo("No result.");
			echo mysqli_error();
		}

		//check to see if account with certain username already exists
		$user_search = "SELECT COUNT(*) FROM user WHERE username = '".$_POST["username"]."';";
		if($user_search_result = mysqli_query($con, $user_search)) {
			$num_user = mysqli_fetch_array($user_search_result)[0];
		} else {
			echo("No result.");
			echo mysqli_error();
		}

		if($num_email == 0 && $num_user == 0) { //the username and email provided are unique
			echo("New user can be created.");
			
			$user_insert = "INSERT INTO user (username, password, email, joined)
							VALUES ('".$_POST["username"]."', '".$_POST["password"]."', '".$_POST["email"]."', now());";
			if($user_insert_result = mysqli_query($con, $user_insert)) {
				echo("User successfully created!");
			} else {
				echo("User could not be created.");
				echo mysqli_error();
			}
		
		} else { //"reload" signup.php and notify that user already exists
			echo("User already exists.");
			include "signup.php";
		}
		
	} else { //fields were left blank
		echo("You left one or more fields blank!");
		include "signup.php";
	}

	include "scripts/db_close.php";

?>