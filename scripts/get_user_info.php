<?php

	//Get display name of user whose profile you are visiting
	include "db_connect.php";
	$display_search = "SELECT display_name FROM user WHERE iduser ='".$_GET["userid"]."';";
	if($display_search_result = mysqli_query($con, $display_search)) {
		$display_name = mysqli_fetch_array($display_search_result)[0]; //display name stored as $display_name
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get bio of user whose profile you are visiting
	$bio_search = "SELECT bio FROM user WHERE iduser ='".$_GET["userid"]."';";
	if($bio_search_result = mysqli_query($con, $bio_search)) {
		$bio = mysqli_fetch_array($bio_search_result)[0]; //bio stored as $bio
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get date joined of user
	$date_search = "SELECT joined FROM user WHERE iduser ='".$_GET["userid"]."';";
	if($date_search_result = mysqli_query($con, $date_search)) {
		$date_joined = mysqli_fetch_array($date_search_result)[0]; //date joined stored as $date_joined
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get last activity date of user
	$lastlogin_search = "SELECT last_login FROM user WHERE iduser ='".$_GET["userid"]."';";
	if($lastlogin_search_result = mysqli_query($con, $lastlogin_search)) {
		$last_login = mysqli_fetch_array($lastlogin_search_result)[0]; //last login stored as $last_login
	} else {
		echo("No result.");
		echo mysqli_error();
	}

	include "db_close.php";



?>