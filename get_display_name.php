<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

//Use user id to look for user display name. If display name not found, default to user name
	include "scripts/db_connect.php";
			
	$display_search = "SELECT display_name FROM user WHERE iduser ='".$_COOKIE["user"]."';";
	if($display_search_result = mysqli_query($con, $display_search)) {
		$display_name = mysqli_fetch_array($display_search_result)[0];
	} else {
		echo("No result.");
		echo mysqli_error($con);
	}
			
	if($display_name == null) { //no display name for this user exists
   		$username_search = "SELECT username FROM user WHERE iduser = '".$_COOKIE["user"]."';";
		if($username_search_result = mysqli_query($con, $username_search)) {
			$username = mysqli_fetch_array($username_search_result)[0]; //use username for display
		} else {
			echo("No result.");
			echo mysqli_error($con);
		}
	} else { //user has a display name
		$username = $display_name; //user display name for display
	}
	include "scripts/db_close.php";
?>