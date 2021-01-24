<?php
	include "scripts/db_connect.php";
	$user_search = "SELECT display_name, iduser, username FROM user WHERE display_name LIKE '% ".$_POST["search"]."' OR display_name LIKE '".$_POST["search"]." %' OR display_name LIKE '".$_POST["search"]."%';";
	if($user_search_result = mysqli_query($con, $user_search)) {
		
	} else {
		echo("No result.");
		echo mysqli_error();
	}

?>