<?php
	include "scripts/db_connect.php";
	
	if ($_POST["rating"] == null) {
		$rating = 0;
	} else {
		$rating = $_POST["rating"];
	}
	$_POST["posterPath"] = mysqli_real_escape_string($con, $_POST["posterPath"]);
	$_POST["title"] = mysqli_real_escape_string($con, $_POST["title"]);
	$film_insert = "INSERT INTO film (film_user, tmdb_id, acquired, poster_path, film_format, title, release_year, rating)
					VALUES (".$_POST["userId"].", ".$_POST["filmId"].", now(), '".$_POST["posterPath"]."', ".$_POST["format"].", '".$_POST["title"]."','".$_POST["releaseDate"]."', ".$rating.");";
	if(!($film_insert_result = mysqli_query($con, $film_insert))) {
		echo("film could not be inserted...");
		echo mysqli_error($con);
		echo("<br>".$film_insert);
	}

	//Get the id of the last inserted film to put it in a shelf if necessary
	$film_insert = "SELECT max(idfilm) FROM film WHERE film_user = ".$_COOKIE["user"].";";
	if($film_insert_result = mysqli_query($con, $film_insert)) {
		$idfilm = mysqli_fetch_array($film_insert_result)[0];
	} else {
		echo("film could not be inserted...");
		echo mysqli_error($con);
		echo("<br>".$film_insert);
	}

	if($_POST["shelf"] != 0) { //user is adding film to a shelf
		$film_insert = "INSERT INTO filmshelf (filmshelf_film, filmshelf_shelf)
					VALUES (".$idfilm.", ".$_POST["shelf"].");";
		if(!($film_insert_result = mysqli_query($con, $film_insert))) {
			echo("film could not be added to provided shelf...");
			echo mysqli_error($con);
			echo("<br>".$film_insert);
		}
	}

	include "scripts/db_close.php";
	header("Location: films.php");

?>