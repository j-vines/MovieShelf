<?php
	include("db_connect.php");

	$film_remove = "DELETE FROM film WHERE idfilm = ".$_POST["filmId"].";";
	if(!($remove_result = mysqli_query($con, $film_remove))) {
		echo("Failed to remove film");
		echo mysqli_error($con);
	} else {
		include("db_close.php");
		header("Location: ../profile.php");
	}

	include("db_close.php");
?>