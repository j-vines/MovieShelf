<?php
	include "db_connect.php";

	if(isset($_POST["follow"]) || isset($_POST["unfollow"])) {
		$userid = $_POST["userid"];
	} else {
		$userid = $_GET["userid"];
	}
	
	//unfollow/follow functions
	if(isset($_POST["follow"])) {
		$follow = "INSERT INTO following (following_user, followed_user) VALUES (".$_COOKIE["user"].", ".$userid.");";
		if(!($follow_result = mysqli_query($con, $follow))) {
			echo("No result.");
			echo mysqli_error();
		}
	}
	else if(isset($_POST["unfollow"])) {
		$unfollow = "DELETE FROM following WHERE following_user = ".$_COOKIE["user"]." AND followed_user = ".$userid.";";
		if(!($unfollow_result = mysqli_query($con, $unfollow))) {
			echo("No result.");
			echo mysqli_error($con);
		}
	}


	//Get display name of user whose profile you are visiting
	
	$display_search = "SELECT display_name FROM user WHERE iduser ='".$userid."';";
	if($display_search_result = mysqli_query($con, $display_search)) {
		$display_name = mysqli_fetch_array($display_search_result)[0]; //display name stored as $display_name
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get bio of user whose profile you are visiting
	$bio_search = "SELECT bio FROM user WHERE iduser ='".$userid."';";
	if($bio_search_result = mysqli_query($con, $bio_search)) {
		$bio = mysqli_fetch_array($bio_search_result)[0]; //bio stored as $bio
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get date joined of user
	$date_search = "SELECT joined FROM user WHERE iduser ='".$userid."';";
	if($date_search_result = mysqli_query($con, $date_search)) {
		$date_joined = mysqli_fetch_array($date_search_result)[0]; //date joined stored as $date_joined
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get last activity date of user
	$lastlogin_search = "SELECT last_login FROM user WHERE iduser ='".$userid."';";
	if($lastlogin_search_result = mysqli_query($con, $lastlogin_search)) {
		$last_login = mysqli_fetch_array($lastlogin_search_result)[0]; //last login stored as $last_login
	} else {
		echo("No result.");
		echo mysqli_error();
	}
	//Get follower count
	$follow_count = "SELECT COUNT(*) FROM following WHERE followed_user = ".$userid.";";
	if($count_result = mysqli_query($con, $follow_count)) {
		$follow_num = mysqli_fetch_array($count_result)[0];
	} else {
		echo("Count could not be performed");
		echo mysqli_error($con);
	}

	//check if you're following user
	$follow_check = "SELECT COUNT(*) FROM following WHERE following_user = ".$_COOKIE["user"]." AND followed_user = ".$userid.";";
	if($check_result = mysqli_query($con, $follow_check)) {
		$following = mysqli_fetch_array($check_result)[0];
	} else {
		echo("Count could not be performed");
		echo mysqli_error($con);
	}

	include "db_close.php";



?>