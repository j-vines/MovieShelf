<?php
	include "scripts/db_connect.php";
	$user_search = "SELECT display_name, iduser, username FROM user WHERE display_name LIKE '% ".$_GET["search"]."' OR display_name LIKE '".$_GET["search"]." %' OR display_name LIKE '".$_GET["search"]."%';";
	if(!($user_search_result = mysqli_query($con, $user_search))) { //search was unsuccessful
		echo("No result.");
		echo mysqli_error($con);
	}
	include "scripts/db_close.php";
?>