<?php
	include "scripts/db_connect.php";
	
	$user_exists = false;
	setcookie("login_error", "", time() - 86400, "/"); //unset the login error cookie each time log in attempt is made

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
						//Get the id of the user from the database, set the user cookie to the value of the id (non-identifiable info)
						$id_get = "SELECT iduser FROM user WHERE username = '".$_POST["username"]."';";
						if($id_get_result = mysqli_query($con, $id_get)) {
							$id = mysqli_fetch_array($id_get_result)[0];
							setcookie("user", $id, time() + 86400, "/"); //user cookie has value of user's id.
							
							//set the users last-login date
							$set_last_login = "UPDATE user SET last_login=now() WHERE iduser='".$id."';";
							if(!($last_login = mysqli_query($con, $set_last_login))) {
								//last login could not be set
								echo("Last login could not be set.");
								echo mysqli_error($con);
							}
						} else {
							echo("User ID not found.");
							echo mysqli_error($con);
						}
						
					} else { //user exists but password is incorrect
						setcookie("login_error", "Incorrect username or password.", time() + 86400, "/");
					}
					
				} else {
					echo("Password not found.");
					echo mysqli_error($con);
				}
					
			} else { //provided username not found in database
				setcookie("login_error", "Incorrect username or password.", time() + 86400, "/");
			}
			
		} else {
			echo("No result.");
			echo mysqli_error($con);
		}
	
	} else { //fields left blank
		setcookie("login_error", "You left one or more fields blank.", time() + 86400, "/");
	}
	include "scripts/db_close.php";
	header("Location: index.php"); //redirect back to index

?>