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
			echo mysqli_error($con);
		}

		//check to see if account with certain username already exists
		$user_search = "SELECT COUNT(*) FROM user WHERE username = '".$_POST["username"]."';";
		if($user_search_result = mysqli_query($con, $user_search)) {
			$num_user = mysqli_fetch_array($user_search_result)[0];
		} else {
			echo("No result.");
			echo mysqli_error($con);
		}

		if($num_email == 0 && $num_user == 0) { //the username and email provided are unique

			$user_insert = "INSERT INTO user (username, password, display_name, email, joined, last_login)
							VALUES ('".$_POST["username"]."', '".$_POST["password"]."', '".$_POST["username"]."', '".$_POST["email"]."', now(), now());";
			if($user_insert_result = mysqli_query($con, $user_insert)) {
				$id_get = "SELECT iduser FROM user WHERE username = '".$_POST["username"]."';";
				if($id_get_result = mysqli_query($con, $id_get)) {
					$id = mysqli_fetch_array($id_get_result)[0];
					setcookie("user", $id, time() + 86400, "/"); //user cookie has value of user's id.
				} else {
					echo("User ID not found.");
					echo mysqli_error($con);
				}
				
			} else {
				echo("User could not be created.");
				echo mysqli_error($con);
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