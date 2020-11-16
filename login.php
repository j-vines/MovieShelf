<?php
	session_start();
	include "scripts/db_connect.php";
	
	$user_exists = false;

	//process POST info
	if($_POST["username"] != "" &&
	  $_POST["password"] != "") {
		
		$user_search = "SELECT COUNT(*) FROM user WHERE username = '".$_POST["username"]."';";
		if($user_search_result = mysqli_query($con, $user_search)) {
			$num_user = mysqli_fetch_array($user_search_result)[0];
			
			if($num_user != 0) { //username exists in database
				$password_search = "SELECT password FROM user WHERE username = '".$_POST["username"]."';";
				
				if($password_search_result = mysqli_query($con, $password_search)) {
					$password = mysqli_fetch_array($password_search_result)[0];

					if($password == $_POST["password"]) { //password in record matches given password
						echo("Successfully able to log in!");
						
					} else { //user exists but password is incorrect
						echo("Incorrect password.");
					}
					
				} else {
					echo("Password not found.");
					echo mysqli_error();
				}
					
			} else { //provided username not found in database
				echo("No such user exists.");
			}
			
		} else {
			echo("No result.");
			echo mysqli_error();
		}
	
	} else { //fields left blank
		echo("You left one or more fields blank.");
	}

	include "scripts/db_close.php";

?>