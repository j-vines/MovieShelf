<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Create a new review in the database
	$_POST["id"] - id of film associated with review
	$_POST["review"] - the text of the review to be posted
*/
	include("db_connect.php");
	//post review
	$review = mysqli_real_escape_string($con, $_POST["review"]);

	$insert = "INSERT INTO review (review_film, review_text, posted_date, time_shared) VALUES (".$_POST["id"].", '".$review."', now(), now());";
	if(!($result = mysqli_query($con, $insert))) {
		echo("Failed to post review");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>