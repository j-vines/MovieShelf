<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Insert a film into a shelf 
		$_POST["filmId"] - the id of the film to be inserted into the shelf
		$_POST["shelfId"] - the id of the shelf to be inserted into
	*/

	include("db_connect.php");

	$shelf_insert = "INSERT INTO filmshelf (filmshelf_film, filmshelf_shelf) VALUES (".$_POST["filmId"].", '".$_POST["shelfId"]."');";
	if(!($shelf_insert_result = mysqli_query($con, $shelf_insert))) {
		echo("Film could not be added to shelf.");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>