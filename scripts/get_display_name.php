<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	//Use user id to look for user display name. If display name not found, default to user name
	include "db_connect.php";
			
	$display_search = "SELECT display_name FROM user WHERE iduser ='".$_COOKIE["user"]."';";
	if($display_search_result = mysqli_query($con, $display_search)) {
		$display_name = mysqli_fetch_array($display_search_result)[0];
	} else {
		echo("No result.");
		echo mysqli_error();
	}

	include "db_close.php";
?>