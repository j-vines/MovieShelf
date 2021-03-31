<?php
	include("db_connect.php");
	//delete film from filmshelf table
	$film_remove = "DELETE FROM filmshelf WHERE filmshelf_film = ".$_POST["filmId"].";";
	if(!($remove_result = mysqli_query($con, $film_remove))) {
		echo("Failed to remove film from shelves");
		echo mysqli_error($con);
	}

	//delete film from film table
	$film_remove = "DELETE FROM film WHERE idfilm = ".$_POST["filmId"].";";
	if(!($remove_result = mysqli_query($con, $film_remove))) {
		echo("Failed to remove film");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>