<?php
	include "scripts/db_connect.php";

	setcookie("signup_error", "", time() - 86400, "/"); //unset signup error cookie for each sign up attempt
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

			$user_insert = "INSERT INTO user (username, password, email, joined)
							VALUES ('".$_POST["username"]."', '".$_POST["password"]."', '".$_POST["email"]."', now());";
			if($user_insert_result = mysqli_query($con, $user_insert)) {
				setcookie("user", $_POST["username"], time() + 86400, "/"); //user cookie has value of user's username.
			} else {
				echo("User could not be created.");
				echo mysqli_error();
			}
		
		} else { //"reload" signup.php and notify that user already exists
			setcookie("signup_error", "That username or email taken.", time() + 86400, "/");
			include "scripts/db_close.php";
			header("Location: signup.php");
			
		}
		
	} else { //fields were left blank
		setcookie("signup_error", "You left one or more fields blank.", time() + 86400, "/");
		include "scripts/db_close.php";
		header("Location: signup.php");
	}

	include "scripts/db_close.php";
	header("Location: index.php");

?>