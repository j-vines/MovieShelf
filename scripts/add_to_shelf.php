<?php
	include("db_connect.php");

	/* Add film to a shelf */
	$shelf_insert = "INSERT INTO filmshelf (filmshelf_film, filmshelf_shelf) VALUES (".$_POST["filmId"].", '".$_POST["shelfId"]."');";
	if(!($shelf_insert_result = mysqli_query($con, $shelf_insert))) {
		echo("Film could not be added to shelf.");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>