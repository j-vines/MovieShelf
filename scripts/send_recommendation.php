<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Create a new recommendation in the database */
	include("db_connect.php");
	$message = mysqli_real_escape_string($con, $_POST["message"]);
	$title = mysqli_real_escape_string($con, $_POST["filmTitle"]);
		
	$insert = "INSERT INTO recommendation(user_to, user_from, film_title, film_poster_path, film_release_year, sent_time, message)
					VALUES (".$_POST["userTo"].", ".$_POST["userFrom"].", '".$title."', '".$_POST["filmPosterPath"]."', '".$_POST["filmYear"]."', now(), '".$message."');";
		if(!($result = mysqli_query($con, $insert))) {
			echo("Recommendation could not be inserted");
			echo mysqli_error($con);
			echo ($insert);
		}

	include("db_close.php");
?>