<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Remove a film from a shelf
		$_POST["filmId"] - id of film to be removed
		$_POST["shelfId"] - id of shelf to be removed from
	*/


	include("db_connect.php");

	/* Delete a film from a shelf */
	$shelf_remove = "DELETE FROM filmshelf WHERE filmshelf_film = ".$_POST["filmId"]." AND filmshelf_shelf = ".$_POST["shelfId"].";";
	if(!($shelf_remove_result = mysqli_query($con, $shelf_remove))) {
		echo("Film could not be removed from shelf.");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>