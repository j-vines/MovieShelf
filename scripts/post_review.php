<?php
	include("db_connect.php");
	//post review
	$review = mysqli_real_escape_string($con, $_POST["review"]);

	$insert = "INSERT INTO review (review_film, review_text, posted_date) VALUES (".$_POST["id"].", '".$review."', now());";
	if(!($result = mysqli_query($con, $insert))) {
		echo("Failed to post review");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>