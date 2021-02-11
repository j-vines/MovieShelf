<?php
	include "scripts/db_connect.php";
	
	$film_insert = "INSERT INTO film (film_user, tmdb_id, acquired, poster_path, film_format, title, release_year)
					VALUES (".$_POST["userId"].", ".$_POST["filmId"].", now(), '".$_POST["posterPath"]."', ".$_POST["format"].", '".$_POST["title"]."','".$_POST["releaseDate"]."');";
	if(!($film_insert_result = mysqli_query($con, $film_insert))) {
		echo("film could not be inserted...");
		echo mysqli_error($con);
		echo("<br>".$film_insert);
	}

	include "scripts/db_close.php";
	header("Location: films.php");

?>