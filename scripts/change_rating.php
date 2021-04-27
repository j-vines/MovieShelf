<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Modify the star rating of a film in the film table
		$_POST["rating"] - the number representing the new rating (0 - 5)
		$_POST["ratingId"] - the id of the film whose rating is to be updated
	*/


	include("db_connect.php");
	
	$rating_update = "UPDATE film SET rating = ".$_POST["rating"]." WHERE idfilm = ".$_POST["ratingId"].";";
	if($update_result = mysqli_query($con, $rating_update)) {
			
	} else {
		echo("Rating could not be updated.");
		echo mysqli_error($con);
		echo($rating_update);
	}
	

	include("db_close.php");

?>